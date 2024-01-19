# projetcabinetPHP
Projet de cabinet médical réalisé en PHP BIGNON Charley GAYRARD Matéo

Mini projet de gestion de cabinet médical développé en PHP
Réalisé par:
	BIGNON Charley
	GAYRARD MATEO

Le projet étant réalisé en architecture MCV, nous avons eu du mal à le déployer sur un serveur distant à cause de la réécriture d'URL.
Notre application est donc disponible uniquement en local.

Afin de configurer au mieux cette application, réaliser les actions suivantes:
- dans le fichier C:\xampp\apache\conf\extra\httpd-vhosts.conf ajouter les lignes:
	<VirtualHost *:80>
    		ServerAdmin charley.bignon@etu.iut-tlse3.fr
    		ServerName www.cabinet.local
    		DocumentRoot "C:/xampp/htdocs/cabinet/public"
    		ErrorLog "logs/cabinet-error.log"
   		CustomLog "logs/cabinet-access.log" common
	</VirtualHost>

-dans le fichier C:\Windows\System32\drivers\etc\hosts ajouter la ligne :
	127.0.0.1 www.cabinet.local

-redémarrer apache

Après ces configurations, le fichier est disponible à l'adresse http://www.cabinet.local/connexion pour se connecter
