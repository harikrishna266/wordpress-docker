FROM node:18

# Set the working directory in the container
WORKDIR  /usr/src/app

# Copy package.json and package-lock.json to the working directory
COPY package*.json ./

# Install application dependencies
RUN npm install

# Copy the rest of the application code
COPY ./express/ ./express
WORKDIR  /usr/src/app/express
# Expose port 3000 to the outside world
EXPOSE 3000

# Command to run the application
CMD ["npm", "run","start"]
