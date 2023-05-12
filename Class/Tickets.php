<?php

class Tickets extends Database {
    private $context = false;

    public function __construct(){
        $this->context = $this->dbConnect();
    }
}

?>