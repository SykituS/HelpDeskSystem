<?php

class Database
{

    //Tables name
    public $userTable = "`".Prefix . "Users`";
    public $departmentTable = "`".Prefix . "Departments`";
    public $ticketsTable = "`".Prefix . "Tickets`";
    public $ticketsResponseTable = "`".Prefix . "TicketResponse`";

    //Pagination settings
    public $recordsPerPage = 15;

    public function dbConnect()
    {
        static $context = null;
        if (is_null($context)) {
            $connection = new mysqli(Host, User, Password, Database);

            if ($connection->connect_error) {
                if(file_exists(BaseUrl.'/Install.php')) {
                    header('Location: '.BaseUrl.'/Install.php');
                } else {
                    http_response_code(503);
                    die("Service unavailable");
                }
                die("Connection to MySql failed: " . $connection->connect_error);
            } else {
                $context = $connection;
            }
        }
        return $context;
    }

    // Function for pagination on pages
    public function retrivePageInformations($tableName)
    {

        $sqlQuery = "SELECT * FROM " . $tableName;

        $result = mysqli_query($this->dbConnect(), $sqlQuery);

        $totalRecords = mysqli_num_rows($result);
        $totalPage = ceil($totalRecords / $this->recordsPerPage);

        $currentPage = isset($_GET["Page"]) ? $_GET["Page"] : 1;
        $offset = ($currentPage - 1) * $this->recordsPerPage;

        $pageInformation = array();

        $pageInformation[] = $totalRecords; // 0 - TotalRecords
        $pageInformation[] = $totalPage; // 1 - Total Page
        $pageInformation[] = $offset; // 2 - Offset
        $pageInformation[] = $currentPage; // 3 - Current Page

        return $pageInformation;
    }

    //Dev function that shows value in console
    function console_log($output, $with_script_tags = true)
    {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
        if ($with_script_tags) {
            $js_code = '<script>' . $js_code . '</script>';
        }
        echo $js_code;
    }
}
