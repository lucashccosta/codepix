const jwt = require('jsonwebtoken');

class JwtProvider
{
    static token(payload)
    {   
        const secret = process.env.JWT_SECRET || 'codepix';
        const expiresIn = parseInt(process.env.JWT_EXPIRES) || 3600;
        return jwt.sign(payload, secret, { expiresIn });
    }
}

module.exports = JwtProvider;
