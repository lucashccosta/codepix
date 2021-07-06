FROM node:lts-alpine

WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . . 
EXPOSE 3020
CMD ["npm", "run", "start"]
