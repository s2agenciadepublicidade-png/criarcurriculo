<?php

namespace App\Controllers;

use App\Models\PasswordReset;
use App\Models\User;
use App\Support\Auth;
use App\Support\Csrf;
use App\Support\Database;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailException;

class AuthController extends BaseController
{
    private array $config;

    public function __construct()
    {
        $this->config = require __DIR__ . '/../../config/config.php';
    }

    public function showRegister()
    {
        $this->render('auth/register', [
            'title' => 'Criar conta',
            'csrfToken' => Csrf::token(),
        ]);
    }

    public function register()
    {
        $this->ensurePost();
        $this->validateCsrf();

        $name = trim($_POST['name'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? '';
        $terms = isset($_POST['terms']);

        $errors = [];
        if ($name === '') {
            $errors['name'] = 'Informe seu nome completo.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'E-mail inválido.';
        }
        if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
            $errors['password'] = 'A senha deve ter ao menos 8 caracteres, incluindo letra maiúscula e número.';
        }
        if (!$terms) {
            $errors['terms'] = 'É necessário aceitar os termos de uso.';
        }
        if (User::findByEmail($email)) {
            $errors['email'] = 'Já existe uma conta com este e-mail.';
        }

        if (!empty($errors)) {
            $this->render('auth/register', [
                'title' => 'Criar conta',
                'errors' => $errors,
                'old' => compact('name', 'email'),
                'terms' => $terms,
                'csrfToken' => Csrf::token(),
            ]);
            return;
        }

        $userId = User::create([
            'name' => $name,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        $_SESSION['user'] = [
            'id' => $userId,
            'name' => $name,
            'email' => $email,
        ];

        $this->redirect('/dashboard');
    }

    public function showLogin()
    {
        $this->render('auth/login', [
            'title' => 'Entrar',
            'csrfToken' => Csrf::token(),
        ]);
    }

    public function login()
    {
        $this->ensurePost();
        $this->validateCsrf();

        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? '';

        $errors = [];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
            $errors['credentials'] = 'Credenciais inválidas.';
        }

        if (empty($errors) && !Auth::attempt($email, $password)) {
            $errors['credentials'] = 'Não encontramos uma conta com esses dados.';
        }

        if (!empty($errors)) {
            $this->render('auth/login', [
                'title' => 'Entrar',
                'errors' => $errors,
                'old' => compact('email'),
                'csrfToken' => Csrf::token(),
            ]);
            return;
        }

        $this->redirect('/dashboard');
    }

    public function logout()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Método não permitido.');
        }
        if (!Csrf::validate($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('Falha de verificação CSRF.');
        }
        Auth::logout();
        session_regenerate_id(true);
        $this->redirect('/');
    }

    public function showForgotPassword()
    {
        $this->render('auth/forgot-password', [
            'title' => 'Recuperar senha',
            'csrfToken' => Csrf::token(),
        ]);
    }

    public function sendResetLink()
    {
        $this->ensurePost();
        $this->validateCsrf();

        $email = strtolower(trim($_POST['email'] ?? ''));
        $user = User::findByEmail($email);

        $messageSent = false;
        if ($user) {
            $token = bin2hex(random_bytes(32));
            $expiresAt = date('Y-m-d H:i:s', time() + 3600);
            PasswordReset::deleteByUser((int) $user['id']);
            PasswordReset::create((int) $user['id'], $token, $expiresAt);
            $resetLink = $this->config['app']['base_url'] . '/reset-password?token=' . urlencode($token);
            $messageSent = $this->sendMail($email, 'Recuperação de Senha', 'emails/reset-password', [
                'name' => $user['name'],
                'resetLink' => $resetLink,
            ]);
        }

        $this->render('auth/forgot-password', [
            'title' => 'Recuperar senha',
            'status' => $messageSent ? 'Se o e-mail estiver cadastrado, você receberá instruções em alguns minutos.' : 'Não foi possível enviar o e-mail. Tente novamente.',
            'csrfToken' => Csrf::token(),
        ]);
    }

    public function showResetPassword()
    {
        $token = $_GET['token'] ?? '';
        $this->render('auth/reset-password', [
            'title' => 'Definir nova senha',
            'token' => $token,
            'csrfToken' => Csrf::token(),
        ]);
    }

    public function resetPassword()
    {
        $this->ensurePost();
        $this->validateCsrf();

        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';

        $errors = [];
        if (strlen($password) < 8) {
            $errors['password'] = 'A senha deve ter pelo menos 8 caracteres.';
        }

        $reset = PasswordReset::findValid($token);
        if (!$reset) {
            $errors['token'] = 'Token inválido ou expirado.';
        }

        if (!empty($errors)) {
            $this->render('auth/reset-password', [
                'title' => 'Definir nova senha',
                'errors' => $errors,
                'token' => $token,
                'csrfToken' => Csrf::token(),
            ]);
            return;
        }

        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('UPDATE users SET password_hash = :password, updated_at = :updated_at WHERE id = :id');
        $stmt->execute([
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':updated_at' => date('Y-m-d H:i:s'),
            ':id' => $reset['user_id'],
        ]);

        PasswordReset::deleteByUser((int) $reset['user_id']);

        $this->render('auth/reset-password', [
            'title' => 'Definir nova senha',
            'status' => 'Senha redefinida com sucesso! Faça login para continuar.',
            'csrfToken' => Csrf::token(),
        ]);
    }

    private function ensurePost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Método não permitido.');
        }
    }

    private function validateCsrf(): void
    {
        if (!Csrf::validate($_POST['_csrf'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null)) {
            http_response_code(419);
            exit('Falha de verificação CSRF.');
        }
    }

    private function sendMail(string $to, string $subject, string $view, array $data = []): bool
    {
        if (!class_exists(PHPMailer::class)) {
            return false;
        }

        $mail = new PHPMailer(true);
        try {
            $config = $this->config['mail'];
            $mail->isSMTP();
            $mail->Host = $config['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $config['username'];
            $mail->Password = $config['password'];
            $mail->SMTPSecure = $config['encryption'];
            $mail->Port = $config['port'];

            $mail->CharSet = 'UTF-8';
            $mail->setFrom($config['from_address'], $config['from_name']);
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $this->renderViewToString('emails/layout', array_merge($data, [
                'contentView' => $view,
                'subject' => $subject,
            ]));
            $mail->AltBody = strip_tags($mail->Body);

            return $mail->send();
        } catch (MailException $e) {
            error_log('Mail error: ' . $e->getMessage());
            return false;
        }
    }

    private function renderViewToString(string $view, array $params = []): string
    {
        extract($params, EXTR_OVERWRITE);
        ob_start();
        include __DIR__ . '/../Views/' . $view . '.php';
        return ob_get_clean();
    }
}
