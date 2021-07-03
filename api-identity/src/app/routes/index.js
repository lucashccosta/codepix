const { Router } = require('express');

const sessionRoutes = require('./session-routes');

const routes = Router();
routes.use('/sessions', sessionRoutes);

module.exports = routes;