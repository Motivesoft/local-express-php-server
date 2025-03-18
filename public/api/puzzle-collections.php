<?php

include_once("helper.php");

class PuzzleCollectionsService
{
    // Return collections for the logged-in user (or unregistered user)
    public static function getCollections($queryParams)
    {
        include 'db.php';

        $roleId = PuzzleCollectionsService::getRoleId();

        // Select the collections appropriate for the role of the logged on user
        $sql = "SELECT id, short_prompt, long_prompt 
                    FROM collections 
                    WHERE id IN (SELECT collection_id FROM role_collections WHERE role_id = :roleId)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['roleId' => $roleId]);

        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $items;
    }

    // Get metadata for the pizzles from a specific collection,
    // identified by passing its ID as a query param:
    //   - "...?c=2"
    public static function getCollectionPuzzleList($queryParams)
    {
        include 'db.php';

        // Make sure this is a request for a collection the user is allowed to access
        $collections = PuzzleCollectionsService::getCollections($queryParams);
        $collectionId = PuzzleCollectionsService::getCollectionId($queryParams);

        foreach( $collections as $collection ) {
            if( $collection['id'] == $collectionId ) {
                $sql = "SELECT id, name, size FROM puzzles WHERE collection_id = :collectionId";
        
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['collectionId' => $collectionId]);
        
                $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
                return $items;
            }
        }

        // Unauthorized
        return Helper::getErrorResponse401("You are not authorized to access this data.");
    }

    public static function getPuzzle($queryParams) {
    }

    // Get the role of the current user, defaulting to that for an unregistered user
    private static function getRoleId() {
        // Default role for an unregistered user
        $roleId = 1;  

        // Override with the logged on user, if there is one
        if (isset($_SESSION['user_id'])) {
            $roleId = $_SESSION['role_id'];
        }

        return $roleId;
    }

    // Get the collection ID from query parameters, or return the default
    private static function getCollectionId($queryParams) {
        // The default collection - regular, published puzzles 
        $collectionId = 1; 

        // Override with the 'c' (for 'collection') query parameter if present
        if (isset($queryParams['c'])) {
            $collectionId = $queryParams['c'];
        }

        return $collectionId;
    }
}
