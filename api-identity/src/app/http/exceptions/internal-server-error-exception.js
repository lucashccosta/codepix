const Exception = require('./exception');

class InternalServerErrorException extends Exception 
{
    constructor(error) 
    {
        error = error || 'Internal server error';
        super(error, 500);
    }
}

module.exports = InternalServerErrorException;