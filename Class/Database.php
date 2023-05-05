<?php 

class Database {
    
    //Tables name
    public $userTable = "Users";
    public $departmentTable = "Departments";
    
    //Pagination settings
    public $recordsPerPage = 15;

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

    public function retrivePageInformations($tableName) {

        $sqlQuery = "SELECT * FROM ".$tableName;

        $result = mysqli_query($this->dbConnect(), $sqlQuery);

        $totalRecords = mysqli_num_rows($result);
        $totalPage = ceil($totalRecords/$this->recordsPerPage);
        
        $currentPage = isset($_GET["Page"]) ? $_GET["Page"] : 1;
        $offset = ($currentPage - 1) * $this->recordsPerPage;

        $pageInformation = array();

        $pageInformation[] = $totalRecords; // 0 - TotalRecords
        $pageInformation[] = $totalPage; // 1 - Total Page
        $pageInformation[] = $offset; // 2 - Offset
        $pageInformation[] = $currentPage; // 3 - Current Page

        return $pageInformation;
    }

    function console_log($output, $with_script_tags = true) {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
    ');';
        if ($with_script_tags) {
            $js_code = '<script>' . $js_code . '</script>';
        }
        echo $js_code;
    }
}
?>