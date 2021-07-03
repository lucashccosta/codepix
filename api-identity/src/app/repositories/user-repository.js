const bcrypt = require('bcrypt');

const NotFoundException = require('../http/exceptions/not-found-exception');
const UnauthorizedException = require('../http/exceptions/unauthorized-exception');
const User = require('../models/user');

class UserRepository 
{
    static get model()
    {
        return User;
    }

    static async attempt(doc, password)
    {
        const user = await this.model.findOne({ where: { doc } });
        if (!user) throw new NotFoundException();
        const hash = user.password.replace(/^\$2y(.+)$/i, '$2a$1');
        const match = await bcrypt.compare(password, hash);
        if (!match) throw new UnauthorizedException();

        return user;
    }   
}

module.exports = UserRepository;
