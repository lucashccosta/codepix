const Exception = require('./exception');

class ForbiddenException extends Exception 
{
    constructor(error) 
    {
        error = error || 'Forbidden';
        super(error, 403);
    }
}

module.exports = ForbiddenException;