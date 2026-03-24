const fs = require('fs');

const files = [
    'resources/js/Layouts/LmsLayout.jsx',
    'resources/js/Pages/Dashboard.jsx',
    'resources/js/Pages/Admin/Trainers/Index.jsx',
    'resources/js/Pages/Admin/Trainers/Create.jsx'
];

const map = {
    '#222222': '#1B365D', // Dark text -> Deep Navy Blue
    '#555555': '#333333', // Muted text -> Charcoal Grey
    '#888888': '#333333', // Muted icons -> Charcoal Grey
    '#EEEEEE': '#F4F4F4', // Borders -> Light Silver
    '#F9F9F9': '#F4F4F4', // Main BG -> Light Silver
    '#D65C18': '#F37021', // Secondary orange -> Safety Orange
    '#28A745': '#1B365D'  // Green success -> Deep Navy Blue
};

files.forEach(file => {
    if (fs.existsSync(file)) {
        let content = fs.readFileSync(file, 'utf8');
        for (const [oldC, newC] of Object.entries(map)) {
            content = content.replace(new RegExp(oldC, 'gi'), newC);
        }
        fs.writeFileSync(file, content);
    }
});
console.log('Colors remapped successfully!');
