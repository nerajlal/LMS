const fs = require('fs');

const file = 'resources/js/Pages/Auth/Login.jsx';

const map = {
    '#f3f4f6': '#F4F4F4', // Base background -> Light Silver
    '#cc0000': '#1B365D', // Gradient start & focus borders -> Deep Navy Blue
    '#1d4ed8': '#F37021', // Gradient end & hover states -> Safety Orange
    '#1f2937': '#333333', // High contrast text -> Charcoal
    '#6b7280': '#333333', // Muted text -> Charcoal
    '#374151': '#333333', // Labels -> Charcoal
    '#e3000f': '#F37021', // Primary elements -> Safety Orange
    '#ef4444': '#F37021'  // Error borders/text -> Safety Orange (to enforce strict 5-colors)
};

if (fs.existsSync(file)) {
    let content = fs.readFileSync(file, 'utf8');
    for (const [oldC, newC] of Object.entries(map)) {
        content = content.replace(new RegExp(oldC, 'gi'), newC);
    }
    fs.writeFileSync(file, content);
    console.log('Login Layout colors remapped successfully!');
} else {
    console.log('File not found');
}
