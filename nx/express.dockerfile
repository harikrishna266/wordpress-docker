FROM node:18

WORKDIR  /usr/src/app

RUN npm add --global nx@latest

copy nx .

RUN npm install


EXPOSE 3333

# Command to run the application
CMD ["nx", "serve", "fictivecode"]

