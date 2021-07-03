const { ValidationError } = require('joi');

const BadRequestException = require('../http/exceptions/bad-request-exception');

class Validation { 
    static async validate(schemaValidation, data) 
    {
        try {
            await schemaValidation.validateAsync(data, { abortEarly: false });
        }
        catch(error) {
            if (error instanceof ValidationError) throw new BadRequestException(error.message);

            throw error;
        }
    }
}

module.exports = Validation;
