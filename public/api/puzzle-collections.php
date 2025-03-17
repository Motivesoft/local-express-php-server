<?php

class PuzzleCollectionsService
{
    public static function getCollections()
    {
        return [
            "collections" => [
                [
                    "id" => "1",
                    "shortPrompt" => "Shorter Name",
                    "longPrompt" => "This is a big long string about a collection",
                ],
                [
                    "id" => "2",
                    "shortPrompt" => "Test Name",
                    "longPrompt" => "This is another long string about a collection",
                ],
                [
                    "id" => "3",
                    "shortPrompt" => "Archive",
                    "longPrompt" => "This is waffle about our extensive archive",
                ],
            ]
        ];
    }
}
