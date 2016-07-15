<?php

/**
 * @author Matheus Piscioneri
 */
class ParserLogApiTest extends PHPUnit_Framework_TestCase {

    public function testGetParserAll() {
        $options = array('http' => array('method' => 'GET'));
        $context = stream_context_create($options);
        $response = file_get_contents('http://localhost/gamelog/api/', false, $context);
        $this->assertNotEmpty($response);
    }

    public function testGetParser() {
        $options = array('http' => array('method' => 'GET'));
        $context = stream_context_create($options);
        $response = file_get_contents('http://localhost/gamelog/api/3', false, $context);
        $this->assertNotEmpty($response);
    }

    public function testGetParserAllGame() {
        $options = array('http' => array('method' => 'GET'));
        $context = stream_context_create($options);
        $response = file_get_contents('http://localhost/gamelog/api/', false, $context);
        $this->assertNotEquals(1, count(json_decode($response)));
    }

    public function testGetParserOneGame() {
        $options = array('http' => array('method' => 'GET'));
        $context = stream_context_create($options);
        $response = file_get_contents('http://localhost/gamelog/api/3', false, $context);
        $this->assertEquals(1, count(json_decode($response)));
    }

    public function testMethodIncorrect() {
        $options = array('http' => array('method' => 'PUT'));
        $context = stream_context_create($options);
        $response = file_get_contents('http://localhost/gamelog/api/', false, $context);
        $this->assertEmpty($response);
    }

}
