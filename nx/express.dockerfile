# Stage 1: Builder
FROM node:18-alpine as builder

WORKDIR /usr/src/app

# Install nx globally in the builder stage
RUN npm add --global nx@latest

# Copy only the necessary files for npm install
COPY nx .

# Install dependencies
RUN npm i

# Build the application (assuming 'nx build fictivecode' is the build command)
RUN nx build fictivecode

# Stage 2: Final
FROM node:18-alpine

WORKDIR /usr/src/app

COPY --from=builder /usr/src/app/dist/apps/fictivecode/ ./dist
WORKDIR /usr/src/app/dist
RUN npm install  tslib
RUN npm install -g nodemon
RUN npm install

EXPOSE 3333

# Assuming 'index.js' is the entry point of your application
CMD ["nodemon", "main.js"]

