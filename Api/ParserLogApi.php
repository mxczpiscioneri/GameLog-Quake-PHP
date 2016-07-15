<?php/** * @author Matheus Piscioneri */class ParserLogApi {    private $file_name;    public function __construct() {        $this->file_name = "../games.log";        $method = $_SERVER['REQUEST_METHOD'];        $param_id = str_replace("/gamelog/api/", "", $_SERVER['REQUEST_URI']);        if ($method == 'GET') {            if (empty($param_id)) {                $this->getParserAll();            } else if (is_numeric($param_id) && $param_id > 0) {                $this->getParser($param_id);            }        }    }    private function getParser($id) {        require_once '../Model/GameClass.php';        require_once '../Controller/ParserLog.php';        $parser = new ParserLog($this->file_name);        $games = $parser->getJsonGame();        if (count($games) >= $id) {            echo $games[$id - 1];        }    }    private function getParserAll() {        require_once '../Model/GameClass.php';        require_once '../Controller/ParserLog.php';        $parser = new ParserLog($this->file_name);        $games = $parser->getJsonGame();        $games_array = "";        foreach ($games as $value) {            $games_array .= $value . ",";        }        echo '[' . rtrim($games_array, ",") . ']';    }}