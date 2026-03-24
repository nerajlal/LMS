const fs = require('fs');

const file = 'resources/js/Layouts/AdminLayout.jsx';

const map = {
    '#111827': '#1B365D', // Dark sidebar -> Deep Navy Blue
    '#f3f4f6': '#F4F4F4', // Main background -> Light Silver
    '#e3000f': '#F37021', // Primary Red -> Safety Orange
    '#cc0000': '#F37021', // Secondary Red Gradient -> Safety Orange
    '227,0,15': '243,112,33' // RGB Red -> RGB Safety Orange
};

if (fs.existsSync(file)) {
    let content = fs.readFileSync(file, 'utf8');
    for (const [oldC, newC] of Object.entries(map)) {
        content = content.replace(new RegExp(oldC, 'gi'), newC);
    }
    fs.writeFileSync(file, content);
    console.log('Admin Layout colors remapped successfully!');
} else {
    console.log('File not found');
}
