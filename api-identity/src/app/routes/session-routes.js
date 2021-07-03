const { Router } = require('express');

const SessionController = require('../http/controllers/session-controller');

const routes = Router();
routes.post('/', SessionController.store);

module.exports = routes;