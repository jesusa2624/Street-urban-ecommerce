# Establece la imagen base (PHP 8.4 + Apache)
FROM docker.io/library/php:8.4-apache

# Instala dependencias necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libicu-dev \
    locales \
    unzip \
    git \
    curl \
    nano \
    netcat-openbsd \
    imagemagick \
    libmagickwand-dev \
    && docker-php-ext-install \
      intl \
      pdo_mysql \
      zip \
      exif \
      bcmath \
      opcache \
    && pecl install \
      imagick \
    && docker-php-ext-enable \
      imagick \
    && apt-get purge -y --auto-remove \
    && rm -rf /var/lib/apt/lists/*

# Instala Composer
RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer

# Instala Node.js 24 LTS
RUN curl -fsSL https://deb.nodesource.com/setup_24.x | bash - \
    && apt-get install -y nodejs

# Establece la configuración regional como Español (Perú)
RUN echo "es_PE.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen es_PE.UTF-8 && \
    update-locale LANG=es_PE.UTF-8

# Activa módulos de Apache para obtener vistas MVC y XAMPP (modo de desarrollo)
RUN a2enmod rewrite autoindex

# Crea un `php.ini` personalizado (modo de desarrollo)
RUN cp "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
RUN echo "\nupload_max_filesize = 64M\n" \
         "post_max_size = 64M\n" \
         "memory_limit = 128M\n" \
         "max_execution_time = 300\n" \
         >> /usr/local/etc/php/php.ini

# Establece la raíz de documento en `localhost/public`
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
 && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN sed -i 's/Listen 80/Listen [::]:3001/' /etc/apache2/ports.conf \
    && sed -i 's/:80/:3001/g' /etc/apache2/sites-enabled/000-default.conf
EXPOSE 3001

# Directorio de trabajo por defecto
WORKDIR /var/www/html

# Añade excepción de propiedad para Git
RUN git config --global --add safe.directory /var/www/html

# Establece el código a ejecutar cada vez que arranque el contenedor
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]
