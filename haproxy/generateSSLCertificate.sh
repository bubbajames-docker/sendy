#!/bin/sh

# Lifted from https://deliciousbrains.com/ssl-certificate-authority-for-local-https-development/
# Author: Brad Touesnard 

if [ "$#" -ne 1 ]
then
  echo "Usage: Must supply a domain"
  exit 1
fi

DOMAIN=$1

echo "Generating Development RootCA and SSL Certificate for: $DOMAIN"

# create output directory
mkdir /etc/cert

# create temporary work directory
mkdir /tmp/deleteme
cd /tmp/deleteme

# Create RootCA key and cert
openssl genrsa -out rootCA.key 2048
openssl req -x509 -new -nodes -key rootCA.key -sha256 -days 1825 \
  -subj "/C=US/ST=CA/L=/O=/OU=/CN=rootCA-$DOMAIN" -out ./rootCA.crt 



# Create domain certificate signing request
openssl genrsa -out server.key 2048
openssl req -new -key server.key -subj "/C=US/ST=CA/L=/O=/OU=/CN=$DOMAIN" -out server.csr

cat > $DOMAIN.ext << EOF
authorityKeyIdentifier=keyid,issuer
basicConstraints=CA:FALSE
keyUsage = digitalSignature, nonRepudiation, keyEncipherment, dataEncipherment
subjectAltName = @alt_names
[alt_names]
DNS.1 = $DOMAIN
EOF

openssl x509 -req -in server.csr -CA ./rootCA.crt -CAkey ./rootCA.key -CAcreateserial -days 825 -sha256 \
  -extfile $DOMAIN.ext -out ./server.crt 

cat ./server.key ./server.crt > /etc/cert/server.pem
cat ./rootCA.key ./rootCA.crt > /etc/cert/rootCA.pem

cd /

# remove temporary work directory
rm -rf /tmp/deleteme

echo "Development RootCA and SSL Certificate are located in /etc/cert/"
