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
                        $_SESSION["Role"] = Role::Admin; //Logged as admin
                        break;
                    case "HelpDesk":
                        $_SESSION["Role"] = Role::HelpDesk; //Logged as helpdesk
                        break;
                    case "User":
                        $_SESSION["Role"] = Role::User; //Logged as user
                        break;
                }
                header("location: ../Tickets/ticket.php"); 		

            } else {
                $number = rand(0, 999);
                switch ($number) {
                    case $number>50:
                        $errorMessage = "Invalid login";
                        break;
                    case $number < 50 && $number > 40:
                        $errorMessage = "Ye be swashbucklin' the wrong login, matey!";
                        break;
                    case $number < 40 && $number > 30:
                        $errorMessage = "The spell for entry has been denied. Try again, young wizard.";
                        break;
                    case $number < 30 && $number > 20:
                        $errorMessage = "Invalid login sequence detected. Please try again with proper credentials.";
                        break;
                    case $number < 20 && $number > 10:
                        $errorMessage = "Sorry, partner. Them login details ain't quite right.";
                        break;
                    case $number < 10:
                        $errorMessage = "Thou hast failed to pass the gate, knave! Try again with proper credentials.";
                        break;
                    default:
                        $errorMessage = "Invalid logins";
                        break;
                    } 
            }

        } else if(!empty($_POST["Login"])) {
            $errorMessage = "Enter valid email address and password";
        }

        return $errorMessage;
    }

    public function getUserInfo() {
		if(!empty($_SESSION["userid"])) {
			$sqlQuery = "SELECT * FROM ".$this->userTable." 
				WHERE id ='".$_SESSION["UserId"]."'";
			$result = mysqli_query($this->context, $sqlQuery);		
			$userDetails = mysqli_fetch_assoc($result);
			return $userDetails;
		}		
	} 
}
?>