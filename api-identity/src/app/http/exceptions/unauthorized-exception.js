const Exception = require('./exception');

class ForbiddenException extends Exception 
{
    constructor(error) 
    {
        error = error || 'Unauthorized';
        super(error, 401);
    }
}

module.exports = ForbiddenException;