FROM node:18

WORKDIR  /usr/src/app

RUN npm add --global nx@latest

copy nx .

RUN npm install

RUN nx build fictivecode

WORKDIR  /usr/src/app/dist/apps/fictivecode

EXPOSE 3333

# Command to run the application
CMD ["node", "main.js"]

