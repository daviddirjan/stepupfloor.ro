<?php

class ContactController
{
    private ContactModel $contactModel;

    public function __construct()
    {
        $this->contactModel = new ContactModel();
    }

    public function submit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL);
            exit;
        }

        $name    = trim(strip_tags($_POST['name']    ?? ''));
        $phone   = trim(strip_tags($_POST['phone']   ?? ''));
        $email   = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '');
        $message = trim(strip_tags($_POST['message'] ?? ''));

        $errors = [];
        if ($name === '')                        $errors[] = 'Numele este obligatoriu.';
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL))
                                                 $errors[] = 'Adresa de email nu este validă.';
        if ($message === '')                     $errors[] = 'Mesajul este obligatoriu.';

        if ($errors) {
            $_SESSION['contact_errors']  = $errors;
            $_SESSION['contact_old']     = compact('name', 'phone', 'email', 'message');
            header('Location: ' . BASE_URL . '#contact');
            exit;
        }

        $this->contactModel->save($name, $phone, $email, $message);

        $_SESSION['contact_success'] = 'Mesajul a fost trimis. Vă vom contacta în cel mai scurt timp!';
        header('Location: ' . BASE_URL . '#contact');
        exit;
    }
}
