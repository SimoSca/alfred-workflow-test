<?php

/**
    In Alfred add this script:

    include_once("mysql.php");

    startMysql(trim("{query}"));

*/

    include_once("find_files.php");
    include_once("parse_file.php");



    function startShell($query){

        $shellFolder = $_ENV['shellFolder'];

        $search = explode(' ', trim($query) );

        $matchFile = $search[0];

        $matchQuery = $search[1];

        $foundFile = new FindQueriesFiles($shellFolder, $matchFile, 'shell');

        if ($foundFile->countMatch() === 1 || is_file($shellFolder . '/' . $matchFile)){
            $file = $foundFile->returnUnique();

            // var_dump($file);
            $parsedFile = new ParseQueriesFile($file);
            $parsedFile->printList();
        }
        else if(is_null($matchQuery) || $foundFile->countMatch() === 0){

            // print $foundFile
            $text = $foundFile->printList();
            echo $text;

        }

    }

