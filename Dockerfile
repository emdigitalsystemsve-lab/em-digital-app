FROM php:8.2-cli
COPY . /usr/src/myapp
WORKDIR /usr/src/myapp
EXPOSE 10000
CMD [ "php", "-S", "0.0.0.0:10000" ]
