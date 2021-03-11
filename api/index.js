// Exemple adapté de la mise en route d'Express : 
// http://expressjs.com/fr/starter/hello-world.html
var express = require('express');
let bodyParser = require('body-parser');
let apiRouter = require('./apiRouter').router;

let app = express();

//Body Parser configuration
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

// '/' est la route racine
app.get('/', function (req, res) {
    res.setHeader('Content-Type', 'text/html');
    res.status(200).send('Bonjour sur mon serveur');
});

app.use('/api/', apiRouter);

app.listen(4000, function () {
  console.log("Application d'exemple écoutant sur le port 4000 !");
});