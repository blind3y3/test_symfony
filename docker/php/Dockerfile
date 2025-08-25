FROM php:8.3-fpm-bullseye AS base

WORKDIR /app

# timezone environment
ENV TZ=UTC \
  # locale
  LANG=en_US.UTF-8 \
  LANGUAGE=en_US:en \
  LC_ALL=en_US.UTF-8 \
  # composer environment
  COMPOSER_HOME=/composer

ARG UID=1000
ARG GID=1000

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# hadolint ignore=DL3008
RUN apt-get update && apt-get -y install --no-install-recommends \
    locales \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    librabbitmq-dev \
    libssl-dev  \
    && \
    locale-gen en_US.UTF-8 && \
    localedef -f UTF-8 -i en_US en_US.UTF-8 && \
    docker-php-ext-install \
        intl \
        zip \
        bcmath \
        pdo \
        mysqli \
        pdo_mysql \
    && \
    pecl install amqp && \
    groupadd --gid ${GID} phper && \
    useradd --uid ${UID} --gid ${GID} phper && \
    mkdir /composer && \
    mkdir -p /home/phper/.config/psysh && \
    chown phper:phper /composer /app /home/phper/.config/psysh && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*


FROM base AS development

COPY docker/php/php.development.ini /usr/local/etc/php/php.ini

USER phper

FROM base AS development-xdebug

RUN <<EOF
  pecl install xdebug
  docker-php-ext-enable xdebug amqp
EOF

COPY docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

USER phper