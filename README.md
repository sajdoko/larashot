## About Larashot

Laravel web app to generate website screenshot.

# Requirements

* [NodeJS](https://nodejs.org/)
* [Composer](https://getcomposer.org/)
* [Google Chrome](https://www.google.com/chrome/)
* [Browsershot Laravel Package](https://github.com/spatie/browsershot)
* [Puppeteer Node library](https://github.com/GoogleChrome/puppeteer)



### To make it work on Centos 7:
## Step 1: Install Composer CentOS 7
```bash
sudo yum -y update

yum install php-cli php-zip wget unzip

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

HASH="$(wget -q -O - https://composer.github.io/installer.sig)"

php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"

php composer-setup.php --install-dir=/usr/local/bin --filename=composer

```
## Step 2: Install Node JS In CentOS 7

```bash
curl -sL https://rpm.nodesource.com/setup_10.x | sudo -E bash -
yum install nodejs
```
## Step 3: Install Chromium In CentOS 7

```bash
yum install pango.x86_64 libXcomposite.x86_64 libXcursor.x86_64 libXdamage.x86_64 libXext.x86_64 libXi.x86_64 libXtst.x86_64 cups-libs.x86_64 libXScrnSaver.x86_64 libXrandr.x86_64 GConf2.x86_64 alsa-lib.x86_64 atk.x86_64 gtk3.x86_64 ipa-gothic-fonts xorg-x11-fonts-100dpi xorg-x11-fonts-75dpi xorg-x11-utils xorg-x11-fonts-cyrillic xorg-x11-fonts-Type1 xorg-x11-fonts-misc
```

## Step 3: Install Laravel and Node dependencies
```bash
composer install

npm install
```