<?php

/**
 * @author Matheus Pisiconeri
 */
class KillClass {

    private $name;
    private $kills;

    public function getName() {
        return $this->name;
    }

    public function getKills() {
        return $this->kills;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setKills($kills) {
        $this->kills = $kills;
    }

}
