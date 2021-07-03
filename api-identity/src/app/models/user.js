const { Model, DataTypes } = require('sequelize');

const Wallet = require('./wallet');
class User extends Model 
{
    static init(connection) 
    {
        super.init({
            name: DataTypes.STRING,
            email: DataTypes.STRING,
            doc: DataTypes.STRING,
            phone: DataTypes.STRING,
            password: DataTypes.STRING
        }, {
            sequelize: connection
        });
    }

    static associate(models) {
        this.hasMany(models.Wallet, { 
            foreignKey: 'user_id', 
            as: 'wallets' 
        });
    }
}

module.exports = User;
