<?php

require_once("workflows.php");


class FindQueriesFiles {

    private $matchList = [];

    public function __construct($projectFolder, $query, $matchName){
        
        

        $files = scandir($projectFolder);
        
        foreach($files as $file) {    
            //do your work here
            if( preg_match('/'.$matchName.'/i', $file) && preg_match('/'.$query.'/i', $file) ){


                // var_dump($file);

                $count = count( $this->matchList );

                $this->matchList[] = [
                    "uid" => $count . "-PM",
                    "type"=> "file",
                    "title"=> $file,
                    "subtitle"=> "is_file",
                    "arg"=> $projectFolder .'/' . $file,
                    "autocomplete"=> $file,
                    "icon" => 'assets/file.png',
                    "valid" => "no"
                ];
            }
        } 

        // used into returnUnique
        $file = $projectFolder . '/' . $query ;
        $this->defaultFile = is_file($file) ? $file : $this->matchList[0]["arg"];

    }


    public function countMatch(){
        return count( $this->matchList );
    }

    public function printList(){

        $wf = new Workflows();

        if($this->countMatch() == 0) {
            $wf->result("999","","No Project Type matches \$clean!", "Project Manager", 'icon.png', 'no');
        }else{
            foreach($this->matchList as $item){
                $wf->result( $item["uid"] ,$item["arg"] ,$item["title"] , $item["subtitle"], $item["icon"], $item["valid"], $item["autocomplete"] );
            }
        }

        return $wf->toxml();
    }

    public function returnUnique(){
        return $this->defaultFile ;
    }

}// end class
 
