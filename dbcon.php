<?php
class Dbcon
{
    public $dbhost;
    public $dbuser;
    public $dbpass;
    public $dbname;
    public $server;
    public $db;
    public $conn;

    public function __construct()
    {
        $this->conn = new mysqli("localhost", "root", "", "grab_fake");
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
}
