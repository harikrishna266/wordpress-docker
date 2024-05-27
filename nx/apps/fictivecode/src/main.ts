import express from 'express';
import * as path from 'path';
import  cors from 'cors';


const app = express();
app.use(cors());
const publicPath = path.join(__dirname, 'public');
app.use(express.static(publicPath));

app.get('/api', (req, res) => {
  res.send({ message: 'Welcome to fictivecode!' });
});

const port = process.env.PORT || 3333;
const server = app.listen(port, () => {
  console.log(`Listening at http://localhost:${port}/api`);
});
server.on('error', console.error);
