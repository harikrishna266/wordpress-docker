const express = require('express');
const fs = require('fs').promises;
const path = require('path');

const cors = require('cors');

const app = express();
app.use(cors());
app.use(express.static(path.join(__dirname,'..' ,'public')));

app.get('/templates/:app/:filename', async (req, res) => {
    try {
         const { filename, app } = req.params;

        if (filename.includes('..')) {
            throw new Error('Invalid filename');
        }
        const HTML_FILE_PATH = path.join(__dirname, 'templates', app ,filename);
         try {
            await fs.access(HTML_FILE_PATH, fs.constants.F_OK);
        } catch (error) {
            throw new Error('File not found');
        }
        const fileStats = await fs.stat(HTML_FILE_PATH);
        if (!fileStats.isFile()) {
            throw new Error('Invalid file');
        }
        const htmlTemplate = await fs.readFile(HTML_FILE_PATH, 'utf8');
        res.setHeader('Content-Type', 'text/html');
        res.send(htmlTemplate);
    } catch (error) {
        res.status(500).send('Internal Server Error');
    }
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});