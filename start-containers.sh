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

    mkcert -key-file localhost-key.pem -cert-file localhost.pem tshirtstore.com
    mkcert -key-file fictivecodes-key.pem -cert-file fictivecodes.pem fictivecodes.local.com

    echo "Certificates generated successfully."
fi
chmod +x .husky/pre-push

docker-compose down
docker-compose -f docker-compose.yml  up --build -d

cd nx && nx bundler wordpress-threed-builder
