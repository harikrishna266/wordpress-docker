#!/bin/bash

CERTS_DIR="./nginx/certs"
CERT_FILE="${CERTS_DIR}/localhost.pem"
KEY_FILE="${CERTS_DIR}/localhost-key.pem"

 if [ ! -f "$CERT_FILE" ] || [ ! -f "$KEY_FILE" ]; then
    echo "Certificate files not found. Generating certificates with mkcert..."

     if ! command -v mkcert &> /dev/null; then
        echo "Error: mkcert is not installed."
        echo "Please install mkcert from https://github.com/FiloSottile/mkcert."
        exit 1
    fi

    mkdir -p "$CERTS_DIR"
    cd "$CERTS_DIR"

    mkcert -key-file localhost-key.pem -cert-file localhost.pem localhost

    echo "Certificates generated successfully."
fi

docker-compose down
docker-compose up --build -d
