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

    public function testTotalKillsNotIsNull() {
        require_once '../Model/GameClass.php';
        $game = new GameClass();

        //kill = 0
        $this->assertEquals(0, $game->getTotal_kills());
    }

    public function testAddKill() {
        require_once '../Model/GameClass.php';
        $game = new GameClass();

        //kill = 1
        $game->addKill();
        $this->assertEquals(1, $game->getTotal_kills());

        //kill = 2
        $game->addKill();
        $this->assertEquals(2, $game->getTotal_kills());
    }

    public function testTotalKillsEqualsTotalMeans() {
        require_once '../Model/GameClass.php';
        require_once '../Controller/ParserLog.php';

        $parser = new ParserLog($this->file_name);
        $games = $parser->getJsonGame();

        foreach ($games as $data) {
            $item = json_decode($data);
            foreach ($item as $game) {
                //get total_kills
                $total_kills = $game->total_kills;
                $total_means = 0;
                foreach ($game->means as $means) {
                    //get total_means
                    $total_means += $means;
                }
            }
        }
        $this->assertEquals($total_kills, $total_means);
    }

}
