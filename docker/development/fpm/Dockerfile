FROM fntlnz/php:7.0.3

WORKDIR /tmp

# Additional extensions

# XDEBUG
RUN wget -nv -O - http://pecl.php.net/get/xdebug-2.4.0RC4.tgz | tar zx
WORKDIR xdebug-2.4.0RC4
RUN phpize
RUN ./configure
RUN make -j
RUN make install

# Copy configuration
COPY etc/ /usr/local/php/etc

# php-fpm
WORKDIR /var/www/penny-classic

RUN useradd fpm
VOLUME ["/usr/local/php/etc"]
ENTRYPOINT ["/usr/local/php/sbin/php-fpm"]
CMD ["-F"]
