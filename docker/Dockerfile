FROM php:7.2-apache

# Install / maj des différents paquets
RUN apt-get update || apt-get upgrade
RUN apt-get install -y gnupg2 \
    libicu-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libxml2-dev \
    nano \
    unzip \
    # pour wkhtmltopdf
    libxrender1 libfontconfig1


# install git, faire attention à mettre à jour le fichier git-completion.bash si la version de git change
RUN apt-get install -y git openssh-client bash-completion git-flow
RUN curl -sS https://raw.githubusercontent.com/git/git/v2.11.0/contrib/completion/git-completion.bash  > ~/.git-completion.bash
RUN curl -sS https://raw.githubusercontent.com/git/git/v2.11.0/contrib/completion/git-prompt.sh  > ~/.git-prompt.sh
RUN curl -sS https://raw.githubusercontent.com/petervanderdoes/git-flow-completion/master/git-flow-completion.bash  > ~/.git-flow-completion.bash
RUN echo "\nsource ~/.git-prompt.sh\nsource ~/.git-completion.bash\nsource ~/.git-flow-completion.bash\n" >> ~/.bashrc

# install nodejs
RUN curl -sL https://deb.nodesource.com/setup_11.x | bash - && apt-get install -y nodejs

# install xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Install yarn
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
    && echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list \
    && apt-get update && apt-get install yarn

# install composer
RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer


# Config du serveur
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
COPY ./custom.ini "$PHP_INI_DIR//conf.d/"
COPY ./opcache.ini "$PHP_INI_DIR//conf.d/"
COPY ./000-default.conf "/etc/apache2/sites-enabled/"

# configuration de gd
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/

# install php extension
RUN pecl install apcu && docker-php-ext-enable apcu
RUN docker-php-ext-install -j$(nproc) intl pdo_mysql gd zip bcmath soap opcache exif


# personalisation du prompt, [Docker]user@localhost:/chemin/en/cours (branche git en cours)
RUN echo "\n\nexport PS1='\[\e[38;5;39m\][Docker]\[\033[00m\]\u@\h:\w\[\033[0;33m\]\$(__git_ps1)\[\033[00m\] \\n\[\e[38;5;39m\]\\$\[\033[00m\] '" >> ~/.bashrc
