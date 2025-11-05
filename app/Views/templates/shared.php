<?php
$data = $data ?? [];
$personal = $data['personal'] ?? [];
$objective = trim($data['objective'] ?? '');
$summary = trim($data['summary'] ?? '');
$experiences = $data['experiences'] ?? [];
$education = $data['education'] ?? [];
$courses = $data['courses'] ?? [];
$skills = $data['skills'] ?? ['hard' => [], 'soft' => []];
$projects = $data['projects'] ?? [];
$languages = $data['languages'] ?? [];
$volunteer = $data['volunteer'] ?? [];
$color = $resume['color_scheme'] ?? 'azul';
$palette = [
    'azul' => '#2563eb',
    'verde' => '#047857',
    'vinho' => '#7c2d12',
    'grafite' => '#1f2937',
    'cobalto' => '#1e40af',
];
$accent = $palette[$color] ?? '#2563eb';

if (!function_exists('render_experiences')) {
function render_experiences(array $experiences): ?string {
    if (empty($experiences)) {
        return null;
    }
    $html = '<div class="stack">';
    foreach ($experiences as $exp) {
        $html .= '<div class="item">';
        $html .= '<div class="item-head">' . htmlspecialchars(($exp['role'] ?? '') . ' · ' . ($exp['company'] ?? '')) . '</div>';
        $html .= '<div class="item-meta">' . htmlspecialchars(($exp['period'] ?? '') . ' · ' . ($exp['location'] ?? '')) . '</div>';
        if (!empty($exp['responsibilities'])) {
            $html .= '<ul>';
            foreach (preg_split('/\r?\n/', $exp['responsibilities']) as $item) {
                if (trim($item) === '') { continue; }
                $html .= '<li>' . htmlspecialchars($item) . '</li>';
            }
            $html .= '</ul>';
        }
        if (!empty($exp['results'])) {
            $html .= '<p class="item-meta">Resultado: ' . htmlspecialchars($exp['results']) . '</p>';
        }
        $html .= '</div>';
    }
    $html .= '</div>';
    return $html;
}
}

function render_list(array $items, callable $callback): ?string {
    if (empty($items)) {
        return null;
    }
    $html = '<ul class="stack">';
    foreach ($items as $item) {
        $html .= '<li>' . $callback($item) . '</li>';
    }
    $html .= '</ul>';
    return $html;
}
}

function render_tags(array $items): ?string {
    if (empty($items)) {
        return null;
    }
    $html = '<div class="tags">';
    foreach ($items as $item) {
        if (is_array($item)) {
            $html .= '<span>' . htmlspecialchars(($item['name'] ?? '')) . ' · ' . htmlspecialchars($item['level'] ?? '') . '</span>';
        } else {
            $html .= '<span>' . htmlspecialchars(is_string($item) ? $item : json_encode($item)) . '</span>';
        }
    }
    $html .= '</div>';
    return $html;
}
}

function render_projects(array $projects): ?string {
    if (empty($projects)) {
        return null;
    }
    $html = '<div class="stack">';
    foreach ($projects as $project) {
        $html .= '<div class="item">';
        $html .= '<div class="item-head">' . htmlspecialchars($project['title'] ?? '') . '</div>';
        $html .= '<p>' . htmlspecialchars($project['description'] ?? '') . '</p>';
        if (!empty($project['link'])) {
            $html .= '<a href="' . htmlspecialchars($project['link']) . '">' . htmlspecialchars($project['link']) . '</a>';
        }
        $html .= '</div>';
    }
    $html .= '</div>';
    return $html;
}
}

function section(string $title, ?string $content): void {
    if ($content === null || trim($content) === '') {
        return;
    }
    echo '<section class="section">';
    echo '<h2>' . htmlspecialchars($title) . '</h2>';
    echo $content;
    echo '</section>';
}
}
?>
<style>
.template { font-family: 'Inter', 'Segoe UI', sans-serif; color: #0f172a; }
.template h1 { font-size: 28px; margin-bottom: 4px; }
.template .headline { font-size: 16px; font-weight: 600; color: <?= $accent; ?>; }
.template .header { display: flex; justify-content: space-between; gap: 16px; border-bottom: 2px solid <?= $accent; ?>; padding-bottom: 16px; margin-bottom: 24px; }
.template .links { display: flex; flex-direction: column; gap: 4px; font-size: 13px; }
.template .links a { color: <?= $accent; ?>; text-decoration: none; }
.template .content { display: flex; flex-direction: column; gap: 20px; }
.template .section h2 { text-transform: uppercase; letter-spacing: 0.08em; font-size: 13px; margin-bottom: 8px; color: <?= $accent; ?>; }
.template .grid { display: grid; gap: 16px; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); }
.template .stack { display: flex; flex-direction: column; gap: 10px; }
.template .tags { display: flex; flex-wrap: wrap; gap: 6px; }
.template .tags span { background: rgba(37,99,235,0.08); color: <?= $accent; ?>; padding: 2px 8px; border-radius: 999px; font-size: 12px; }
.template .item-head { font-weight: 600; }
.template .item-meta { font-size: 12px; color: #475569; }
.template ul { margin: 0; padding-left: 18px; }
.template li { margin-bottom: 4px; }
</style>
