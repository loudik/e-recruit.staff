#!/usr/bin/env bash
set -euo pipefail

DOCROOT="/var/www/html/public"

# Apache modules & config
a2enmod rewrite headers

# Set DocumentRoot -> /public dan AllowOverride All
sed -ri -e "s!DocumentRoot /var/www/html!DocumentRoot ${DOCROOT}!g" /etc/apache2/sites-available/*.conf
sed -ri -e "s!<Directory /var/www/html>!<Directory ${DOCROOT}>!g" /etc/apache2/apache2.conf
sed -ri -e 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Hindari warning "could not reliably determine the server's fully qualified domain name"
echo "ServerName localhost" >/etc/apache2/conf-available/servername.conf || true
a2enconf servername || true

# ===== PHP extensions (idempotent) =====
# Intl untuk class Locale
if ! php -m | grep -qi '^intl$'; then
  apt-get update
  apt-get install -y --no-install-recommends libicu-dev
  docker-php-ext-configure intl
  docker-php-ext-install intl
  rm -rf /var/lib/apt/lists/*
fi

# PDO MySQL & MySQLi (kalau belum ada)
php -m | grep -qi '^pdo_mysql$' || docker-php-ext-install pdo_mysql
php -m | grep -qi '^mysqli$'    || docker-php-ext-install mysqli

# Jalankan Apache
exec apache2-foreground
