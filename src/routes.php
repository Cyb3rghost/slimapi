<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/', function ($request, $response, $args) {
    $this->logger->info("index '/' route");
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/developers', function ($request, $response, $args) {
	$this->logger->info("index '/' route");
    $sth = $this->db->prepare("SELECT id, name, skills, address, gender, designation, age FROM developers ORDER BY id"); // On initialise la requete global
    $sth->execute(); // On execute
    $developer = $sth->fetchAll(); // On recupère toute les données pour l'affichage
	return $this->response->withJson($developer); // On retourne une réponse du tableau donnée.
});


$app->get('/developer/{id}', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT id, name, skills, address, gender, designation, age FROM developers WHERE id=:id"); // On initialise la requete pour obtenir une ligne à partir d'un ID
	$sth->bindParam("id", $args['id']); // On associe l'identifiant de la requête avec l'argument reçu
    $sth->execute(); // On execute
    $developer = $sth->fetchObject(); // On recupere la donnée obtenue
	return $this->response->withJson($developer);  // On retourne une réponse du résultat donnée.  
});

 $app->post('/developer/insert', function ($request, $response) {
	$developer = $request->getParsedBody(); // On parse l'ensemble de la réponse.

	$sql = "INSERT INTO developers (name, skills, address, gender, designation, age) VALUES (:name, :skills, :address, :gender, :designation, :age)"; // On initialise la requete qui va insérer la donnée
	$sth = $this->db->prepare($sql); // On prépare l'ensemble de la requête.
	$sth->bindParam("name", $developer['name']); // On associe le paramètre nom de la requête avec l'argument reçu.
    $sth->bindParam("skills", $developer['skills']); // On associe le paramètre skills de la requête avec l'argument reçu.
	$sth->bindParam("address", $developer['address']); // On associe le paramètre adresse de la requête avec l'argument reçu.
	$sth->bindParam("gender", $developer['gender']); // On associe le paramètre gender de la requête avec l'argument reçu.
	$sth->bindParam("designation", $developer['designation']); // On associe le paramètre designation de la requête avec l'argument reçu.
	$sth->bindParam("age", $developer['age']); // On associe le paramètre age de la requête avec l'argument reçu.
	$sth->execute(); // On execute
	$developer->id = $this->db->lastInsertId(); // On recupère l'identifiant de la dernière requête effectuer.
	return $this->response->withJson($developer); // On retourne une réponse avec les informations obtenue.
});

$app->post('/developer/update', function ($request, $response, $args) {
	$developer = $request->getParsedBody(); // On parse l'ensemble de la réponse

	$sql = "UPDATE developers SET name=:name, skills=:skills, address=:address, gender=:gender, designation=:designation, age=:age  WHERE id=:id"; // On initialise la requête de mise à jour
	$sth = $this->db->prepare($sql); // On prépare l'ensemble de la requête
	$sth->bindParam("name", $developer['name']); // On associe le paramètre nom de la requête avec l'argument reçu.
    $sth->bindParam("skills", $developer['skills']); // On associe le paramètre skills de la requête avec l'argument reçu.
	$sth->bindParam("address", $developer['address']); // On associe le paramètre adresse de la requête avec l'argument reçu.
	$sth->bindParam("gender", $developer['gender']); // On associe le paramètre gender de la requête avec l'argument reçu.
	$sth->bindParam("designation", $developer['designation']); // On associe le paramètre designation de la requête avec l'argument reçu.
	$sth->bindParam("age", $developer['age']); // On associe le paramètre age de la requête avec l'argument reçu.
	$sth->bindParam("id", $developer['id']); // On associe le paramètre id de la requête avec l'argument reçu.
	$sth->execute(); // On execute
	return $this->response->withJson($developer); // On retourne une réponse avec les informations obtenue.
});

$app->delete('/developer/delete/[{id}]', function ($request, $response, $args) {
	$sth = $this->db->prepare("DELETE FROM developers WHERE id=:id"); // On initialise la requête de suppression
	$sth->bindParam("id", $args['id']); // On associe le paramètre identifiant de la requête avec l'argument id
	$sth->execute(); // On execute
	$sthDeux = $this->db->prepare("SELECT id, name, skills, address, gender, designation, age FROM developers ORDER BY id"); // On prepare une nouvelle requête global
	$developer = $sthDeux->fetchAll(); // On recupere la nouvelle donneee obtenue
	return $this->response->withJson($developer); // On retourne une reponse avec les informations obtenue.
});