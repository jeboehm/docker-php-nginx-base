ARG PHP_VER=7.4

FROM jeboehm/php-base:${PHP_VER}
LABEL maintainer="jeff@ressourcenkonflikt.de"

RUN apk --no-cache add \
      nginx \
      supervisor && \
    ln -sf /dev/stdout /var/log/nginx/access.log && \
    ln -sf /dev/stderr /var/log/nginx/error.log && \
    chown -R www-data:www-data /var/lib/nginx && \
    mkdir /run/nginx && \
    rm -f /etc/nginx/conf.d/default.conf

COPY rootfs/ /
EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
