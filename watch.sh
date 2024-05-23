#!/bin/bash

WATCH_DIR="nx/apps/wordpress-threed-builder/src"
WATCH_FILE="main.ts"

CONTAINER_NAME="fictive"

# Define the Docker image name
IMAGE_NAME="fictivecode_image"

# Run inotifywait to watch the file for changes
inotifywait -m -e close_write "$WATCH_DIR/$WATCH_FILE" |
while read -r directory events filename; do
    if [[ "$filename" == "$WATCH_FILE" ]]; then
        echo "File $WATCH_FILE has changed. Updating container $CONTAINER_NAME..."

        # Rebuild the Docker image
        docker build -t $IMAGE_NAME .

        # Stop the current container
        docker stop $CONTAINER_NAME

        # Remove the current container
        docker rm $CONTAINER_NAME

        # Run a new container with the updated image
        docker run -d --name $CONTAINER_NAME -v /path/to/host/directory:/path/to/container/directory $IMAGE_NAME

        echo "Container $CONTAINER_NAME has been updated."
    fi
done
