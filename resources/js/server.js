import express from 'express';
import axios from 'axios';
import cors from 'cors';

const app = express();
const port = 3000;

app.use(cors()); // Autorise toutes les origines et tous les en-têtes par défaut

app.get('/event/eventAjax', async (req, res) => {
   console.log(req);
});


app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
});
