<?php

/**
 * @author Matheus Pisiconeri
 */
class ParserLog {

    private $fileName;
    private $jsonGame = array();
    private $countGame = 0;

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
        
    }

    private function clientUserinfoChanged($row) {
        
    }

    private function kill($row) {
        
    }

    private function shutdownGame($row) {
        
    }

}
