const Smtp = require('../providers/smtp');
const { formatBrCoin } = require('../helpers/coin');
const mails = require('../../resources/mails');

class MailService
{
    static async listen(payload, op = 'transaction') 
    {   
        //TODO: receive email from/to and name from/to
        const { status = 'success', total = 0.0 } = payload;
        const mailsToSend = mails[op][status];
        console.log(mailsToSend);
        mailsToSend.forEach(async mail => {
            await (new Smtp()).mail(
                'support@codepix.test',
                'mailto@codepix.test',
                'Codepix',
                mail.replace(
                    /{total}/g, 
                    formatBrCoin(total/100)
                )
            )
        });
    }
}

module.exports = MailService;