FROM php:8.0-apache

# Instalar extensiones de PHP necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Instalar dependencias necesarias para la extensión mongodb
RUN apt-get update && apt-get install -y libssl-dev

# Instalar el cliente de MongoDB para PHP
RUN pecl install mongodb && \
    docker-php-ext-enable mongodb

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

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
