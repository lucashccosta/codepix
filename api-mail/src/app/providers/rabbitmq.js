const amqp = require('amqplib');
const config = require('../../config/queue');

const rbtmqListenFromQueue = async (callable, callback) => {
    const queue = 'mails';
    const connection = await amqp.connect(config);
    const channel = await connection.createChannel();

    await channel.assertQueue(queue, { durable: true });
    await channel.prefetch(1);

    await channel.consume(queue, async (msg) => {
        const payload = JSON.parse(msg.content.toString());
        await callable(payload);
        channel.ack(msg);
    });

    callback();
};

module.exports = { rbtmqListenFromQueue };