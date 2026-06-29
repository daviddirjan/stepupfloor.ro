<?php

class AdminProjectController
{
    private ProjectModel $model;

    private const ALL_TAGS = [
        'Rezidențial', 'Comercial', 'Industrial',
        'Mochete', 'LVT', 'Covoare PVC', 'Dale Modulare',
    ];

    public function __construct()
    {
        $this->model = new ProjectModel();
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
        $this->render('admin/projects/index', [
            'pageTitle' => 'Proiecte',
            'projects'  => $this->model->getAll(),
        ]);
    }

    private function create(): void
    {
        $this->render('admin/projects/form', [
            'pageTitle' => 'Proiect nou',
            'project'   => $this->emptyProject(),
            'allTags'   => self::ALL_TAGS,
            'errors'    => [],
        ]);
    }

    private function store(): void
    {
        $this->requirePost();
        $this->verifyCsrf();
        [$data, $errors] = $this->validate(0);

        $uploaded = $this->handleUpload('image', 'assets/images/projects/');
        if ($uploaded !== false) $data['image'] = $uploaded;

        if ($errors) {
            $this->render('admin/projects/form', [
                'pageTitle' => 'Proiect nou',
                'project'   => array_merge($this->emptyProject(), $data),
                'allTags'   => self::ALL_TAGS,
                'errors'    => $errors,
            ]);
            return;
        }

        $this->model->create($data);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Proiectul a fost creat.'];
        $this->redirect('admin/projects');
    }

    private function edit(int $id): void
    {
        $project = $this->model->findById($id);
        if (!$project) { http_response_code(404); echo '<h1>404</h1>'; return; }

        $this->render('admin/projects/form', [
            'pageTitle' => 'Editează proiect',
            'project'   => $project,
            'allTags'   => self::ALL_TAGS,
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

        $uploaded = $this->handleUpload('image', 'assets/images/projects/');
        if ($uploaded !== false) {
            if ($existing['image'] && file_exists(BASE_PATH . '/assets/images/projects/' . $existing['image'])) {
                unlink(BASE_PATH . '/assets/images/projects/' . $existing['image']);
            }
            $data['image'] = $uploaded;
        } else {
            $data['image'] = $existing['image'];
        }

        if ($errors) {
            $this->render('admin/projects/form', [
                'pageTitle' => 'Editează proiect',
                'project'   => array_merge($existing, $data, ['id' => $id]),
                'allTags'   => self::ALL_TAGS,
                'errors'    => $errors,
            ]);
            return;
        }

        $this->model->update($id, $data);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Proiectul a fost actualizat.'];
        $this->redirect('admin/projects');
    }

    private function delete(int $id): void
    {
        $this->requirePost();
        $this->verifyCsrf();

        $existing = $this->model->findById($id);
        if ($existing && $existing['image']) {
            $path = BASE_PATH . '/assets/images/projects/' . $existing['image'];
            if (file_exists($path)) unlink($path);
        }

        $this->model->delete($id);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Proiectul a fost șters.'];
        $this->redirect('admin/projects');
    }

    private function validate(int $excludeId): array
    {
        $tags = array_values(array_filter(
            array_map('trim', (array)($_POST['tags'] ?? [])),
            fn($t) => in_array($t, self::ALL_TAGS, true)
        ));

        $data = [
            'title'        => trim($_POST['title'] ?? ''),
            'slug'         => trim($_POST['slug'] ?? ''),
            'client'       => trim($_POST['client'] ?? ''),
            'location'     => trim($_POST['location'] ?? ''),
            'surface'      => (int)($_POST['surface'] ?? 0),
            'year'         => (int)($_POST['year'] ?? date('Y')),
            'tags'         => $tags,
            'description'  => trim($_POST['description'] ?? ''),
            'is_published' => isset($_POST['is_published']) ? 1 : 0,
            'image'        => '',
        ];

        if ($data['slug'] === '') $data['slug'] = CategoryModel::makeSlug($data['title']);

        $errors = [];
        if ($data['title'] === '')    $errors[] = 'Titlul este obligatoriu.';
        if ($data['location'] === '') $errors[] = 'Localitatea este obligatorie.';
        if ($data['year'] < 2000)     $errors[] = 'Anul trebuie să fie valid.';
        if ($this->model->slugExists($data['slug'], $excludeId)) $errors[] = 'Acest slug există deja.';

        return [$data, $errors];
    }

    private function handleUpload(string $inputName, string $targetDir): string|false
    {
        if (empty($_FILES[$inputName]['tmp_name'])) return false;
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        $mime    = mime_content_type($_FILES[$inputName]['tmp_name']);
        if (!in_array($mime, $allowed, true)) return false;
        if ($_FILES[$inputName]['size'] > 5 * 1024 * 1024) return false;
        $ext      = strtolower(pathinfo($_FILES[$inputName]['name'], PATHINFO_EXTENSION));
        $filename = uniqid('proj_', true) . '.' . $ext;
        $dir      = BASE_PATH . '/' . $targetDir;
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        if (!move_uploaded_file($_FILES[$inputName]['tmp_name'], $dir . $filename)) return false;
        return $filename;
    }

    private function emptyProject(): array
    {
        return [
            'id' => 0, 'title' => '', 'slug' => '', 'client' => '',
            'location' => '', 'surface' => '', 'year' => date('Y'),
            'image' => '', 'tags' => [], 'description' => '', 'is_published' => 0,
        ];
    }

    private function requirePost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'admin/projects'); exit;
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
