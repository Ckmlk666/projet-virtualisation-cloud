# 🚀 L'ESPACE - Projet Virtualisation & Cloud

Ce projet met en œuvre une architecture 3-tiers virtualisée et sécurisée, hébergeant une application d'exploration spatiale 3D développée avec Laravel et Three.js.

## 🏗️ Architecture et Topologie Réseau
L'infrastructure repose sur 3 machines virtuelles Ubuntu Server 22.04 :
* **VM1 (Routeur/Firewall) :** Gestion du NAT et règles iptables.
  * WAN : DHCP
  * DMZ : `192.168.100.1/24`
  * LAN : `192.168.10.1/24`
* **VM2 (Serveur Web) :** Situé en DMZ (`192.168.100.10`). Exécute Nginx, PHP 8.1 et Laravel.
* **VM3 (Serveur BDD) :** Situé dans le LAN sécurisé (`192.168.10.10`). Exécute MySQL 8.0.

## 🔒 Sécurité
* La base de données (VM3) est totalement isolée d'Internet.
* Seule la VM2 est autorisée à communiquer avec la VM3 via le port 3306 (règles de pare-feu iptables sur VM1 + UFW).
* L'application web est accessible depuis l'hôte grâce au Port Forwarding sur la VM1.

## ⚙️ Provisionnement
Conformément aux exigences du projet, le code applicatif et les configurations réseau sont versionnés dans ce dépôt. 
Pour déployer une mise à jour sur le serveur Web (VM2) :
```bash
cd /var/www/laravel-app
git pull origin main
php artisan optimize:clear
