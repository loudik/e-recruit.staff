#!/usr/bin/env bash
set -euo pipefail

DOCROOT="${DOCROOT:-/var/www/html/public}"

# Apache modules & config
a2enmod rewrite headers

# Pindah DocumentRoot -> /public dan AllowOverride All
sed -ri -e "s!DocumentRoot /var/www/html!DocumentRoot ${DOCROOT}!g" /etc/apache2/sites-available/*.conf
sed -ri -e "s!<Directory /var/www/html>!<Directory ${DOCROOT}>!g" /etc/apache2/apache2.conf
sed -ri -e 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Hindari warning ServerName
echo "ServerName localhost" >/etc/apache2/conf-available/servername.conf || true
a2enconf servername || true

# ===== PHP extensions (idempotent) =====
# Intl (Locale)
if ! php -m | grep -qi '^intl$'; then
  apt-get update
  apt-get install -y --no-install-recommends libicu-dev ${PHPIZE_DEPS}
  docker-php-ext-configure intl
  docker-php-ext-install -j"$(nproc)" intl
  rm -rf /var/lib/apt/lists/*
fi

# PDO MySQL & MySQLi
php -m | grep -qi '^pdo_mysql$' || docker-php-ext-install pdo_mysql
php -m | grep -qi '^mysqli$'    || docker-php-ext-install mysqli

# Start Apache (PID 1)
exec apache2-foreground
