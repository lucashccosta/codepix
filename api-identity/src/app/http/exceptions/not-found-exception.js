const Exception = require('./exception');

class NotFoundException extends Exception 
{
    constructor(error) 
    {
        error = error || 'Not found';
        super(error, 404);
    }
}

module.exports = NotFoundException;