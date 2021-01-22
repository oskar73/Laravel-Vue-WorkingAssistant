FROM laravelphp/vapor:php81

RUN apk add --update --no-cache \
    exiftool \
    && docker-php-ext-configure exif \
    && docker-php-ext-install exif \
    && docker-php-ext-enable exif

COPY . /var/task
