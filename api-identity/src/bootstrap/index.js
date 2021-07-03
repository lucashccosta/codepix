require('../database/postgres');

const http = require('http');
const app = require('../app/http/kernel');
const server = http.createServer(app);
const port = process.env.APP_PORT || 3030;
server.listen(port, () => {
    console.log(`🚀 API Identity started on ${port} port`);
});