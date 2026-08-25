FROM php:8.3-cli-alpine
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
# intl is required by the rupiah helper (NumberFormatter); icu-dev is build-only
RUN apk add --no-cache icu-libs \
    && apk add --no-cache --virtual .build-deps icu-dev \
    && docker-php-ext-install pdo_mysql intl \
    && apk del .build-deps

# php -S needs a router so real files under public/ are served as-is.
# (artisan serve is avoided on purpose: it drops all but a whitelist of env vars)
RUN printf '%s\n' \
    '<?php' \
    '$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);' \
    'if ($path !== "/" && is_file("/app/public" . $path)) { return false; }' \
    'require "/app/public/index.php";' > /router.php

WORKDIR /app
CMD ["php", "-S", "0.0.0.0:8000", "-t", "/app/public", "/router.php"]
