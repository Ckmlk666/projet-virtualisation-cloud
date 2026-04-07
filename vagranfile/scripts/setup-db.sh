#!/bin/bash

echo "=== Configuration de la Base de Données (VM3) ==="

# 1. Installation de MySQL
apt-get update
apt-get install -y mysql-server

# 2. Configuration réseau de MySQL
# Par défaut, MySQL n'écoute que sur localhost (127.0.0.1). 
# On modifie ça pour qu'il écoute sur son adresse IP LAN (192.168.10.10) ou 0.0.0.0
sed -i 's/bind-address\s*=\s*127.0.0.1/bind-address = 0.0.0.0/' /etc/mysql/mysql.conf.d/mysqld.cnf

# Redémarrer MySQL pour appliquer le changement
systemctl restart mysql

# 3. Création de la base de données et de l'utilisateur pour Laravel
# Attention : Remplace 'TonMotDePasse' par le mot de passe que tu utilises dans le fichier .env de Laravel
mysql -e "CREATE DATABASE IF NOT EXISTS space_explorer;"
mysql -e "CREATE USER IF NOT EXISTS 'laravel_user'@'192.168.100.10' IDENTIFIED BY 'TonMotDePasse';"
mysql -e "GRANT ALL PRIVILEGES ON space_explorer.* TO 'laravel_user'@'192.168.100.10';"
mysql -e "FLUSH PRIVILEGES;"

echo "=== Base de données configurée avec succès ==="
