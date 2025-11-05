<h1>Olá, <?= htmlspecialchars($name ?? ''); ?>!</h1>
<p>Recebemos um pedido para redefinir sua senha na plataforma <strong>Criar Currículo</strong>.</p>
<p>Se você fez essa solicitação, clique no botão abaixo para criar uma nova senha segura:</p>
<p><a class="btn" href="<?= htmlspecialchars($resetLink ?? '#'); ?>" target="_blank" rel="noopener">Redefinir senha</a></p>
<p>O link expira em 60 minutos. Se não foi você quem solicitou, ignore este e-mail.</p>
