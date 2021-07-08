const { rbtmqListenFromQueue } = require('../app/providers/rabbitmq');
const MailService = require('../app/services/mail-service');

rbtmqListenFromQueue(
    MailService.listen, 
    () => console.log('🔰 Listening rabbitmq server!')
);