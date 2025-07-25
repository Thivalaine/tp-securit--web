FROM php:8.2-apache
RUN apt-get update && \
    apt-get install -y openssl libssl-dev && \
    a2enmod ssl && \
    a2enmod rewrite && \
    pecl install mongodb && \
    docker-php-ext-enable mongodb
RUN mkdir /etc/apache2/ssl && \
    openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout /etc/apache2/ssl/apache.key \
    -out /etc/apache2/ssl/apache.crt \
    -subj "/C=FR/ST=IDF/L=Paris/O=TP/CN=localhost"
RUN echo "<VirtualHost *:443>\n\
    DocumentRoot /var/www/html\n\
    SSLEngine on\n\
    SSLCertificateFile /etc/apache2/ssl/apache.crt\n\
    SSLCertificateKeyFile /etc/apache2/ssl/apache.key\n\
    <Directory /var/www/html>\n\
        AllowOverride All\n\
    </Directory>\n\
</VirtualHost>" > /etc/apache2/sites-available/default-ssl.conf && \
    a2ensite default-ssl
EXPOSE 443 