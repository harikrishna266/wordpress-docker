FROM node:18

WORKDIR  /usr/src/app

RUN npm add --global nx@latest


copy nx .

RUN npm i


EXPOSE 3333

CMD ["nx", "serve", "fictivecode"]

