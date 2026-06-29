<?php

class AdminBlogController
{
    private BlogPostModel $model;

    public function __construct()
    {
        $this->model = new BlogPostModel();
    }

    public function dispatch(array $parts): void
    {
        $action = $parts[2] ?? 'index';
        $id     = isset($parts[3]) ? (int) $parts[3] : 0;

        match ($action) {
            'create' => $this->create(),
            'store'  => $this->store(),
            'edit'   => $this->edit($id),
            'update' => $this->update($id),
            'delete' => $this->delete($id),
            default  => $this->index(),
        };
    }

    private function index(): void
    {
        $this->render('admin/blog/index', [
            'pageTitle' => 'Articole Blog',
            'posts'     => $this->model->getAll(),
        ]);
    }

    private function create(): void
    {
        $this->render('admin/blog/form', [
            'pageTitle' => 'Articol nou',
            'post'      => $this->emptyPost(),
            'errors'    => [],
        ]);
    }

    private function store(): void
    {
        $this->requirePost();
        $this->verifyCsrf();
        [$data, $errors] = $this->validate(0);

        $uploadedFile = $this->handleUpload('image', 'assets/images/blog/');
        if ($uploadedFile !== false) $data['image'] = $uploadedFile;

        if ($errors) {
            $this->render('admin/blog/form', [
                'pageTitle' => 'Articol nou',
                'post'      => array_merge($this->emptyPost(), $data),
                'errors'    => $errors,
            ]);
            return;
        }

        $this->model->create($data);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Articolul a fost creat.'];
        $this->redirect('admin/blog');
    }

    private function edit(int $id): void
    {
        $post = $this->model->findById($id);
        if (!$post) { http_response_code(404); echo '<h1>404</h1>'; return; }

        $this->render('admin/blog/form', [
            'pageTitle' => 'Editează articol',
            'post'      => $post,
            'errors'    => [],
        ]);
    }

    private function update(int $id): void
    {
        $this->requirePost();
        $this->verifyCsrf();

        $existing = $this->model->findById($id);
        if (!$existing) { http_response_code(404); echo '<h1>404</h1>'; return; }

        [$data, $errors] = $this->validate($id);

        $uploadedFile = $this->handleUpload('image', 'assets/images/blog/');
        if ($uploadedFile !== false) {
            if ($existing['image'] && file_exists(BASE_PATH . '/assets/images/blog/' . $existing['image'])) {
                unlink(BASE_PATH . '/assets/images/blog/' . $existing['image']);
            }
            $data['image'] = $uploadedFile;
        } else {
            $data['image'] = $existing['image'];
        }

        if ($errors) {
            $this->render('admin/blog/form', [
                'pageTitle' => 'Editează articol',
                'post'      => array_merge($existing, $data, ['id' => $id]),
                'errors'    => $errors,
            ]);
            return;
        }

        $this->model->update($id, $data);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Articolul a fost actualizat.'];
        $this->redirect('admin/blog');
    }

    private function delete(int $id): void
    {
        $this->requirePost();
        $this->verifyCsrf();

        $existing = $this->model->findById($id);
        if ($existing && $existing['image']) {
            $path = BASE_PATH . '/assets/images/blog/' . $existing['image'];
            if (file_exists($path)) unlink($path);
        }

        $this->model->delete($id);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Articolul a fost șters.'];
        $this->redirect('admin/blog');
    }

    private function validate(int $excludeId): array
    {
        $data = [
            'title'        => trim($_POST['title'] ?? ''),
            'slug'         => trim($_POST['slug'] ?? ''),
            'excerpt'      => trim($_POST['excerpt'] ?? ''),
            'body'         => trim($_POST['body'] ?? ''),
            'is_published' => isset($_POST['is_published']) ? 1 : 0,
            'published_at' => trim($_POST['published_at'] ?? ''),
            'image'        => '',
        ];

        if ($data['slug'] === '') $data['slug'] = CategoryModel::makeSlug($data['title']);

        $errors = [];
        if ($data['title'] === '') $errors[] = 'Titlul este obligatoriu.';
        if ($data['body'] === '')  $errors[] = 'Conținutul este obligatoriu.';
        if ($this->model->slugExists($data['slug'], $excludeId)) $errors[] = 'Acest slug există deja.';

        return [$data, $errors];
    }

    private function handleUpload(string $inputName, string $targetDir): string|false
    {
        if (empty($_FILES[$inputName]['tmp_name'])) return false;
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        $mime    = mime_content_type($_FILES[$inputName]['tmp_name']);
        if (!in_array($mime, $allowed, true)) return false;
        if ($_FILES[$inputName]['size'] > 3 * 1024 * 1024) return false;
        $ext      = strtolower(pathinfo($_FILES[$inputName]['name'], PATHINFO_EXTENSION));
        $filename = uniqid('img_', true) . '.' . $ext;
        $dest     = BASE_PATH . '/' . $targetDir . $filename;
        if (!move_uploaded_file($_FILES[$inputName]['tmp_name'], $dest)) return false;
        return $filename;
    }

    private function emptyPost(): array
    {
        return ['id'=>0,'title'=>'','slug'=>'','excerpt'=>'','body'=>'','image'=>'','is_published'=>0,'published_at'=>''];
    }

    private function requirePost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'admin/blog'); exit;
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
