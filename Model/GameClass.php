<?php

/**
 * @author Matheus Pisiconeri
 */
class GameClass {

    private $id;
    private $start_time;
    private $end_time;
    private $total_kills;
    private $players = array();
    private $kills = array();
    private $means = array();

    public function getId() {
        return $this->id;
    }

    public function getStart_time() {
        return $this->start_time;
    }

    public function getEnd_time() {
        return $this->end_time;
    }

    public function getTotal_kills() {
        return is_null($this->total_kills) ? 0 : $this->total_kills;
    }

    public function getPlayers() {
        return $this->players;
    }

    public function getKills() {
        return $this->kills;
    }

    function getMeans() {
        return $this->means;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setStart_time($start_time) {
        $this->start_time = $start_time;
    }

    public function setEnd_time($end_time) {
        $this->end_time = $end_time;
    }

    public function setTotal_kills($total_kills) {
        $this->total_kills = $total_kills;
    }

    public function setPlayers($players) {
        $this->players[] = $players;
    }

    public function setKills($kills) {
        $this->kills = $kills;
    }

    function setMeans($means) {
        $this->means = $means;
    }

    public function addKill() {
        $this->setTotal_kills($this->getTotal_kills() + 1);
    }

    public function toJSON() {
        return json_encode(get_object_vars($this));
    }

}
