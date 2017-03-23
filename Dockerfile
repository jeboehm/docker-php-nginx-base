FROM jeboehm/php-base:latest
MAINTAINER Jeffrey Boehm "jeff@ressourcenkonflikt.de"

RUN apk --no-cache add \
      nginx \
      supervisor && \
    ln -sf /dev/stdout /var/log/nginx/access.log && \
    ln -sf /dev/stderr /var/log/nginx/error.log && \
    rm -rf /var/lib/nginx/tmp && \
    ln -sf /tmp /var/lib/nginx/tmp && \
    mkdir /etc/supervisor.d/ && \
    chown -R www-data:www-data /var/lib/nginx

COPY rootfs/ /
EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
