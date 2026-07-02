<?php

class AdminProductController
{
    private ProductModel  $model;
    private CategoryModel $categoryModel;

    public function __construct()
    {
        $this->model         = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function dispatch(array $parts): void
    {
        $action = $parts[2] ?? 'index';
        $id     = isset($parts[3]) ? (int) $parts[3] : 0;

        match ($action) {
            'create'              => $this->create(),
            'store'               => $this->store(),
            'edit'                => $this->edit($id),
            'update'              => $this->update($id),
            'delete'              => $this->delete($id),
            'delete-image'        => $this->deleteImage($id, isset($parts[4]) ? (int)$parts[4] : 0),
            'delete-color-image'  => $this->deleteColorImage(
                                         $id,
                                         isset($parts[4]) ? (int)$parts[4] : 0,
                                         isset($parts[5]) ? (int)$parts[5] : 1
                                     ),
            default               => $this->index(),
        };
    }

    private function index(): void
    {
        $this->render('admin/products/index', [
            'pageTitle' => 'Produse',
            'products'  => $this->model->getAllWithCategory(),
        ]);
    }

    private function create(): void
    {
        $this->render('admin/products/form', [
            'pageTitle'     => 'Produs nou',
            'product'       => $this->emptyProduct(),
            'categories'    => $this->categoryModel->getAll(),
            'galleryImages' => [],
            'colorVariants' => [],
            'errors'        => [],
        ]);
    }

    private function store(): void
    {
        $this->requirePost();
        $this->verifyCsrf();

        [$data, $errors] = $this->validate(0);

        $uploadedFile = $this->handleUpload('image', 'assets/images/products/');
        if ($uploadedFile !== false) {
            $data['image'] = $uploadedFile;
        }

        if ($errors) {
            $this->render('admin/products/form', [
                'pageTitle'     => 'Produs nou',
                'product'       => array_merge($this->emptyProduct(), $data),
                'categories'    => $this->categoryModel->getAll(),
                'galleryImages' => [],
                'colorVariants' => [],
                'errors'        => $errors,
            ]);
            return;
        }

        $newId = $this->model->create($data);
        $this->handleGalleryUploads($newId);
        $this->handleColorVariants($newId);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Produsul a fost creat.'];
        $this->redirect('admin/products');
    }

    private function edit(int $id): void
    {
        $product = $this->model->findById($id);
        if (!$product) { http_response_code(404); echo '<h1>404</h1>'; return; }

        $this->render('admin/products/form', [
            'pageTitle'     => 'Editează produsul',
            'product'       => $product,
            'categories'    => $this->categoryModel->getAll(),
            'galleryImages' => (new ProductImageModel())->getByProductId($id),
            'colorVariants' => (new ProductColorModel())->getByProductId($id),
            'errors'        => [],
        ]);
    }

    private function update(int $id): void
    {
        $this->requirePost();
        $this->verifyCsrf();

        $existing = $this->model->findById($id);
        if (!$existing) { http_response_code(404); echo '<h1>404</h1>'; return; }

        [$data, $errors] = $this->validate($id);

        $uploadedFile = $this->handleUpload('image', 'assets/images/products/');
        if ($uploadedFile !== false) {
            if ($existing['image'] && file_exists(BASE_PATH . '/assets/images/products/' . $existing['image'])) {
                unlink(BASE_PATH . '/assets/images/products/' . $existing['image']);
            }
            $data['image'] = $uploadedFile;
        } else {
            $data['image'] = $existing['image'];
        }

        if ($errors) {
            $this->render('admin/products/form', [
                'pageTitle'     => 'Editează produsul',
                'product'       => array_merge($existing, $data, ['id' => $id]),
                'categories'    => $this->categoryModel->getAll(),
                'galleryImages' => (new ProductImageModel())->getByProductId($id),
                'colorVariants' => (new ProductColorModel())->getByProductId($id),
                'errors'        => $errors,
            ]);
            return;
        }

        $this->model->update($id, $data);
        $this->handleGalleryUploads($id);
        $this->handleColorVariants($id);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Produsul a fost actualizat.'];
        $this->redirect('admin/products');
    }

    private function delete(int $id): void
    {
        $this->requirePost();
        $this->verifyCsrf();

        $existing = $this->model->findById($id);
        if ($existing && $existing['image']) {
            $path = BASE_PATH . '/assets/images/products/' . $existing['image'];
            if (file_exists($path)) unlink($path);
        }

        $imgModel = new ProductImageModel();
        foreach ($imgModel->getByProductId($id) as $img) {
            $path = BASE_PATH . '/assets/images/products/' . $img['filename'];
            if (file_exists($path)) unlink($path);
        }

        $colorModel = new ProductColorModel();
        foreach ($colorModel->getByProductId($id) as $color) {
            if ($color['image']) {
                $path = BASE_PATH . '/assets/images/products/' . $color['image'];
                if (file_exists($path)) unlink($path);
            }
        }

        $this->model->delete($id);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Produsul a fost șters.'];
        $this->redirect('admin/products');
    }

    private function deleteImage(int $productId, int $imageId): void
    {
        $this->requirePost();
        $this->verifyCsrf();

        $imgModel = new ProductImageModel();
        $img = $imgModel->findById($imageId);
        if ($img && (int)$img['product_id'] === $productId) {
            $path = BASE_PATH . '/assets/images/products/' . $img['filename'];
            if (file_exists($path)) unlink($path);
            $imgModel->delete($imageId);
        }

        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Imaginea a fost ștearsă.'];
        $this->redirect('admin/products/edit/' . $productId);
    }

    private function validate(int $excludeId): array
    {
        $wpRaw     = trim($_POST['weight_per_m2'] ?? '');
        $ppRaw     = trim($_POST['price_per_m2'] ?? '');
        $ratingRaw = trim($_POST['rating'] ?? '');

        $data = [
            'name'          => trim($_POST['name'] ?? ''),
            'slug'          => trim($_POST['slug'] ?? ''),
            'category_id'   => (int) ($_POST['category_id'] ?? 0),
            'price_label'   => trim($_POST['price_label'] ?? ''),
            'heading'       => trim($_POST['heading'] ?? ''),
            'description'   => trim($_POST['description'] ?? ''),
            'badge'         => trim($_POST['badge'] ?? ''),
            'is_featured'   => isset($_POST['is_featured']) ? 1 : 0,
            'sort_order'    => (int) ($_POST['sort_order'] ?? 0),
            'image'         => '',
            'thickness'     => trim($_POST['thickness'] ?? ''),
            'color'         => trim($_POST['color'] ?? ''),
            'weight_per_m2' => $wpRaw !== '' ? (float)str_replace(',', '.', $wpRaw) : null,
            'price_per_m2'  => $ppRaw !== '' ? (float)str_replace(',', '.', $ppRaw) : null,
            'usage_class'   => trim($_POST['usage_class'] ?? ''),
            'warranty'      => trim($_POST['warranty'] ?? ''),
            'rating'        => $ratingRaw !== '' ? (float)str_replace(',', '.', $ratingRaw) : null,
            'reviews_count' => (int) ($_POST['reviews_count'] ?? 0),
            'discount_label'=> trim($_POST['discount_label'] ?? ''),
        ];

        if ($data['slug'] === '') {
            $data['slug'] = CategoryModel::makeSlug($data['name']);
        }

        // sync old category text from selected category name
        if ($data['category_id']) {
            $cat = (new CategoryModel())->findById($data['category_id']);
            $data['category'] = $cat ? $cat['name'] : '';
        }

        $errors = [];
        if ($data['name'] === '') $errors[] = 'Numele este obligatoriu.';
        if ($data['slug'] === '') $errors[] = 'Slug-ul este obligatoriu.';

        return [$data, $errors];
    }

    private function handleUpload(string $inputName, string $targetDir, int $index = -1): string|false
    {
        $tmp  = $index >= 0 ? ($_FILES[$inputName]['tmp_name'][$index] ?? '') : ($_FILES[$inputName]['tmp_name'] ?? '');
        $size = $index >= 0 ? ($_FILES[$inputName]['size'][$index] ?? 0)     : ($_FILES[$inputName]['size'] ?? 0);
        $name = $index >= 0 ? ($_FILES[$inputName]['name'][$index] ?? '')    : ($_FILES[$inputName]['name'] ?? '');

        if (empty($tmp)) return false;
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        $mime    = mime_content_type($tmp);
        if (!in_array($mime, $allowed, true)) return false;
        if ($size > 3 * 1024 * 1024) return false;
        $ext      = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $filename = uniqid('img_', true) . '.' . $ext;
        $dest     = BASE_PATH . '/' . $targetDir . $filename;
        if (!move_uploaded_file($tmp, $dest)) return false;
        return $filename;
    }

    private function deleteColorImage(int $productId, int $colorId, int $slot = 1): void
    {
        $this->requirePost();
        $this->verifyCsrf();

        $colorModel = new ProductColorModel();
        $color      = $colorModel->findById($colorId);
        $imageField = $slot > 1 ? 'image' . $slot : 'image';

        if ($color && (int)$color['product_id'] === $productId && !empty($color[$imageField])) {
            $path = BASE_PATH . '/assets/images/products/' . $color[$imageField];
            if (file_exists($path)) unlink($path);
            $colorModel->updateImage($colorId, '', $slot);
        }

        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Imaginea culorii a fost ștearsă.'];
        $this->redirect('admin/products/edit/' . $productId);
    }

    private function handleColorVariants(int $productId): void
    {
        $colors = $_POST['colors'] ?? [];
        if (!is_array($colors)) return;

        $colorModel  = new ProductColorModel();
        $existing    = $colorModel->getByProductId($productId);
        $existingIds = array_column($existing, 'id');
        $keptIds     = [];

        foreach ($colors as $i => $row) {
            $name     = trim($row['name'] ?? '');
            $code     = trim($row['code'] ?? '');
            $hexColor = trim($row['hex_color'] ?? '');
            $delete   = !empty($row['_delete']);

            if ($name === '' && !isset($row['id'])) continue;

            $uploadedImage  = $this->handleColorImageUpload('color_images', $i);
            $uploadedImage2 = $this->handleColorImageUpload('color_images2', $i);
            $uploadedImage3 = $this->handleColorImageUpload('color_images3', $i);
            $uploadedImage4 = $this->handleColorImageUpload('color_images4', $i);

            if (isset($row['id']) && $row['id'] !== '') {
                $colorId = (int)$row['id'];

                if ($delete) {
                    $color = $colorModel->findById($colorId);
                    if ($color) {
                        foreach (['image', 'image2', 'image3', 'image4'] as $imgField) {
                            if (!empty($color[$imgField])) {
                                $path = BASE_PATH . '/assets/images/products/' . $color[$imgField];
                                if (file_exists($path)) unlink($path);
                            }
                        }
                    }
                    $colorModel->delete($colorId);
                } else {
                    $color = $colorModel->findById($colorId);

                    $currentImage  = $this->swapColorImage($color, 'image', $uploadedImage);
                    $currentImage2 = $this->swapColorImage($color, 'image2', $uploadedImage2);
                    $currentImage3 = $this->swapColorImage($color, 'image3', $uploadedImage3);
                    $currentImage4 = $this->swapColorImage($color, 'image4', $uploadedImage4);

                    $colorModel->update(
                        $colorId, $name, $code, $hexColor,
                        $currentImage, $currentImage2, $currentImage3, $currentImage4,
                        $i
                    );
                    $keptIds[] = $colorId;
                }
            } else {
                if (!$delete && $name !== '') {
                    $colorModel->create(
                        $productId, $name, $code, $hexColor,
                        $uploadedImage ?: '', $uploadedImage2 ?: '',
                        $uploadedImage3 ?: '', $uploadedImage4 ?: '',
                        $i
                    );
                }
            }
        }

        foreach ($existingIds as $existingId) {
            if (!in_array($existingId, $keptIds, true)) {
                $found = false;
                foreach ($colors as $row) {
                    if (isset($row['id']) && (int)$row['id'] === $existingId) {
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $color = $colorModel->findById($existingId);
                    if ($color) {
                        foreach (['image', 'image2', 'image3', 'image4'] as $imgField) {
                            if (!empty($color[$imgField])) {
                                $path = BASE_PATH . '/assets/images/products/' . $color[$imgField];
                                if (file_exists($path)) unlink($path);
                            }
                        }
                    }
                    $colorModel->delete($existingId);
                }
            }
        }
    }

    private function swapColorImage(?array $color, string $field, string|false $uploaded): string
    {
        $current = $color[$field] ?? '';
        if ($uploaded !== false) {
            if ($current) {
                $path = BASE_PATH . '/assets/images/products/' . $current;
                if (file_exists($path)) unlink($path);
            }
            return $uploaded;
        }
        return $current;
    }

    private function handleColorImageUpload(string $inputName, int $index): string|false
    {
        $tmp  = $_FILES[$inputName]['tmp_name'][$index] ?? '';
        $size = $_FILES[$inputName]['size'][$index] ?? 0;
        $name = $_FILES[$inputName]['name'][$index] ?? '';

        if (empty($tmp)) return false;
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        $mime    = mime_content_type($tmp);
        if (!in_array($mime, $allowed, true)) return false;
        if ($size > 3 * 1024 * 1024) return false;
        $ext      = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $filename = uniqid('color_', true) . '.' . $ext;
        $dest     = BASE_PATH . '/assets/images/products/' . $filename;
        if (!move_uploaded_file($tmp, $dest)) return false;
        return $filename;
    }

    private function handleGalleryUploads(int $productId): void
    {
        if (empty($_FILES['images']['tmp_name'])) return;
        $imgModel = new ProductImageModel();
        $existing = count($imgModel->getByProductId($productId));
        foreach ($_FILES['images']['tmp_name'] as $i => $tmp) {
            if (empty($tmp)) continue;
            $filename = $this->handleUpload('images', 'assets/images/products/', $i);
            if ($filename !== false) {
                $imgModel->create($productId, $filename, $existing + $i);
            }
        }
    }

    private function emptyProduct(): array
    {
        return [
            'id'=>0,'slug'=>'','name'=>'','category'=>'','category_id'=>0,'price_label'=>'',
            'heading'=>'','description'=>'','badge'=>'','image'=>'','is_featured'=>0,'sort_order'=>0,
            'thickness'=>'','color'=>'','weight_per_m2'=>'','price_per_m2'=>'',
            'usage_class'=>'','warranty'=>'','rating'=>null,'reviews_count'=>0,'discount_label'=>'',
        ];
    }

    private function requirePost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'admin/products'); exit;
        }
    }

    private function verifyCsrf(): void
    {
        if (($_POST['csrf_token'] ?? '') !== ($_SESSION['csrf_token'] ?? '')) {
            http_response_code(403); echo 'Invalid CSRF token.'; exit;
        }
    }

    private function render(string $view, array $data = []): void
    {
        extract($data);
        $content = BASE_PATH . '/views/' . $view . '.php';
        require BASE_PATH . '/views/layouts/admin.php';
    }

    private function redirect(string $path): void
    {
        header('Location: ' . BASE_URL . ltrim($path, '/')); exit;
    }
}
