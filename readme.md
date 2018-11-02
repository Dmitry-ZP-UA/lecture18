# Unit тестирование

## Подготовка
Для того, чтобы запустить приложение, нам необходим PHP 7.2, т.к. Laravel в репозитории версии 5.7

Для начала давайте развернём приложение на Laravel.

```sh
$ sudo -s # заходим в рута
# apt-get update
# apt-get install -y software-properties-common
# add-apt-repository ppa:ondrej/php --yes
# apt-get update
# apt-get install -y composer \
    php7.2 \
    php7.2-mbstring \
    php7.2-bcmath \
    php7.2-xml \
    php7.2-soap \
    php7.2-curl \
    php7.2-dev \
    php7.2-gd \
    php7.2-zip \
    php7.2-mysql \
    php7.2-xml
# Нажимаем Ctrl + D либо пишем "exit" и нажимаем Enter чтобы выйти из root'a
$ git clone https://artem_proger@bitbucket.org/lightitit/testing.git
$ cd testing
$ composer install
```
Для запуска Unit тестов, нужно выполнить команду:
```sh
$ ./vendor/bin/phpunit tests/Unit
```