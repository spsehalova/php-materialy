# Windows

Instalacia WSL, PHP a PHPSTORM na windowse.

# Github PRO

1. Vytvor si ucet na [github.com](https://github.com)
2. Zaregistruj sa na [education.github.com/pack](https://education.github.com/pack) pre student developer pack

# PHPSTORM (Jetbrains)

1. Vytvorit ucet na https://www.jetbrains.com **pomocou GITHUB uctu/loginu**
2. Stiahnut JETBRAINS TOOLBOX
3. Pomocou toolboxu stiahnut PHPSTORM

# WSL

1. Otvor CMD ako administrator
2. Spusti prikaz `wsl --install`
3. Ako usera a heslo si zadaj nieco jednoduche
4. Restart PC

# PHP

```shell
sudo apt update -y
sudo apt ugrade -y
sudo apt install ca-certificates apt-transport-https software-properties-common lsb-release -y
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update -y
sudo apt upgrade -y
sudo apt install php8.3 php8.3-cli -y
sudo apt install openssl php8.3-bcmath php8.3-curl php8.3-mbstring php8.3-mysql php8.3-tokenizer php8.3-xml php8.3-zip php8.3-sqlite3 
```

## Composer (package manager)

```shell
sudo apt install unzip -y

# download
cd ~ && curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php`

# verifikacia
HASH=`curl -sS https://composer.github.io/installer.sig`
php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
 
 # instalacia
sudo php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
```
