<?php
require 'config.php';

header('Content-Type: application/json');

// Load API key from environment file
$apiKey = getenv('API_KEY');

function fetchRecipesFromAPI() {
    global $apiKey;
    $apiUrl = "https://api.spoonacular.com/recipes/random?number=10&apiKey=$apiKey";

    $response = file_get_contents($apiUrl);
    if ($response === FALSE) {
        return null;
    }
    $data = json_decode($response, true);
    return $data['recipes'] ?? [];
}

function saveRecipesToMongoDB($recipes) {
    $collection = getMongoDBCollection();
    foreach ($recipes as $recipe) {
        // Use upsert to avoid duplicate recipes based on recipe ID
        $collection->updateOne(
            ['id' => $recipe['id']],
            ['$set' => $recipe],
            ['upsert' => true]
        );
    }
}

// Check if MongoDB has existing recipes
function getRecipesFromMongoDB() {
    $collection = getMongoDBCollection();
    return $collection->find()->toArray();
}

// Fetch recipes either from MongoDB or API
$recipes = getRecipesFromMongoDB();
if (empty($recipes)) {
    $recipes = fetchRecipesFromAPI();
    if ($recipes) {
        saveRecipesToMongoDB($recipes);
    }
}

echo json_encode($recipes);
?>
