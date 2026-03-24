const fs = require('fs');
const path = require('path');

const dir = 'resources/js/Pages/Admin';
const files = fs.readdirSync(dir, { recursive: true })
    .filter(f => f.endsWith('.jsx'))
    .map(f => path.join(dir, f));

const map = {
    '#111827': '#1B365D', 
    '#f3f4f6': '#F4F4F4', 
    '#e3000f': '#F37021', 
    '#cc0000': '#F37021', 
    '227,0,15': '243,112,33'
};

files.forEach(file => {
    let content = fs.readFileSync(file, 'utf8');
    for (const [oldC, newC] of Object.entries(map)) {
        content = content.replace(new RegExp(oldC, 'gi'), newC);
    }
    fs.writeFileSync(file, content);
});
console.log('Processed all Admin subpages!');
