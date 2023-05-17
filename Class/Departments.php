<?php

class Departments extends Database
{
    private $context = false;

    public function __construct()
    {
        $this->context = $this->dbConnect();
    }

    public function getAllDepartments()
    {
        $sqlQuery = "SELECT * FROM " . $this->departmentTable;

        $result = mysqli_query($this->context, $sqlQuery);
        $departmentData = array();

        while ($department = mysqli_fetch_assoc($result)) {
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

        $sqlQuery = "SELECT * FROM " . $this->departmentTable . " LIMIT " . $pageInfo[2] . ", " . $this->recordsPerPage;

        $result = mysqli_query($this->context, $sqlQuery);
        $departmentData = array();

        while ($department = mysqli_fetch_assoc($result)) {
            $deparmentRows = array();

            $sqlQuery = "SELECT COUNT(*) AS NumberOfUsers FROM " . $this->userTable . " WHERE DepartmentId = " . $department["Id"];
            $resultFromCount = mysqli_query($this->context, $sqlQuery);
            $row = mysqli_fetch_assoc($resultFromCount);

            $deparmentRows[] = $department["Id"];
            $deparmentRows[] = $department["Name"];
            $deparmentRows[] = $row["NumberOfUsers"];

            $departmentData[] = $deparmentRows;
        }

        return $departmentData;
    }

    public function GetDepartmentInfoById($Id)
    {
        $sqlQuery = "SELECT * FROM " . $this->departmentTable . " WHERE `Id` = " . $Id;

        $result = mysqli_query($this->context, $sqlQuery);

        $data = mysqli_fetch_assoc($result);
        return $data;
    }

    public function CreateNewDepartment()
    {
        $errorMessage = '';

        if (empty($_POST["CreateNewDepartment"])) {
            return $errorMessage;
        }

        if ($_POST["Department"] == '') {
            return $errorMessage = 'Please provide valid data!';
        }

        $name = strip_tags($_POST["Department"]);

        $sqlInsertQuery = "INSERT INTO " . $this->departmentTable . "(Name) VALUES ('" . $name . "')";

        mysqli_query($this->context, $sqlInsertQuery);
        header("location: ../Departments/DepartmentsList.php");

        return $errorMessage;
    }

    public function EditDepartment()
    {
        $errorMessage = '';

        if (empty($_POST["EditDepartment"])) {
            return $errorMessage;
        }

        $department = strip_tags($_POST["Department"]);

        $sqlUpdate = "UPDATE `Departments` SET `Name`='" . $department . "' WHERE Id = " . $_POST["Id"];
        mysqli_query($this->context, $sqlUpdate);

        $_SESSION['SuccessMessage'] = "Department updated successfully";
        header("location: ../Departments/DepartmentsList.php");

        return $errorMessage;
    }
}
