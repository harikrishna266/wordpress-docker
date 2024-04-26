const express = require('express');
const fs = require('fs').promises;
const path = require('path');

const cors = require('cors');

const app = express();
app.use(cors());
app.use(express.static(path.join(__dirname,'..' ,'public')));

app.get('/', async (req, res) => {
    const HTML_FILE_PATH = path.join(__dirname,'templates', 'index.html');
    const htmlTemplate = await fs.readFile(HTML_FILE_PATH, 'utf8');
    res.setHeader('Content-Type', 'text/html');
    res.send(htmlTemplate);
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});