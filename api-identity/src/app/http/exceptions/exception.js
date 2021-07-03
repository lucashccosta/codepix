class Exception extends Error 
{
    constructor(error, statusCode = 500) 
    {
        super(error);
        this.statusCode = statusCode;
    }
}

module.exports = Exception;