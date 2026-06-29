<?php

class AdminCategoryController
{
    private CategoryModel $model;

    public function __construct()
    {
        $this->model = new CategoryModel();
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
        $this->render('admin/categories/index', [
            'pageTitle'  => 'Categorii',
            'categories' => $this->model->getAll(),
        ]);
    }

    private function create(): void
    {
        $this->render('admin/categories/form', [
            'pageTitle' => 'Categorie nouă',
            'category'  => ['id' => 0, 'name' => '', 'slug' => '', 'sort_order' => 0],
            'errors'    => [],
        ]);
    }

    private function store(): void
    {
        $this->requirePost();
        $this->verifyCsrf();

        [$name, $slug, $sortOrder, $errors] = $this->validate(0);

        if ($errors) {
            $this->render('admin/categories/form', [
                'pageTitle' => 'Categorie nouă',
                'category'  => ['id' => 0, 'name' => $name, 'slug' => $slug, 'sort_order' => $sortOrder],
                'errors'    => $errors,
            ]);
            return;
        }

        $this->model->create($name, $slug, $sortOrder);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Categoria a fost creată.'];
        $this->redirect('admin/categories');
    }

    private function edit(int $id): void
    {
        $category = $this->model->findById($id);
        if (!$category) { http_response_code(404); echo '<h1>404</h1>'; return; }

        $this->render('admin/categories/form', [
            'pageTitle' => 'Editează categoria',
            'category'  => $category,
            'errors'    => [],
        ]);
    }

    private function update(int $id): void
    {
        $this->requirePost();
        $this->verifyCsrf();

        [$name, $slug, $sortOrder, $errors] = $this->validate($id);

        if ($errors) {
            $this->render('admin/categories/form', [
                'pageTitle' => 'Editează categoria',
                'category'  => ['id' => $id, 'name' => $name, 'slug' => $slug, 'sort_order' => $sortOrder],
                'errors'    => $errors,
            ]);
            return;
        }

        $this->model->update($id, $name, $slug, $sortOrder);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Categoria a fost actualizată.'];
        $this->redirect('admin/categories');
    }

    private function delete(int $id): void
    {
        $this->requirePost();
        $this->verifyCsrf();
        $this->model->delete($id);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Categoria a fost ștearsă.'];
        $this->redirect('admin/categories');
    }

    private function validate(int $excludeId): array
    {
        $name      = trim($_POST['name'] ?? '');
        $slug      = trim($_POST['slug'] ?? '') ?: CategoryModel::makeSlug($name);
        $sortOrder = (int) ($_POST['sort_order'] ?? 0);
        $errors    = [];

        if ($name === '') $errors[] = 'Numele este obligatoriu.';
        if ($slug === '') $errors[] = 'Slug-ul este obligatoriu.';
        if ($this->model->slugExists($slug, $excludeId)) $errors[] = 'Acest slug există deja.';

        return [$name, $slug, $sortOrder, $errors];
    }

    private function requirePost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'admin/categories'); exit;
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
