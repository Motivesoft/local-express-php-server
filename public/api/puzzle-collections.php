<?php

class PuzzleCollectionsService
{
    public static function getCollections($queryParams)
    {
        include 'db.php';

        $role = 0;  // Default role for an unregistered user
        if (isset($_SESSION['user_id'])) {
            // A user is logged on. What is their role?
            $stmt = $pdo->query("SELECT id,  FROM collections");
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        }

        $stmt = $pdo->query("SELECT id, short_prompt, long_prompt FROM collections");
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $items;
    }

    public static function getCollectionPuzzleList($queryParams)
    {
        include 'db.php';

        $collectionId = 1; // The default collection - regular, published puzzles 

        // Override with the 'c' (for 'collection') query parameter if present
        if (isset($queryParams['c'])) {
            $collectionId = $queryParams['c'];
        } else {
            error_log("No collection id provided. Using default");
        }

        $stmt = $pdo->prepare("SELECT id, name, size FROM puzzles WHERE collection_id = :collectionId");
        $stmt->execute(['collectionId' => $collectionId]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $items;
    }
}
