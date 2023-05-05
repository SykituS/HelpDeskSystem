<?php 

class Users extends Database {
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

    public function HaveUserPermissions(){
        if(isset($_SESSION["Role"])){
            return true;
        } else {
            return false;
        }
    }

    public function HaveHelpDeskPermissions(){
        if(isset($_SESSION["Role"])) {
            if ($_SESSION["Role"] == "HelpDesk") {
                return true;
            }
        }

        return false;
    }

    public function HaveAdminPermissions(){
        if(isset($_SESSION["Role"])) {
            if ($_SESSION["Role"] == "Admin") {
                return true;
            }
        }

        return false;
    }

    public function Login(){
        $errorMessage = '';
        
        if(!empty($_POST["Login"]) && $_POST["Email"] != '' && $_POST["Password"] != '') {
            $email = strip_tags($_POST["Email"]);
            $password = $_POST["Password"];
            $sqlQuery = "SELECT * FROM ".$this->userTable."
                            WHERE email='".$email."' AND password='".md5($password)."' AND status = 1";

            $results = mysqli_query($this->context, $sqlQuery);
            $isLoginValid = mysqli_num_rows($results);
            if($isLoginValid) {
                $userDetails = mysqli_fetch_assoc($results);
                $_SESSION["UserId"] = $userDetails["Id"];
                $_SESSION["UserFirstName"] = $userDetails["FirstName"];
                $_SESSION["UserLastName"] = $userDetails["LastName"];
                $_SESSION["Role"] = $userDetails["Role"];
                header("location: ../Tickets/TicketsList.php"); 		

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

    public function getListOfUsers() {
        $pageInfo = $this->retrivePageInformations($this->userTable);

        $sqlQuery = "SELECT u.Id, u.Email, u.FirstName, u.LastName, u.Role, u.Status, dep.Name as DepartmentName
                        FROM ".$this->userTable." as u INNER JOIN ".$this->departmentTable." as dep 
                        ON u.DepartmentId = dep.Id ORDER BY u.CreatedOn DESC LIMIT ".$pageInfo[2].", ".$this->recordsPerPage;

        $result = mysqli_query($this->context, $sqlQuery);
        $userData = array();

        while($user = mysqli_fetch_assoc($result)) {
            $userRows = array();
            $status = '';

            if($user["Status"] == 1) {
                $status = '<span class="badge text-bg-success">True</span>';
            } else {
                $status = '<span class="badge text-bg-danger">True</span>';
            }

            $userRole = '';
            switch ($user["Role"]) {
                case "Admin":
                    $userRole = 'Admin';
                    break;
                case "HelpDesk":
                    $userRole = 'Help Desk';
                    break;
                case "User":
                    $userRole = 'User';
                    break;
            }

            $userRows[] = $user["Id"];
            $userRows[] = $user["FirstName"]." ".$user["LastName"];
            $userRows[] = $user["Email"];
            $userRows[] = $user["DepartmentName"];
            $userRows[] = $userRole;
            $userRows[] = $status;

            $userData[] = $userRows;
        }
        return $userData;
    }

    public function CreateNewUser() {
        $errorMessage = '';

        if(empty($_POST["CreateNewUser"])) {
            return $errorMessage;
        }

        if($_POST["Email"] == '' || $_POST["FirstName"] == '' || $_POST["LastName"] == '' || $_POST["Role"] == '' || $_POST["Department"] <= 0)
        {
            return $errorMessage = 'Please provide valid data!';
        }

        $email = strip_tags($_POST["Email"]);
        $firstName = strip_tags($_POST["FirstName"]);
        $lastName = strip_tags($_POST["LastName"]);

        $role = $_POST["Role"];
        $department = $_POST["Department"];

        $password = $_POST["Password"];
        $confirmPassword = $_POST["ConfirmPassword"];
        if ($password != $confirmPassword) {
            return $errorMessage = 'Provided passwords is not the same';
        }

        $passwordHash = md5($password);
        $createDate = date('Y-m-d H:i:s');
        $sqlInsertQuery = "INSERT INTO ".$this->userTable."(Email, Password, FirstName, LastName, Role, Status, DepartmentId, CreatedOn) VALUES (
            '".$email."', '".$passwordHash."', '".$firstName."', '".$lastName."', '".$role."', 1, ".$department.", '".$createDate."')";

        mysqli_query($this->context, $sqlInsertQuery);
        header("location: ../Users/UsersList.php"); 		
        
        return $errorMessage;
    }
}
?>