FROM node:lts-alpine

WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . . 
RUN mv .env.example .env
EXPOSE 3050
CMD ["npm", "run", "start"]
