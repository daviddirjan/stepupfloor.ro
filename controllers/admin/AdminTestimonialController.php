<?php

class AdminTestimonialController
{
    private TestimonialModel $model;

    public function __construct()
    {
        $this->model = new TestimonialModel();
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
        $this->render('admin/testimonials/index', [
            'pageTitle'    => 'Testimoniale',
            'testimonials' => $this->model->getAll(),
        ]);
    }

    private function create(): void
    {
        $this->render('admin/testimonials/form', [
            'pageTitle'   => 'Testimonial nou',
            'testimonial' => ['id'=>0,'name'=>'','location'=>'','review_text'=>'','rating'=>5,'sort_order'=>0],
            'errors'      => [],
        ]);
    }

    private function store(): void
    {
        $this->requirePost();
        $this->verifyCsrf();
        [$data, $errors] = $this->validate();

        if ($errors) {
            $this->render('admin/testimonials/form', [
                'pageTitle'   => 'Testimonial nou',
                'testimonial' => array_merge(['id'=>0], $data),
                'errors'      => $errors,
            ]);
            return;
        }

        $this->model->create($data);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Testimonialul a fost adăugat.'];
        $this->redirect('admin/testimonials');
    }

    private function edit(int $id): void
    {
        $testimonial = $this->model->findById($id);
        if (!$testimonial) { http_response_code(404); echo '<h1>404</h1>'; return; }

        $this->render('admin/testimonials/form', [
            'pageTitle'   => 'Editează testimonial',
            'testimonial' => $testimonial,
            'errors'      => [],
        ]);
    }

    private function update(int $id): void
    {
        $this->requirePost();
        $this->verifyCsrf();
        [$data, $errors] = $this->validate();

        if ($errors) {
            $this->render('admin/testimonials/form', [
                'pageTitle'   => 'Editează testimonial',
                'testimonial' => array_merge(['id' => $id], $data),
                'errors'      => $errors,
            ]);
            return;
        }

        $this->model->update($id, $data);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Testimonialul a fost actualizat.'];
        $this->redirect('admin/testimonials');
    }

    private function delete(int $id): void
    {
        $this->requirePost();
        $this->verifyCsrf();
        $this->model->delete($id);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Testimonialul a fost șters.'];
        $this->redirect('admin/testimonials');
    }

    private function validate(): array
    {
        $data   = [
            'name'        => trim($_POST['name'] ?? ''),
            'location'    => trim($_POST['location'] ?? ''),
            'review_text' => trim($_POST['review_text'] ?? ''),
            'rating'      => max(1, min(5, (int)($_POST['rating'] ?? 5))),
            'sort_order'  => (int) ($_POST['sort_order'] ?? 0),
        ];
        $errors = [];
        if ($data['name'] === '')        $errors[] = 'Numele este obligatoriu.';
        if ($data['review_text'] === '') $errors[] = 'Textul recenziei este obligatoriu.';
        return [$data, $errors];
    }

    private function requirePost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'admin/testimonials'); exit;
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
