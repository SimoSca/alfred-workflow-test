<?php

require_once("workflows.php");

class ParseQueriesFile {

    private $matchList = [];

    public function __construct($file){
        
        // var_dump('file', $file);

        $this->file = $file;

        $text = file_get_contents($file);
        
        preg_match_all('/#### *([^\r?\n]+)\r?\n(.+)````?[^\r?\n]*\r?\n(.*)````?/misU', $text, $matches);

        // var_dump('match', $matches);

        $sections = $this->sectionize($matches);
        // var_dump('secs', $sections);
        $this->generateMatchList($sections);
    }

    private function sectionize($matches){
        $sections = [];
        foreach($matches[1] as $key => $val){
            $sections[] = [
                'title' => trim($matches[1][$key]),
                'description' => trim($matches[2][$key]),
                'code' => trim($matches[3][$key])
            ];
        }
        return $sections;
    }

    private function generateMatchList($sections){

        foreach($sections as $section){
            $count = count( $this->matchList );
            // var_dump($this->matchList);

                $this->matchList[] = [
                    "uid" => $count . "-PM",
                    "type"=> "file",
                    "title"=> $section['title'],
                    "subtitle"=> $section['description'],
                    "arg"=> $section['code'],
                    "autocomplete"=> '...',
                    "icon" => 'assets/db.png',
                    "valid" => "yes"
                ];
        }

    }

    public function countMatch(){
        return count( $this->matchList );
    }

    public function printList(){

        // var_dump($this->matchList);

        $wf = new Workflows();

        if($this->countMatch() == 0) {
            $wf->result("999","","File " . $this->file . " has not sections...", "bad file", 'icon.png', 'no');
        }else{
            foreach($this->matchList as $item){
                $wf->result( $item["uid"] ,$item["arg"] ,$item["title"] , $item["subtitle"], $item["icon"], $item["valid"], $item["autocomplete"] );
            }
        }

        echo $wf->toxml();
    }


}// end class

//new ParseQueriesFile('/Users/simonescardoni/Working/wlogo/Mixed/mysql/queries.md');

