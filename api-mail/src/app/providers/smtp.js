const mail = require('nodemailer');
const config = require('../../config/mail');

class Smtp
{
    //TODO: singleton
    constructor()
    {
        this.transport = mail.createTransport({
            host: config.host,
            port: config.port,
            auth: {
                user: config.user,
                pass: config.pass
            }
        });

        return this;
    }

    async mail(from, to, subject, text) 
    {
        await this.transport.sendMail(
            { from, to, subject, text }
        );
    }
}

module.exports = Smtp;