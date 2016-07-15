<?php

/**
 * @author Matheus Pisiconeri
 */
class ParserLog {

    private $fileName;
    private $jsonGame = array();
    private $countGame = 0;
    private $game;
    private $kills;

    public function __construct($fileName) {
        $this->fileName = $fileName;
        $this->init();
    }

    private function init() {
        try {
            //check if file exist
            if (!file_exists($this->fileName)) {
                throw new Exception('File not found.');
            }

            //open file
            $log = fopen($this->fileName, 'r');
            //check if opened file
            if (!$log) {
                throw new Exception('File open failed.');
            }

            //check if exist content
            if (trim(file_get_contents($this->fileName)) == false) {
                throw new Exception('File is empty.');
            }

            //read file
            $this->readLog($log);

            //closes an open file pointer
            fclose($log);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    private function readLog($log) {

        //while end-of-file is false
        while (!feof($log)) {
            //read line of file
            $row = $this->getRow($log);

            //compare the log command
            switch ($row['command']) {
                case 'InitGame':
                    $this->initGame($row);
                    break;
                case 'ClientUserinfoChanged':
                    $this->clientUserinfoChanged($row);
                    break;
                case 'Kill':
                    $this->kill($row);
                    break;
                case '------------------------------------------------------------':
                case 'ShutdownGame':
                    $this->shutdownGame($row);
                    break;
                default:
                    break;
            }
        }
    }

    private function getRow($file) {
        //get row from file
        $row = fgets($file, 4096);

        //if row is not empty
        if (!empty($row)) {
            $params = explode(":", trim($row), 3);

            $time = explode(" ", $params[0], 2);
            $time = isset($time[1]) ? $time[1] : $time[0];
            $time = trim($time . ":" . $params[1]);
            $time_command = explode(" ", $time, 2);

            $result['params'] = isset($params[2]) ? $params[2] : '';
            $result['time'] = $time_command[0];
            $result['command'] = $time_command[1];
            return $result;
        }
        return false;
    }

    private function initGame($row) {
        $this->game = new GameClass();
        $this->kills = array();

        //add 1 to set gameID
        $this->countGame ++;

        //set time start
        $this->game->setStart_time($row['time']);

        //set id game
        $this->game->setId($this->countGame);
    }

    private function clientUserinfoChanged($row) {
        $player = explode('\t\\', $row['params'], 2);
        $player = explode(' n\\', $player[0], 2);

        //check if player's name exists
        if (!in_array($player[1], $this->game->getPlayers())) {
            //set name player
            $this->game->setPlayers($player[1]);
        }
    }

    private function kill($row) {
        //add 1 kill
        $this->game->addKill();

        $value = explode(":", $row['params'], 2);
        $value = explode("killed", $value[1]);
        $p_killer = trim($value[0]);
        $value = explode(" by ", trim($value[1]));
        $p_killed = trim($value[0]);
        $mod = trim($value[1]);

        //add killer and killed
        $this->setKill($p_killer, $p_killed);
    }

    private function shutdownGame($row) {
        
    }

    private function setKill($p_killer, $p_killed) {
        if ($p_killer == "<world>") {
            //if killer is <world>, remove 1 kill of the killed
            $this->kills[$p_killed] = (isset($this->kills[$p_killed]) ? $this->kills[$p_killed] : 0) - 1;
        } else if ($p_killer == $p_killed) {
            //if killer killed himself, remove 1 kill
            $this->kills[$p_killer] = (isset($this->kills[$p_killer]) ? $this->kills[$p_killer] : 0) - 1;
        } else {
            //if killer killed opponent, add 1 kill
            $this->kills[$p_killer] = (isset($this->kills[$p_killer]) ? $this->kills[$p_killer] : 0) + 1;
        }
    }

}
