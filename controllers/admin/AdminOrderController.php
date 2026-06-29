<?php

class AdminOrderController
{
    private OrderModel $model;

    public static array $statuses = ['pending' => 'În așteptare', 'confirmed' => 'Confirmat', 'completed' => 'Finalizat', 'cancelled' => 'Anulat'];

    public function __construct()
    {
        $this->model = new OrderModel();
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
        $this->render('admin/orders/index', [
            'pageTitle' => 'Comenzi',
            'orders'    => $this->model->getAll(),
            'statuses'  => self::$statuses,
        ]);
    }

    private function create(): void
    {
        $this->render('admin/orders/form', [
            'pageTitle' => 'Comandă nouă',
            'order'     => $this->emptyOrder(),
            'statuses'  => self::$statuses,
            'errors'    => [],
        ]);
    }

    private function store(): void
    {
        $this->requirePost();
        $this->verifyCsrf();
        [$data, $errors] = $this->validate();

        if ($errors) {
            $this->render('admin/orders/form', [
                'pageTitle' => 'Comandă nouă',
                'order'     => array_merge($this->emptyOrder(), $data),
                'statuses'  => self::$statuses,
                'errors'    => $errors,
            ]);
            return;
        }

        $this->model->create($data);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Comanda a fost adăugată.'];
        $this->redirect('admin/orders');
    }

    private function edit(int $id): void
    {
        $order = $this->model->findById($id);
        if (!$order) { http_response_code(404); echo '<h1>404</h1>'; return; }

        $this->render('admin/orders/form', [
            'pageTitle' => 'Editează comanda',
            'order'     => $order,
            'statuses'  => self::$statuses,
            'errors'    => [],
        ]);
    }

    private function update(int $id): void
    {
        $this->requirePost();
        $this->verifyCsrf();

        if (!$this->model->findById($id)) { http_response_code(404); echo '<h1>404</h1>'; return; }

        [$data, $errors] = $this->validate();

        if ($errors) {
            $this->render('admin/orders/form', [
                'pageTitle' => 'Editează comanda',
                'order'     => array_merge(['id' => $id], $data),
                'statuses'  => self::$statuses,
                'errors'    => $errors,
            ]);
            return;
        }

        $this->model->update($id, $data);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Comanda a fost actualizată.'];
        $this->redirect('admin/orders');
    }

    private function delete(int $id): void
    {
        $this->requirePost();
        $this->verifyCsrf();
        $this->model->delete($id);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Comanda a fost ștearsă.'];
        $this->redirect('admin/orders');
    }

    private function validate(): array
    {
        $data = [
            'customer_name'  => trim($_POST['customer_name'] ?? ''),
            'customer_email' => trim($_POST['customer_email'] ?? ''),
            'customer_phone' => trim($_POST['customer_phone'] ?? ''),
            'notes'          => trim($_POST['notes'] ?? ''),
            'total'          => str_replace(',', '.', trim($_POST['total'] ?? '0')),
            'status'         => $_POST['status'] ?? 'pending',
        ];

        if (!array_key_exists($data['status'], self::$statuses)) $data['status'] = 'pending';

        $errors = [];
        if ($data['customer_name'] === '') $errors[] = 'Numele clientului este obligatoriu.';
        if (!is_numeric($data['total']))   $errors[] = 'Totalul trebuie să fie o valoare numerică.';

        return [$data, $errors];
    }

    private function emptyOrder(): array
    {
        return ['id'=>0,'customer_name'=>'','customer_email'=>'','customer_phone'=>'','notes'=>'','total'=>'0.00','status'=>'pending'];
    }

    private function requirePost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'admin/orders'); exit;
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
