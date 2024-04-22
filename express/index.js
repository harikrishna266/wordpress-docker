const express = require('express');
const fs = require('fs').promises;
const path = require('path');

const cors = require('cors');

const app = express();

app.use(cors());
app.get('/', async (req, res) => {
    const HTML_FILE_PATH = path.join(__dirname, 'public/templates/index.html');
    const htmlTemplate = await fs.readFile(HTML_FILE_PATH, 'utf8');
    res.setHeader('Content-Type', 'text/html');
    res.send(htmlTemplate);
});

app.get('/svg/:filename', async (req, res) => {
    const { filename } = req.params;
    const SVG_FILE_PATH = path.join(__dirname, 'public/icons/svg', filename);
    try {
        const svgContent = await fs.readFile(SVG_FILE_PATH, 'utf8');
        res.setHeader('Content-Type', 'image/svg+xml');
        res.send(svgContent);
    } catch (error) {
        console.error(`Error reading SVG file "${filename}":`, error);
        res.status(404).send('SVG file not found');
    }
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});