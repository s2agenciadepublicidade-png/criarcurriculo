export function generateImpactBullet(currentText = '', microcopy = {}) {
    const verbs = microcopy.verbs || ['Liderei', 'Implementei', 'Otimizei', 'Negociei'];
    const results = microcopy.results || [
        'Aumentei a eficiência do processo em 15% ao mapear gargalos e aplicar automações.',
        'Reduzi o tempo de resposta ao cliente em 20% com scripts e treinamento contínuo.',
        'Implementei painel de indicadores que orientou decisões estratégicas semanais.',
    ];
    const verb = verbs[Math.floor(Math.random() * verbs.length)];
    const result = results[Math.floor(Math.random() * results.length)];
    const base = `${verb} ${result.replace(/^[A-ZÀ-Ú]/, (match) => match.toLowerCase())}`;
    if (!currentText) {
        return `• ${base}`;
    }
    const alreadyEndsWithDot = currentText.trim().endsWith('.') || currentText.trim().endsWith(';');
    return `${alreadyEndsWithDot ? '' : '.'}\n• ${base}`.trim();
}
