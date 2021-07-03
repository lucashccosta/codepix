const { Model, DataTypes } = require('sequelize');

class Wallet extends Model 
{
    static init(connection) 
    {
        super.init({
            balance: DataTypes.INTEGER,
            type: {
                type: DataTypes.ENUM,
                values: ['personal', 'business']
            }
        }, {
            sequelize: connection
        });
    }

    static associate(models) {
        this.belongsTo(models.User, { 
            foreignKey: 'user_id', 
            as: 'user' 
        });
    }
}

module.exports = User;
