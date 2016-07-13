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

}
