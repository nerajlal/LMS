const fs = require('fs');

const files = [
    'resources/js/Layouts/LmsLayout.jsx',
    'resources/js/Pages/Dashboard.jsx'
];

const map = {
    '#e3000f': '#F37021',
    '#1e293b': '#222222',
    '#64748b': '#555555',
    '#f1f5f9': '#EEEEEE',
    '#fff1f2': '#FEF1EA',
    '#f9fafb': '#F9F9F9',
    '#10b981': '#28A745',
    '#ef4444': '#F37021',
    '#cc0000': '#1B365D',
    '#f87171': '#D65C18',
    '#f59e0b': '#F37021',
    '#94a3b8': '#888888',
    '#e2e8f0': '#EEEEEE'
};

files.forEach(file => {
    let content = fs.readFileSync(file, 'utf8');
    for (const [oldC, newC] of Object.entries(map)) {
        content = content.replace(new RegExp(oldC, 'gi'), newC);
    }
    fs.writeFileSync(file, content);
});
console.log('Replaced colors successfully!');
