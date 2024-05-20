# Use the harikrishna266/webcomponents:latest image as the base image
FROM harikrishna266/webcomponents:latest AS source

# Create a new stage for installing Node.js and Nx
FROM node:latest AS build

# Set the working directory for installing dependencies
WORKDIR /workspace

# Copy the package.json and package-lock.json files from the source stage
COPY --from=source /workspace .

# Install Node.js dependencies
RUN npm install

# Install Nx globally
RUN npm add --global nx@latest

# Build the Nx project
RUN nx build three-d-ui

# Create a new stage for serving the built application with Nginx
FROM nginx:alpine

# Set the working directory in the Nginx container
WORKDIR /usr/share/nginx/html

# Copy the built application from the build stage
COPY --from=build /workspace .

# Expose port 80 (default HTTP port for Nginx)
EXPOSE 80
#
# Start Nginx (this command is provided by the base Nginx image)
CMD ["nginx", "-g", "daemon off;"]
