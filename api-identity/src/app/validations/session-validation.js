const Joi = require('joi');

const schema = Joi.object({
    doc: Joi.string()
        .required()
        .messages({
            'any.required': 'Doc (cpf/cnpj) is required'
        }),

    password: Joi.number()
        .required()
        .messages({
            'any.required': 'Password is required'
        }),
});

module.exports = schema;
