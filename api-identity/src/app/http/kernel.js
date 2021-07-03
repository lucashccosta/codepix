const express = require('express');
const cors = require('cors');
const helmet = require('helmet');

const routes = require('../routes');
const errorMiddleware = require('./middlewares/error-middleware');

const app = express();

app.use(helmet());
app.use(cors());
app.use(express.json());
app.use(routes);
app.use(errorMiddleware);

module.exports = app;