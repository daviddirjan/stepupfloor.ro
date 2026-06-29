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
            'create'       => $this->create(),
            'store'        => $this->store(),
            'edit'         => $this->edit($id),
            'update'       => $this->update($id),
            'delete'       => $this->delete($id),
            'delete-image' => $this->deleteImage($id, isset($parts[4]) ? (int)$parts[4] : 0),
            default        => $this->index(),
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
            'pageTitle'  => 'Produs nou',
            'product'    => $this->emptyProduct(),
            'categories' => $this->categoryModel->getAll(),
            'errors'     => [],
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
                'errors'        => $errors,
            ]);
            return;
        }

        $newId = $this->model->create($data);
        $this->handleGalleryUploads($newId);
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
                'errors'        => $errors,
            ]);
            return;
        }

        $this->model->update($id, $data);
        $this->handleGalleryUploads($id);
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
        $wpRaw = trim($_POST['weight_per_m2'] ?? '');
        $ppRaw = trim($_POST['price_per_m2'] ?? '');

        $data = [
            'name'         => trim($_POST['name'] ?? ''),
            'slug'         => trim($_POST['slug'] ?? ''),
            'category_id'  => (int) ($_POST['category_id'] ?? 0),
            'price_label'  => trim($_POST['price_label'] ?? ''),
            'heading'      => trim($_POST['heading'] ?? ''),
            'description'  => trim($_POST['description'] ?? ''),
            'badge'        => trim($_POST['badge'] ?? ''),
            'is_featured'  => isset($_POST['is_featured']) ? 1 : 0,
            'sort_order'   => (int) ($_POST['sort_order'] ?? 0),
            'image'        => '',
            'thickness'    => trim($_POST['thickness'] ?? ''),
            'color'        => trim($_POST['color'] ?? ''),
            'weight_per_m2'=> $wpRaw !== '' ? (float)str_replace(',', '.', $wpRaw) : null,
            'price_per_m2' => $ppRaw !== '' ? (float)str_replace(',', '.', $ppRaw) : null,
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
