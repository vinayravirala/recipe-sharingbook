<?php
require 'vendor/autoload.php';  // Include Composer dependencies

use MongoDB\Client as MongoDBClient;

function getMongoDBCollection() {
    // Set up MongoDB client and select the database and collection
    $client = new MongoDBClient("mongodb://localhost:27017");
    $database = $client->selectDatabase("recipeBookDB");
    return $database->selectCollection("recipes");
}
?>
