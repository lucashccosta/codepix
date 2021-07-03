const sessionValidation = require('../validations/session-validation');

const UserRepository = require('../repositories/user-repository');
const Validation = require('../validations/validation');
const NotFoundException = require('../http/exceptions/not-found-exception');
const JwtProvider = require('../providers/jwt-provider');

class SessionService
{
    static async create(data)
    {
        await Validation.validate(sessionValidation, data);

        const { doc, password } = data;
        const user = await UserRepository.attempt(doc, password);
        if (!user) throw new NotFoundException();

        const token = JwtProvider.token({
            id: user.id,
            doc: user.doc
        });

        return { token };
    }
}

module.exports = SessionService;
