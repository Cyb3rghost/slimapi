# Slim Framework 3 Skeleton Application

Téléchargez le framework (la version 3) sur le site : https://www.slimframework.com/
Tapez : composer update pour effectuer la mise à jour.

## Création d'un hôte virtuel sous XAMPP

Rendez-vous dans le fichier : XAMPP / apache / conf / extra / httpd-vhosts.conf
Rajoutez à la fin de la ligne le code suivant : 

<VirtualHost *:80>  
DocumentRoot ICI LE CHEMIN VERS VOTRE DOSSIER  
<Directory "ICI LE CHEMIN VERS VOTRE DOSSIER">  
Options FollowSymLinks  
AllowOverride All  
Order allow,deny  
Allow from all  
</Directory>  
</VirtualHost>  

Tout en haut dans le fichier décommentez le code suivant : NameVirtualHost *:80

Rendez-vous dans le fichier : C: \ Windows \ System32 \ drivers \ etc \ hosts
Ajoutez à la fin du fichier : 127.0.0.1 slimrestapi

Redemarrez le serveur et vous pouvez ensuite taper : http://slimrestapi (ou le nom du dossier que vous avez choisie.)

## Créer une table de base de données MySQL

Rendez-vous dans PHPMYADMIN, créer une base de donnée et exécutez les requêtes suivantes : 

CREATE TABLE `developers` (  
`id` int(11) NOT NULL,  
`name` varchar(255) NOT NULL,  
`skills` varchar(255) NOT NULL,  
`address` varchar(255) NOT NULL,  
`gender` varchar(255) NOT NULL,  
`designation` varchar(255) NOT NULL,  
`age` int(11) NOT NULL,  
`image` varchar(255) NOT NULL  
) ENGINE=InnoDB DEFAULT CHARSET=latin1;  

Puis : 

INSERT INTO `developers` (`id`, `name`, `skills`, `address`, `gender`, `designation`, `age`, `image`) VALUES  
(1, 'Smith', 'Java', 'Newyork', 'Male', 'Software Engineer', 34, 'image_1.jpg'),  
(2, 'David', 'PHP', 'London', 'Male', 'Web Developer', 28, 'image_2.jpg'),  
(3, 'Rhodes', 'jQuery', 'New Jersy', 'Male', 'Web Developer', 30, 'image_2.jpg'),  
(4, 'Sara', 'JavaScript', 'Delhi', 'Female', 'Web Developer', 25, 'image_2.jpg'),  
(5, 'Shyrlin', 'NodeJS', 'Tokiyo', 'Female', 'Programmer', 35, 'image_2.jpg');  

## Configuration de l'accès à la base de donnée

Rendez-vous dans le dossier du projet ici "slimrestapi" puis ouvrez le fichier qui se trouve dans src/settings.php.
Rajoutez ce tableau d'informations : 

"db" => [  
"host" => "localhost",  
"dbname" => "phpzag_demos",  
"user" => "root",  
"pass" => "123456"  
],

Entrez les informations concernant votre base de donnée.
Puis rendez-vous dans le dossier src/dependencies.php pour configurer la bibliothèque de base de donnée PHP PDO.

$container['db'] = function ($c) {  
$settings = $c->get('settings')['db'];  
$pdo = new PDO("mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'],  
$settings['user'], $settings['pass']);  
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);  
return $pdo;  
};  

Voici un tableau d'informations concernant les routes existantes (mais si vous souhaitez modifier ou rajouter des routes, rendez-vous dans src/routes.php).

GET	/developers	Récupérer tous les développeurs  
GET	/developer/1	Récupérer le développeur avec l'ID == 1  
POST	/developer/insert	Ajouter un nouveau développeur  
PUT	/developer/update/1  Mettre à jour le développeur avec l'ID == 1  
DELETE	/developer/delete/1	Supprimer le développeur avec l'ID == 1  

**IMPORTANT** : Aidez vous du logiciel POSTMAN pour exécuter les routes. Bon courage !
