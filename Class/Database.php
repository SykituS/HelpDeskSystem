<?php 

class Database {
    public function dbConnect() {
        static $context = null;
        if (is_null($context))
        {
            $connection = new mysqli(Host, User, Password, Database);

            if ($connection -> connect_error) {
                die("Connection to MySql failed: ".$connection->connect_error);
            } else {
                $context = $connection;
            }
        }
        return $context;
    }
}
?>