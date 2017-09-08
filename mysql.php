<?php

/**
    In Alfred add this script:

    include_once("mysql.php");

    startMysql(trim("{query}"));

*/

    include_once("find_files.php");
    include_once("parse_file.php");



    function startMysql($query){

        $mysqlFolder = $_ENV['mysqlFolder'];

        $search = explode(' ', trim($query) );

        $matchFile = $search[0];

        $matchQuery = $search[1];

        $foundFile = new FindQueriesFiles($mysqlFolder, $matchFile , 'queries');

        if ($foundFile->countMatch() === 1 || is_file($mysqlFolder . '/' . $matchFile)){
            $file = $foundFile->returnUnique();
            $parsedFile = new ParseQueriesFile($file);
            $parsedFile->printList();
        }
        else if(is_null($matchQuery) || $foundFile->countMatch() === 0){

            // print $foundFile
            $text = $foundFile->printList();
            echo $text;

        }

    }

