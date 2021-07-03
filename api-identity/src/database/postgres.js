const Sequelize = require('sequelize');
const databaseConfig = require('../config/database');

const User = require('../app/models/user');
const Wallet = require('../app/models/wallet');

const connection = new Sequelize(databaseConfig);

User.init(connection);
Wallet.init(connection);

User.associate(connection.models);
Wallet.associate(connection.models);

module.exports = connection;