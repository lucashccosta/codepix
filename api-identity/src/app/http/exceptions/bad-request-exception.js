const Exception = require('./exception');

class BadRequestException extends Exception 
{
    constructor(error) 
    {
        error = error || 'Bad request';
        super(error, 400);
    }
}

module.exports = BadRequestException;