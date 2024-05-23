FROM node:18

WORKDIR  /usr/src/app

RUN npm add --global nx@latest

RUN npm install cors @types/cors --force
RUN npm install cors @angular/elements --force


copy nx .

RUN npm install


EXPOSE 3333

CMD ["nx", "serve", "fictivecode"]

