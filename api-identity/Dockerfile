FROM node:lts-alpine

WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . . 
RUN mv .env.example .env
EXPOSE 3020
CMD ["npm", "run", "start"]
