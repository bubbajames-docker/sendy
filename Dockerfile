#
# Docker with Sendy Email Campaign Marketing
#
# Build:
# $ docker build -t sendy:latest -f ./Dockerfile .
#
# Run:
# $ docker run --rm -d sendy:latest

FROM php:7.4.8-apache

ARG SENDY_VER=4.1.0

ENV SENDY_VERSION ${SENDY_VER}

RUN apt -qq update && apt -qq upgrade -y \
  # Install unzip
  && apt -qq install -y unzip  \
  # Install php extension gettext
  # Install php extension mysqli
  && docker-php-ext-install gettext mysqli \
  # Remove unused packages
  && apt autoremove -y 

# Copy artifacts
COPY ./artifacts/${SENDY_VER}/ /tmp

# Install Sendy
RUN unzip /tmp/sendy-${SENDY_VER}.zip -d /tmp \
  && mv /tmp/config.php /tmp/sendy/includes \
  && chmod 777 /tmp/sendy/uploads \
  && rm -rf /var/www/html \
  && mv /tmp/sendy /var/www/html \
  && rm -rf /tmp/* \
  && echo "\nServerName \${SENDY_FQDN}" > /etc/apache2/conf-available/serverName.conf \
  # Ensure X-Powered-By is always removed regardless of php.ini or other settings.
  && printf "\n\n# Ensure X-Powered-By is always removed regardless of php.ini or other settings.\n\
Header always unset \"X-Powered-By\"\n\
Header unset \"X-Powered-By\"\n" >> /var/www/html/.htaccess

# Apache config
RUN a2enconf serverName

# Apache modules
RUN a2enmod rewrite headers

COPY artifacts/docker-entrypoint.sh /usr/local/bin/
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["apache2-foreground"]