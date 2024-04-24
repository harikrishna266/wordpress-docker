"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
const express = require('express');
const fs = require('fs').promises;
const path = require('path');
const cors = require('cors');
const app = express();
app.use(cors());
app.use(express.static(path.join(__dirname, 'public')));
app.get('/', (req, res) => __awaiter(void 0, void 0, void 0, function* () {
    const HTML_FILE_PATH = path.join(__dirname, 'templates/index.html');
    const htmlTemplate = yield fs.readFile(HTML_FILE_PATH, 'utf8');
    res.setHeader('Content-Type', 'text/html');
    res.send(htmlTemplate);
}));
// app.get('/svg/:filename', async (req, res) => {
//     const { filename } = req.params;
//     const SVG_FILE_PATH = path.join(__dirname, 'public/icons/svg', filename);
//     try {
//         const svgContent = await fs.readFile(SVG_FILE_PATH, 'utf8');
//         res.setHeader('Content-Type', 'image/svg+xml');
//         res.send(svgContent);
//     } catch (error) {
//         console.error(`Error reading SVG file "${filename}":`, error);
//         res.status(404).send('SVG file not found');
//     }
// });
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});
