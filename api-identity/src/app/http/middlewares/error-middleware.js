const Exception = require('../exceptions/exception');

module.exports = (error, req, res, next) => {
    if (error) {
        if (error instanceof Exception) {
            return res.status(error.statusCode).json({
                status: 'error',
                message: error.message
            });
        }
    }

    if (process.env.ENVIRONMENT !== 'dev') {
        return res.status(500).json({
            status: 'error',
            message: 'Internal Server Error'
        });
    }

    return res.status(500).json({
        status: 'error',
        message: error.message
    });
};