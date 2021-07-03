FROM node:lts-alpine

WORKDIR /usr/src/app
COPY package*.json ./
RUN npm install

#copy source files to workdir
COPY . . 
EXPOSE 3020

CMD ["npm", "start"]
