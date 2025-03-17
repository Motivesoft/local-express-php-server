<?php

class PuzzleCollectionsService
{
    // Return collections for the logged-in user (or unregistered user)
    public static function getCollections($queryParams)
    {
        include 'db.php';

        $roleId = 1;  // Default role for an unregistered user
        if (isset($_SESSION['user_id'])) {
            // A user is logged on. What is their role?
            $roleId = $_SESSION['role_id'];
        }

        // Select the collections appropriate for the role of the logged on user
        $sql = "SELECT id, short_prompt, long_prompt 
                    FROM collections 
                    WHERE id IN (SELECT collection_id FROM role_collections WHERE role_id = :roleId)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['roleId' => $roleId]);

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

        $sql = "SELECT id, name, size FROM puzzles WHERE collection_id = :collectionId";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['collectionId' => $collectionId]);

        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $items;
    }
}
