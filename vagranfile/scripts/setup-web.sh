#!/bin/bash

echo "=== Configuration du Serveur Web (VM2) ==="

# 1. Mise à jour et installation des paquets requis
apt-get update
apt-get install -y nginx git unzip curl

# Installation de PHP et de l'extension MySQL
apt-get install -y php-fpm php-mysql php-cli php-mbstring php-xml php-bcmath

# 2. Installation de Composer (Gestionnaire de dépendances pour Laravel)
curl -sS https://getcomposer.org/installer -o composer-setup.php
php composer-setup.php --install-dir=/usr/local/bin --filename=composer

# 3. Préparation du répertoire Web
# (Tu remplaceras l'URL par le vrai lien de ton dépôt Git de l'application Laravel)
# cd /var/www/html
# git clone https://github.com/TonUtilisateur/TonProjetLaravel.git espace_explorer
# chown -R www-data:www-data /var/www/html/espace_explorer

# 4. Démarrage et activation de Nginx
systemctl enable nginx
systemctl restart nginx

echo "=== Serveur Web configuré avec succès ==="
