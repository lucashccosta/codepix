const Sequelize = require('sequelize');
const databaseConfig = require('../config/database');

const User = require('../models/user');
const Wallet = require('../models/wallet');

const connection = new Sequelize(databaseConfig);

User.init(connection);
Wallet.init(connection);

User.associate(connection.models);
Wallet.associate(connection.models);

module.exports = connection;