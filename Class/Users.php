<?php 

class Users extends Database {
    private $userTable = "Users";
    private $context = false;

    public function __construct(){
        $this->context = $this->dbConnect();
    }

    public function IsLoggedIn(){
        if(isset($_SESSION["UserId"])) {
            return true;
        } else {
            return false;
        }
    }

    public function Login(){
        $errorMessage = '';
        
        if(!empty($_POST["Login"]) && $_POST["Email"] != '' && $_POST["Password"] != '') {
            $email = $_POST["Email"];
            $password = $_POST["Password"];
            $sqlQuery = "Select * From ".$this->userTable."
                            WHERE email='".$email."' AND password='".md5($password)."' AND status = 1";

            $results = mysqli_query($this->context, $sqlQuery);
            $isLoginValid = mysqli_num_rows($results);
            if($isLoginValid) {
                $userDetails = mysqli_fetch_assoc($results);
                $_SESSION["UserId"] = $userDetails["Id"];
                $_SESSION["UserFirstName"] = $userDetails["FirstName"];
                $_SESSION["UserLastName"] = $userDetails["LastName"];

                switch($userDetails["Role"]) {
                    case "Admin":
                        $_SESSION["Role"] = 1; //Logged as admin
                        break;
                    case "HelpDesk":
                        $_SESSION["Role"] = 2; //Logged as helpdesk
                        break;
                    case "User":
                        $_SESSION["Role"] = 3; //Logged as user
                        break;
                }
                header("location: ticket.php"); 		

            } else {
                $errorMessage = "Invalid login";
            }

        } else if(!empty($_POST["Login"])) {
            $errorMessage = "Enter valid email address and password";
        }

        return $errorMessage;
    }
}

?>