<?php

/**
 * @author Matheus Piscioneri
 */
class ParserLogTest extends PHPUnit_Framework_TestCase {

    private $file_name;

    public function setUp() {
        $this->file_name = "../games.log";
    }

    public function testFileLogExist() {
        $this->assertFileExists($this->file_name);
    }

    public function testOpenFileLog() {
        $this->assertInternalType('resource', fopen($this->file_name, "r"));
    }

    public function testFileLogEmpty() {
        $this->assertNotEmpty(file_get_contents($this->file_name));
    }

}
