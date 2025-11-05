<?php

namespace App\Controllers;

use App\Models\Resume;
use App\Support\Auth;
use App\Support\Csrf;
use Dompdf\Dompdf;
use Dompdf\Options;

class ResumeController extends BaseController
{
    private array $templates = [
        'classico',
        'minimalista',
        'lateral',
        'criativo',
        'tech',
    ];

    public function create()
    {
        $this->ensureAuthenticated();
        $this->renderWizard();
    }

    public function edit(array $params)
    {
        $this->ensureAuthenticated();
        $resume = $this->findUserResume((int) $params['id']);
        $this->renderWizard($resume);
    }

    public function saveStep()
    {
        $this->ensureAuthenticated();
        $this->ensureJson();
        $data = json_decode(file_get_contents('php://input'), true) ?? [];
        if (!Csrf::validate($data['_csrf'] ?? null)) {
            http_response_code(419);
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'CSRF inválido']);
            return;
        }
        $user = Auth::user();
        $resumeId = isset($data['resumeId']) ? (int) $data['resumeId'] : null;
        $formPayload = $data['form'] ?? [];
        unset($formPayload['_csrf']);

        $payload = [
            'title' => $data['title'] ?? 'Meu currículo',
            'data_json' => json_encode($formPayload),
            'template' => in_array($data['template'] ?? 'classico', $this->templates, true) ? $data['template'] : 'classico',
            'color_scheme' => $data['color'] ?? 'azul',
            'user_id' => $user['id'],
        ];

        if ($resumeId) {
            Resume::update($resumeId, $user['id'], $payload);
        } else {
            $resumeId = Resume::create($payload);
        }

        $logMessage = sprintf("%s | user:%d resume:%d autosave", date('c'), $user['id'], $resumeId);
        file_put_contents(__DIR__ . '/../../storage/logs/audit.log', $logMessage . PHP_EOL, FILE_APPEND);

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'resumeId' => $resumeId]);
    }

    public function preview(array $params)
    {
        $this->ensureAuthenticated();
        $resume = $this->findUserResume((int) $params['id']);
        $data = json_decode($resume['data_json'], true) ?? [];
        $template = $_GET['template'] ?? $resume['template'];
        if (!in_array($template, $this->templates, true)) {
            $template = 'classico';
        }
        $this->render('resume/preview', [
            'title' => 'Pré-visualização',
            'resume' => $resume,
            'data' => $data,
            'template' => $template,
        ], 'preview');
    }

    public function exportPdf(array $params)
    {
        $this->ensureAuthenticated();
        $resume = $this->findUserResume((int) $params['id']);
        $data = json_decode($resume['data_json'], true) ?? [];
        $template = $_GET['template'] ?? $resume['template'];
        if (!in_array($template, $this->templates, true)) {
            $template = 'classico';
        }

        $html = $this->renderViewToString('templates/' . $template, [
            'resume' => $resume,
            'data' => $data,
        ]);

        if (!class_exists(Dompdf::class)) {
            http_response_code(500);
            echo 'Biblioteca Dompdf não instalada. Consulte o README.';
            return;
        }

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4');
        $dompdf->render();
        $dompdf->stream('curriculo.pdf', ['Attachment' => true]);
    }

    public function sendEmail(array $params)
    {
        $this->ensureAuthenticated();
        $this->ensurePost();
        $this->validateCsrf();

        $resume = $this->findUserResume((int) $params['id']);
        $to = $_POST['to'] ?? '';
        $subject = $_POST['subject'] ?? 'Meu currículo atualizado';
        $message = $_POST['message'] ?? '';

        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash_error'] = 'Informe um e-mail válido.';
            $this->redirect('/resume/' . $resume['id'] . '/preview');
        }

        $payload = [
            'resume' => $resume,
            'data' => json_decode($resume['data_json'], true) ?? [],
        ];
        $html = $this->renderViewToString('templates/' . $resume['template'], $payload);
        $pdfContent = null;
        if (class_exists(Dompdf::class)) {
            $options = new Options();
            $options->set('isRemoteEnabled', true);
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html, 'UTF-8');
            $dompdf->setPaper('A4');
            $dompdf->render();
            $pdfContent = $dompdf->output();
        }

        $mailer = new \PHPMailer\PHPMailer\PHPMailer(true);
        try {
            $config = require __DIR__ . '/../../config/config.php';
            $mailConfig = $config['mail'];
            $mailer->isSMTP();
            $mailer->Host = $mailConfig['host'];
            $mailer->SMTPAuth = true;
            $mailer->Username = $mailConfig['username'];
            $mailer->Password = $mailConfig['password'];
            $mailer->SMTPSecure = $mailConfig['encryption'];
            $mailer->Port = $mailConfig['port'];
            $mailer->CharSet = 'UTF-8';
            $mailer->setFrom($mailConfig['from_address'], $mailConfig['from_name']);
            $mailer->addAddress($to);
            $mailer->isHTML(true);
            $mailer->Subject = $subject;
            $mailer->Body = nl2br(htmlentities($message)) . '<hr>' . $html;
            $mailer->AltBody = strip_tags($message);
            if ($pdfContent) {
                $mailer->addStringAttachment($pdfContent, 'curriculo.pdf');
            } else {
                $mailer->addStringAttachment($html, 'curriculo.html', 'base64', 'text/html');
            }
            $mailer->send();
            $_SESSION['flash_success'] = 'E-mail enviado com sucesso!';
        } catch (\Throwable $e) {
            error_log('Email error: ' . $e->getMessage());
            $_SESSION['flash_error'] = 'Não foi possível enviar o e-mail agora. Verifique as configurações.';
        }

        $this->redirect('/resume/' . $resume['id'] . '/preview');
    }

    public function whatsapp(array $params)
    {
        $this->ensureAuthenticated();
        $resume = $this->findUserResume((int) $params['id']);
        $link = $this->generateWhatsappLink($resume);
        header('Location: ' . $link);
    }

    public function duplicate(array $params)
    {
        $this->ensureAuthenticated();
        $this->ensurePost();
        $this->validateCsrf();
        $resumeId = Resume::duplicate((int) $params['id'], Auth::user()['id']);
        if ($resumeId) {
            $_SESSION['flash_success'] = 'Currículo duplicado com sucesso!';
        }
        $this->redirect('/dashboard');
    }

    public function delete(array $params)
    {
        $this->ensureAuthenticated();
        $this->ensurePost();
        $this->validateCsrf();
        Resume::delete((int) $params['id'], Auth::user()['id']);
        $_SESSION['flash_success'] = 'Currículo removido.';
        $this->redirect('/dashboard');
    }

    private function renderWizard(?array $resume = null): void
    {
        $data = $resume ? json_decode($resume['data_json'], true) : null;
        $this->render('resume/wizard', [
            'title' => $resume ? 'Editar currículo' : 'Novo currículo',
            'resume' => $resume,
            'formData' => $data,
            'csrfToken' => Csrf::token(),
            'templates' => $this->templates,
        ]);
    }

    private function ensureAuthenticated(): void
    {
        if (!Auth::check()) {
            header('Location: /login');
            exit;
        }
    }

    private function ensurePost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Método não permitido.');
        }
    }

    private function ensureJson(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || stripos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') === false) {
            http_response_code(415);
            exit('Formato inválido.');
        }
    }

    private function validateCsrf(): void
    {
        if (!Csrf::validate($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('Falha de verificação CSRF.');
        }
    }

    private function findUserResume(int $id): array
    {
        $resume = Resume::find($id, Auth::user()['id']);
        if (!$resume) {
            http_response_code(404);
            exit('Currículo não encontrado.');
        }
        return $resume;
    }

    private function renderViewToString(string $view, array $params = []): string
    {
        extract($params, EXTR_OVERWRITE);
        ob_start();
        include __DIR__ . '/../Views/' . $view . '.php';
        return ob_get_clean();
    }

    private function generateWhatsappLink(array $resume): string
    {
        $url = $this->config()['app']['base_url'] . '/resume/' . $resume['id'] . '/preview';
        $message = 'Olá! Segue meu currículo atualizado: ' . $url;
        return 'https://wa.me/?text=' . urlencode($message);
    }

    private function config(): array
    {
        return require __DIR__ . '/../../config/config.php';
    }
}
