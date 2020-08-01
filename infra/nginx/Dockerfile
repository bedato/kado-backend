FROM nginx:latest


RUN apt-get update && apt-get install -y --no-install-recommends ca-certificates \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN rm -f /etc/nginx/conf.d/default.conf

COPY fastcgi_params /etc/nginx/fastcgi_params
COPY default.template /etc/nginx/conf.d/default.template

COPY server.cert /etc/ssl/server.cert
COPY server.key /etc/ssl/server.key

RUN update-ca-certificates
