# Criar Currículo

Assistente web passo a passo para criação, personalização e compartilhamento de currículos profissionais. A aplicação combina dicas de recrutadores, autosave, cinco modelos responsivos (ATS-friendly) e exportação direta em PDF, WhatsApp e e-mail.

## Recursos principais

- Wizard em 11 etapas com barra de progresso, microcopy contextual e autosave.
- CRUD completo de currículos por usuário autenticado.
- Cinco templates prontos (Clássico, Minimalista, Barra Lateral, Criativo e Tech/Design) com cores configuráveis.
- Exportação em PDF (Dompdf) com layout fiel ao preview.
- Envio rápido por WhatsApp (link `wa.me`) e e-mail (PHPMailer) com template personalizável.
- Checklist ATS, dicas de verbos fortes, sugestões de objetivos e resultados de impacto.
- Proteções nativas: CSRF tokens, sessões PHP, hashes seguros (`password_hash`), consultas parametrizadas (PDO).

## Requisitos

- PHP 8.0+
- SQLite 3 (padrão) ou MySQL 5.7+/MariaDB 10+
- Composer
- Extensões PHP: `pdo_sqlite` ou `pdo_mysql`, `mbstring`, `openssl`, `gd` (recomendado para PDFs)

## Instalação

1. Clone o repositório e instale dependências PHP:

   ```bash
   composer install
   ```

2. Copie o arquivo de exemplo e configure as variáveis de ambiente conforme seu banco e SMTP (use `.env` ou exporte variáveis no ambiente):

   | Variável              | Padrão                           | Descrição |
   |----------------------|----------------------------------|-----------|
   | `APP_URL`            | `http://localhost:8000`          | Base URL utilizada em links e e-mails |
   | `DB_DRIVER`          | `sqlite`                         | `sqlite` ou `mysql` |
   | `DB_NAME`            | `storage/database.sqlite`        | Caminho do arquivo SQLite ou nome do schema MySQL |
   | `DB_HOST`            | `localhost`                      | (MySQL) host do banco |
   | `DB_PORT`            | `3306`                           | (MySQL) porta |
   | `DB_USER`            | `root`                           | (MySQL) usuário |
   | `DB_PASS`            | `''`                             | (MySQL) senha |
   | `MAIL_HOST`          | `smtp.example.com`               | Host SMTP |
   | `MAIL_PORT`          | `587`                            | Porta SMTP |
   | `MAIL_USER`          | `''`                             | Usuário SMTP |
   | `MAIL_PASS`          | `''`                             | Senha SMTP |
   | `MAIL_ENCRYPTION`    | `tls`                            | `tls` ou `ssl` |
   | `MAIL_FROM_ADDRESS`  | `no-reply@example.com`           | Endereço do remetente |
   | `MAIL_FROM_NAME`     | `Criar Currículo`                | Nome amigável do remetente |

3. Crie o banco de dados:

   - **SQLite (padrão):**

     ```bash
     mkdir -p storage
     touch storage/database.sqlite
     sqlite3 storage/database.sqlite < database.sql
     ```

   - **MySQL:**

     ```bash
     mysql -u seu_usuario -p -e "CREATE DATABASE curriculos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
     mysql -u seu_usuario -p curriculos < database.sql
     export DB_DRIVER=mysql DB_NAME=curriculos DB_USER=seu_usuario DB_PASS=sua_senha
     ```

4. Inicie o servidor PHP embutido:

   ```bash
   php -S localhost:8000 -t public
   ```

5. Acesse `http://localhost:8000` para abrir a landing page.

## Fluxo recomendado de testes manuais

1. Crie uma conta em `/register`, efetue login e acesse o painel.
2. Inicie um novo currículo, avance pelas etapas, adicione experiências, cursos e habilidades.
3. Escolha diferentes modelos e cores, abra o preview e exporte para PDF.
4. Gere o link do WhatsApp e simule o envio por e-mail (requer SMTP configurado).
5. Edite, duplique e exclua currículos pelo dashboard.

## Estrutura de pastas

```
app/
├── Controllers/       # Lógica dos controladores MVC
├── Models/            # Camada de acesso a dados (PDO)
├── Support/           # Helpers (Auth, CSRF, DB)
├── Views/             # Layouts, páginas e templates de currículo
│   └── templates/     # 5 modelos responsivos e ATS-friendly
config/                # Configuração base do app
public/                # Front controller (index.php) e assets estáticos
storage/               # Banco SQLite, logs e arquivos temporários
```

## Segurança e boas práticas

- CSRF token incluído em formulários e cabeçalho AJAX.
- Sanitização e validação no servidor antes de persistir dados.
- Autenticação por sessão PHP, logout com `session_regenerate_id`.
- Logs básicos de autosave (`storage/logs/audit.log`).
- Pronto para habilitar confirmação de e-mail (estrutura PHPMailer e templates prontos).

## Observações para ATS

- Templates “Clássico” e “Minimalista” usam layout linear e sem ícones para máxima compatibilidade.
- Informações estruturadas em texto simples (sem tabelas complexas ou gráficos).
- Sugestões de palavras-chave alinhadas às áreas mais comuns.

## Acessibilidade

- Navegação por teclado no stepper e formulários.
- Contraste atendendo WCAG AA, foco visível e labels associados.
- Componentes responsivos com uso de ARIA (`aria-current`, `aria-label`) e semântica adequada.

## Licença

Distribuído sob a licença MIT. Sinta-se livre para adaptar a plataforma aos processos da sua equipe de Talent Acquisition.
