<?php

class Departments extends Database {
    public $departmentTable = "Departments";
    private $context = false;

    public function __construct(){
        $this->context = $this->dbConnect();
    }

    public function getAllDepartments() {
        $sqlQuery = "SELECT * FROM ".$this->departmentTable;

        $result = mysqli_query($this->context, $sqlQuery);
        $departmentData = array();

        while($department = mysqli_fetch_assoc($result)) {
            $deparmentRows = array();

            $deparmentRows[] = $department["Id"];
            $deparmentRows[] = $department["Name"];

            $departmentData[] = $deparmentRows;
        }

        return $departmentData;
    }

    public function getListOfDepartments()
    {
        $pageInfo = $this->retrivePageInformations($this->departmentTable);
        
        $sqlQuery = "SELECT * FROM ".$this->departmentTable." LIMIT ".$pageInfo[2].", ".$this->recordsPerPage;

        $result = mysqli_query($this->context, $sqlQuery);
        $departmentData = array();

        while($department = mysqli_fetch_assoc($result)) {
            $deparmentRows = array();
            
            $sqlQuery = "SELECT COUNT(*) AS NumberOfUsers FROM ".$this->userTable." WHERE DepartmentId = ".$department["Id"];
            $resultFromCount = mysqli_query($this->context, $sqlQuery);
            $row = mysqli_fetch_assoc($resultFromCount);

            $deparmentRows[] = $department["Id"];
            $deparmentRows[] = $department["Name"];
            $deparmentRows[] = $row["NumberOfUsers"];

            $departmentData[] = $deparmentRows;
        }

        return $departmentData;
    }
}

?>