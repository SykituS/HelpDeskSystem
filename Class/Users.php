<?php

class Users extends Database
{
    private $context = false;

    public function __construct()
    {
        $this->context = $this->dbConnect();
    }

    public function IsLoggedIn()
    {
        if (isset($_SESSION["UserId"])) {
            return true;
        } else {
            return false;
        }
    }

    public function HaveUserPermissions()
    {
        if (isset($_SESSION["Role"])) {
            return true;
        } else {
            return false;
        }
    }

    public function HaveHelpDeskPermissions()
    {
        if (isset($_SESSION["Role"])) {
            if ($_SESSION["Role"] == "HelpDesk" || $_SESSION["Role"] == "Admin") {
                return true;
            }
        }

        return false;
    }

    public function HaveAdminPermissions()
    {
        if (isset($_SESSION["Role"])) {
            if ($_SESSION["Role"] == "Admin") {
                return true;
            }
        }

        return false;
    }

    public function Login()
    {
        $errorMessage = '';

        if (!empty($_POST["Login"]) && $_POST["Email"] != '' && $_POST["Password"] != '') {
            $email = strip_tags($_POST["Email"]);
            $password = $_POST["Password"];
            $sqlQuery = "SELECT * FROM " . $this->userTable . "
                        WHERE email=? AND status = 1";

            if (!$this->context) {
                // Error connecting to the database
                die("Connection failed: " . mysqli_connect_error());
            }
            // Prevent SqlInjection using params
            $stmt = mysqli_prepare($this->context, $sqlQuery);

            if (!$stmt) {
                // Error preparing the statement
                die("Statement preparation failed: " . mysqli_error($this->context));
            }
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);

            mysqli_stmt_store_result($stmt);
            $rowCount = mysqli_stmt_num_rows($stmt);

            if ($rowCount == 1) {
                mysqli_stmt_bind_result($stmt, $id, $email, $storedPassword, $firstName, $lastName, $role, $status, $department, $created);
                mysqli_stmt_fetch($stmt);

                if (password_verify($password, $storedPassword)) {
                    if ($status != 1) {
                        $errorMessage = "Your account is disabled!";
                        return $errorMessage;
                    }

                    $_SESSION["UserId"] = $id;
                    $_SESSION["UserFirstName"] = $firstName;
                    $_SESSION["UserLastName"] = $lastName;
                    $_SESSION["Role"] = $role;
                    header("location: ../MainPage/Main.php");
                } else {
                    $errorMessage = "Invalid login";
                }
            } else {
                $number = rand(0, 999);
                switch ($number) {
                    case $number > 50:
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
        } else if (!empty($_POST["Login"])) {
            $errorMessage = "Enter valid email address and password";
        }

        return $errorMessage;
    }

    public function GetLoggedUserInfo()
    {
        $userId = $_SESSION["UserId"];

        $sqlQuery = "SELECT
                        COUNT(CASE WHEN Status IN ('Created', 'InProgress') THEN 1 END) AS OpenedTickets,
                        COUNT(CASE WHEN Status IN ('Resolved', 'Cancelled') THEN 1 END) AS ClosedTickets
                    FROM
                        " . $this->ticketsTable . "
                    WHERE
                        UserId = ?";

        // Prevent SqlInjection using params
        $stmt = mysqli_prepare($this->context, $sqlQuery);
        mysqli_stmt_bind_param($stmt, "s", $userId);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $userData = mysqli_fetch_assoc($result);

        return $userData;
    }

    public function GetUserInfoById($Id)
    {
        $sqlQuery = "SELECT u.*, dep.Name as DepartmentName FROM " . $this->userTable . " as u INNER JOIN " . $this->departmentTable . " as dep ON DepartmentId = dep.Id WHERE u.Id = ?";

        // Prevent SqlInjection using params
        $stmt = mysqli_prepare($this->context, $sqlQuery);
        mysqli_stmt_bind_param($stmt, "s", $Id);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $data = mysqli_fetch_assoc($result);
        return $data;
    }

    public function getListOfUsers()
    {
        $pageInfo = $this->retrivePageInformations($this->userTable);

        $sqlQuery = "SELECT u.Id, u.Email, u.FirstName, u.LastName, u.Role, u.Status, dep.Name as DepartmentName
                        FROM " . $this->userTable . " as u INNER JOIN " . $this->departmentTable . " as dep 
                        ON u.DepartmentId = dep.Id ORDER BY u.CreatedOn DESC LIMIT " . $pageInfo[2] . ", " . $this->recordsPerPage;

        $result = mysqli_query($this->context, $sqlQuery);
        $userData = array();

        while ($user = mysqli_fetch_assoc($result)) {
            $userRows = array();

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
            $userRows[] = $user["FirstName"] . " " . $user["LastName"];
            $userRows[] = $user["Email"];
            $userRows[] = $user["DepartmentName"];
            $userRows[] = $userRole;
            $userRows[] = $user["Status"];

            $userData[] = $userRows;
        }
        return $userData;
    }

    public function CreateNewUser()
    {
        $errorMessage = '';

        if (empty($_POST["CreateNewUser"])) {
            return $errorMessage;
        }

        if ($_POST["Email"] == '' || $_POST["FirstName"] == '' || $_POST["LastName"] == '' || $_POST["Role"] == '' || $_POST["Department"] <= 0) {
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

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $createDate = date('Y-m-d H:i:s');
        $sqlInsertQuery = "INSERT INTO " . $this->userTable . "(Email, Password, FirstName, LastName, Role, Status, DepartmentId, CreatedOn) VALUES (
            ?, ?, ?, ?, ?, 1, ?, ?)";

        // Prevent SqlInjection using params
        $stmt = mysqli_prepare($this->context, $sqlInsertQuery);
        mysqli_stmt_bind_param($stmt, "sssssss", $email, $passwordHash, $firstName, $lastName, $role, $department, $createDate);
        mysqli_stmt_execute($stmt);

        header("location: ../Users/UsersList.php");

        return $errorMessage;
    }

    public function GetListOfHelpDeskAdminUsers()
    {
        $sqlQuery = "SELECT u.Id, CONCAT(dep.Name, ' | ', u.FirstName, ' ', u.LastName, ' | ', u.Role) AS FullNameWithDepartment
                        FROM " . $this->userTable . " as u INNER JOIN " . $this->departmentTable . " as dep 
                        ON u.DepartmentId = dep.Id WHERE `Role` = 'HelpDesk' OR `Role` = 'Admin' Order by dep.Name Desc, u.Role ASC";

        $result = mysqli_query($this->context, $sqlQuery);
        $userData = array();

        while ($user = mysqli_fetch_assoc($result)) {
            $userRows = array();
            $userRows[] = $user["Id"];
            $userRows[] = $user["FullNameWithDepartment"];

            $userData[] = $userRows;
        }

        return $userData;
    }

    public function IsActive($userId)
    {
        $sqlQuery = "SELECT Status FROM " . $this->userTable . " WHERE `Id` = ?";

        // Prevent SqlInjection using params
        $stmt = mysqli_prepare($this->context, $sqlQuery);
        mysqli_stmt_bind_param($stmt, "s", $userId);
        mysqli_stmt_execute($stmt);

        $results = mysqli_stmt_get_result($stmt);
        $userDetails = mysqli_fetch_assoc($results);
        return $userDetails["Status"];
    }

    public function ChangeActiveStatusForUser($userId)
    {
        $sqlUpdate = "UPDATE " . $this->userTable . " SET `Status`= not `Status` WHERE `Id` = ?";

        // Prevent SqlInjection using params
        $stmt = mysqli_prepare($this->context, $sqlUpdate);
        mysqli_stmt_bind_param($stmt, "s", $userId);
        mysqli_stmt_execute($stmt);

        // Get the updated status of the user
        if ($this->IsActive($userId) == 0) {
            $status = "False";
        } else {
            $status = "True";
        }
        // Prepare the response
        $response = [
            'status' => 'success',
            'isActive' => $status
        ];

        // Return the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function EditUser()
    {
        $errorMessage = '';

        if (empty($_POST["EditUser"])) {
            return $errorMessage;
        }

        if ($_POST["Email"] == '' || $_POST["FirstName"] == '' || $_POST["LastName"] == '' || $_POST["Role"] == '' || $_POST["Department"] <= 0) {
            return $errorMessage = 'Please provide valid data!';
        }

        $email = strip_tags($_POST["Email"]);
        $firstName = strip_tags($_POST["FirstName"]);
        $lastName = strip_tags($_POST["LastName"]);

        $role = $_POST["Role"];
        $department = $_POST["Department"];

        $sqlUpdate = "";
        if ($_POST["Password"] == '') {
            $sqlUpdate = "UPDATE " . $this->userTable . " SET `Email`=?, `FirstName`=?, `LastName`=?, `Role`=?, `DepartmentId`=? WHERE `Id`=?";
            $stmt = mysqli_prepare($this->context, $sqlUpdate);
            mysqli_stmt_bind_param($stmt, "ssssss", $email, $firstName, $lastName, $role, $department, $_POST["Id"]);
        } else {
            $password = $_POST["Password"];
            $confirmPassword = $_POST["ConfirmPassword"];
            if ($password != $confirmPassword) {
                return $errorMessage = 'Provided passwords is not the same';
            }

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $sqlUpdate = "UPDATE " . $this->userTable . " SET `Email`=?, `Password`=?, `FirstName`=?, `LastName`=?, `Role`=?, `DepartmentId`=? WHERE `Id`=?";
            $stmt = mysqli_prepare($this->context, $sqlUpdate);
            mysqli_stmt_bind_param($stmt, "ssssss", $email, $passwordHash, $firstName, $lastName, $role, $department, $_POST["Id"]);
        }
        mysqli_stmt_execute($stmt);

        $_SESSION['SuccessMessage'] = "User updated successfully";
        header("location: ../Users/UsersList.php");

        return $errorMessage;
    }
}
