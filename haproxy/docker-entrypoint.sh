#!/bin/sh
set -e

# if necessary, generate and install certificate.
if [ ! -f "/etc/cert/server.pem" ]; then
  echo "Generating certificate for domain: $SENDY_FQDN"
  echo "Installing OpenSSL"
  apk --update-cache add openssl && \
    rm -rf /var/cache/apk/*
  /usr/local/bin/generateSSLCertificate.sh $SENDY_FQDN
else
  echo "Certificate exists for domain: $SENDY_FQDN"
fi

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
  set -- haproxy "$@"
fi

if [ "$1" = 'haproxy' ]; then
  shift # "haproxy"
  # if the user wants "haproxy", let's add a couple useful flags
  #   -W  -- "master-worker mode" (similar to the old "haproxy-systemd-wrapper"; allows for reload via "SIGUSR2")
  #   -db -- disables background mode
  set -- haproxy -W -db "$@"
fi

exec "$@"