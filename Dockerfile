FROM php:8.0-apache

# Instalar extensiones de PHP necesarias
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip
RUN docker-php-ext-install pdo pdo_mysql zip

# Instalar dependencias necesarias para la extensión mongodb
RUN apt-get update && apt-get install -y libssl-dev
RUN pecl install mongodb && \
    docker-php-ext-enable mongodb

# Instalar Git
RUN apt-get install -y git

# Instalar Composer desde el binario
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"

# Copiar el código fuente de Laravel a la carpeta de trabajo
COPY . /var/www/html

# Establecer permisos adecuados
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Instalar dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# Ejecutar migraciones
RUN php artisan migrate

# Exponer el puerto 4000 en lugar del puerto 80
EXPOSE 4000

# Configurar el directorio de trabajo
WORKDIR /var/www/html

# Comando para iniciar el servidor de desarrollo de Laravel
CMD php artisan serve --host=0.0.0.0 --port=4000
