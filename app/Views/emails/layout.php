<?php if (!isset($contentView)) { $contentView = 'emails/plain'; }
ob_start();
include __DIR__ . '/../' . $contentView . '.php';
$innerContent = ob_get_clean();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($subject ?? ''); ?></title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f1f5f9; color: #0f172a; margin: 0; padding: 2rem; }
        .container { max-width: 560px; margin: 0 auto; background: #ffffff; border-radius: 16px; padding: 32px; box-shadow: 0 20px 40px rgba(15,23,42,0.08); }
        h1 { font-size: 22px; margin-bottom: 12px; }
        p { font-size: 14px; line-height: 1.6; }
        a.btn { display: inline-block; padding: 10px 18px; background: #2563eb; color: #ffffff; border-radius: 8px; text-decoration: none; font-weight: 600; }
        .footer { margin-top: 24px; font-size: 12px; color: #64748b; }
    </style>
</head>
<body>
    <div class="container">
        <?= $innerContent; ?>
        <p class="footer">Mensagem automática da plataforma Criar Currículo.</p>
    </div>
</body>
</html>
