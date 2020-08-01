#
# Application Load Balancer Dockerfile (Development Use Only)
#
# Build:
# $ docker build -t lb_sendy -f haproxy/Dockerfile .
#
# Run:
# $ docker run --rm -d -p 80:80 -p 443:443 lb_sendy

FROM haproxy:2.1-alpine
EXPOSE 80 443

COPY haproxy/haproxy.cfg /usr/local/etc/haproxy/haproxy.cfg
COPY haproxy/generateSSLCertificate.sh /usr/local/bin

COPY haproxy/docker-entrypoint.sh /
ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["haproxy", "-f", "/usr/local/etc/haproxy/haproxy.cfg"]