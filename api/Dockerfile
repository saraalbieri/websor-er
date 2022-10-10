FROM yiisoftware/yii2-php:7.1-apache

# Change document root for Apache
RUN sed -i -e 's|/app/web|/app/api/web|g' /etc/apache2/sites-available/000-default.conf


#FROM webdevops/php-nginx:7.1
#
#RUN apt-get update && apt-get install nano
#RUN apt-get install autoconf automake libtool m4 -y
#RUN apt-get install --reinstall procps -y
#
## Kafka
#RUN cd / && git clone https://github.com/edenhill/librdkafka.git && cd librdkafka && ./configure && make && make install
## php rdkafka
#RUN pecl install rdkafka
#
#RUN echo extension=rdkafka.so >> /usr/local/etc/php/conf.d/20-rdkafka.ini
#
#
##Rabbit
#
#RUN apt-get -y install gcc make autoconf libc-dev pkg-config
#RUN apt-get -y install libssl-dev
#RUN apt-get -y install librabbitmq-dev
##RUN pecl install amqp
#
#RUN echo extension=amqp.so >> /usr/local/etc/php/conf.d/20-amqp.ini