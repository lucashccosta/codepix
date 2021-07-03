const SessionService = require('../../services/session-service');
class SessionController 
{
    static async store(req, res)
    {
        const token = await SessionService.create(req.body);
        return res.status(200).json(token);
    }
}

module.exports = SessionController;