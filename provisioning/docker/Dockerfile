FROM debian:jessie
MAINTAINER Sam Stenvall "neggelandia@gmail.com"

# Install system packages and clean up
RUN apt-get update && \
    apt-get install -y apache2 libapache2-mod-php5 php5-imagick php5-cli \
                       php5-sqlite php5-json git curl supervisor && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# The application files (and database) must be persisted
VOLUME /app

# Install XBMC Video Server
WORKDIR /app
RUN git clone git://github.com/Jalle19/xbmc-video-server.git . && \
    curl -sS https://getcomposer.org/installer | php && \
    php composer.phar install && \
    # Don't recreate the database if it exists
    [ -f /app/src/protected/data/xbmc-video-server.db ] || ./src/protected/yiic createinitialdatabase && \
    ./src/protected/yiic setpermissions

# Configure supervisor and Apache
RUN mkdir -p /var/log/supervisor

COPY etc/supervisor/conf.d/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY etc/apache2/sites-available/xbmc-video-server.conf /etc/apache2/sites-available/xbmc-video-server.conf

RUN a2enmod rewrite expires && \
    a2dissite 000-default && \
    a2ensite xbmc-video-server

# Start supervisord, which starts Apache
EXPOSE 80
CMD ["/usr/bin/supervisord", "-n"]
