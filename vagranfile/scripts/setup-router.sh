#!/bin/bash

echo "=== Configuration du Routeur (VM1) ==="

# 1. Activer l'IP Forwarding (pour que la VM agisse comme un routeur)
sed -i 's/#net.ipv4.ip_forward=1/net.ipv4.ip_forward=1/' /etc/sysctl.conf
sysctl -p

# 2. Nettoyer les anciennes règles iptables (au cas où)
iptables -F
iptables -t nat -F

# Note : Sous Vagrant, l'interface reliée à Internet est généralement eth0.
# La DMZ sera sur eth1 et le LAN sur eth2.

# 3. Règle NAT (Masquerade) : Permettre aux réseaux internes d'accéder à Internet
iptables -t nat -A POSTROUTING -o eth0 -j MASQUERADE

# 4. Port Forwarding : Rediriger le port 80 de l'hôte vers le serveur Web (DMZ)
iptables -t nat -A PREROUTING -i eth0 -p tcp --dport 80 -j DNAT --to-destination 192.168.100.10:80

# 5. Règles de Sécurité (FORWARD)
# Accepter le trafic de retour (connexions déjà établies)
iptables -A FORWARD -m conntrack --ctstate RELATED,ESTABLISHED -j ACCEPT

# Autoriser le serveur Web (VM2) à contacter la Base de données (VM3) sur le port MySQL (3306)
iptables -A FORWARD -p tcp -s 192.168.100.10 -d 192.168.10.10 --dport 3306 -j ACCEPT

# Autoriser le Ping (ICMP) du serveur Web vers la Base de données (notre test)
iptables -A FORWARD -p icmp -s 192.168.100.10 -d 192.168.10.10 -j ACCEPT

# Sauvegarder les règles pour qu'elles persistent au redémarrage
apt-get update
DEBIAN_FRONTEND=noninteractive apt-get install -y iptables-persistent
netfilter-persistent save

echo "=== Routeur configuré avec succès ==="
