<?php

require_once("workflows.php");


class FindQueriesFiles {

    private $matchList = [];

    public function __construct($projectFolder, $query){
        
        // used into returnUnique
        $this->defaultFile = $projectFolder . '/' . $query;

        $files = scandir($projectFolder);
        
        foreach($files as $file) {    
            //do your work here
            if( preg_match('/queries/i', $file) && preg_match('/'.$query.'/i', $file) ){

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

        echo $wf->toxml();
    }

    public function returnUnique(){
        return $this->countMatch[0] ? $this->countMatch[0] : $this->defaultFile ;
    }

}// end class
 
