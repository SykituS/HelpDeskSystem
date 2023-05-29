<?php

class Tickets extends Database
{
    private $context = false;

    public function __construct()
    {
        $this->context = $this->dbConnect();
    }

    public function CreateNewTicket()
    {
        $errorMessage = '';

        if (empty($_POST["CreateNewTicket"])) {
            return $errorMessage;
        }

        if ($_POST["Title"] == '' || $_POST["Message"] == '' || $_POST["Department"] <= 0) {
            return $errorMessage = 'Please provide valid data!';
        }

        $title = strip_tags($_POST["Title"]);
        $message = strip_tags($_POST["Message"]);
        $department = $_POST["Department"];

        $userId = $_SESSION["UserId"];
        $createDate = date('Y-m-d H:i:s');
        $uniqueId = uniqid();
        $status = "Created";
        //$timestamp = strtotime('+1 weeks');
        //$expectedCompletionDate = date('Y-m-d', $timestamp);

        $sqlInsert = "INSERT INTO " . $this->ticketsTable . " (`UniqueId`, `UserId`, `Title`, `DepartmentId`, `InitialMsg`, `CreatedOn`, `IsReadByUser`, `IsReadByHelpDesk`, `Status`) VALUES (?, ?, ?, ?, ?, ?, '0', '0', ?)";

        $stmt = mysqli_prepare($this->context, $sqlInsert);
        mysqli_stmt_bind_param($stmt, "sssssss", $uniqueId, $userId, $title, $department, $message, $createDate, $status);
        mysqli_stmt_execute($stmt);
        header("location: ../Tickets/Ticket.php?Id=" . $uniqueId);

        return $errorMessage;
    }

    public function GetListOfTicketsForGivenUser($isClosed)
    {
        $selectWithStatus = '';
        if ($isClosed) {
            $selectWithStatus = "Tick.Status != 'Created' AND Tick.Status != 'InProgress'";
        } else {
            $selectWithStatus = "Tick.Status != 'Cancelled' AND Tick.Status != 'Resolved'";
        }

        $userId = $_SESSION["UserId"];

        $sqlQuery = "SELECT
                        Tick.Id,
                        Tick.UniqueId,
                        Tick.UserId,
                        CONCAT(u.FirstName, ' ', u.LastName) AS UserFullName,
                        Tick.Title,
                        dep.Name AS Department,
                        Tick.InitialMsg,
                        Tick.CreatedOn,
                        Tick.AssignetToUserId,
                        CONCAT(helpdesk.FirstName, ' ', helpdesk.LastName) AS HelpDeskFullName,
                        Tick.IsReadByUser,
                        Tick.IsReadByHelpDesk,
                        Tick.Status,
                        Tick.ExpectedCompletionDate,
                        Tick.AssignedTechnicalId
                    FROM
                    " . $this->ticketsTable . " AS Tick
                    INNER JOIN " . $this->departmentTable . " AS dep
                    ON
                        (Tick.DepartmentId = dep.Id)
                    INNER JOIN " . $this->userTable . " AS u
                    ON
                        (Tick.UserId = u.Id)
                    LEFT JOIN " . $this->userTable . " AS helpdesk
                    ON
                        (Tick.AssignetToUserId = helpdesk.Id)
                    WHERE
                    Tick.UserId = ? AND " . $selectWithStatus;


        // Prevent SqlInjection using params
        $stmt = mysqli_prepare($this->context, $sqlQuery);
        mysqli_stmt_bind_param($stmt, "s", $userId);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $ticketsData = array();

        while ($ticket = mysqli_fetch_assoc($result)) {
            $ticketRow = array();

            $ticketRow[] = $ticket["UniqueId"];
            $ticketRow[] = $ticket["Title"];
            $ticketRow[] = $ticket["Department"];
            $ticketRow[] = $ticket["HelpDeskFullName"];
            $ticketRow[] = $ticket["Status"];
            $ticketRow[] = $ticket["CreatedOn"];
            $ticketRow[] = $ticket["ExpectedCompletionDate"];
            $ticketRow[] = $ticket["IsReadByUser"];
            $ticketRow[] = $ticket["IsReadByHelpDesk"];

            $ticketsData[] = $ticketRow;
        }

        return $ticketsData;
    }

    public function GetOnlyUnassignedTickets($isClosed)
    {
        $selectWithStatus = '';
        if ($isClosed) {
            $selectWithStatus = "Tick.Status != 'Created' AND Tick.Status != 'InProgress'";
        } else {
            $selectWithStatus = "Tick.Status != 'Cancelled' AND Tick.Status != 'Resolved'";
        }

        $userId = $_SESSION["UserId"];

        $sqlQuery = "SELECT
                        Tick.Id,
                        Tick.UniqueId,
                        Tick.UserId,
                        CONCAT(u.FirstName, ' ', u.LastName) AS UserFullName,
                        Tick.Title,
                        dep.Name AS Department,
                        Tick.InitialMsg,
                        Tick.CreatedOn,
                        Tick.AssignetToUserId,
                        CONCAT(helpdesk.FirstName, ' ', helpdesk.LastName) AS HelpDeskFullName,
                        Tick.IsReadByUser,
                        Tick.IsReadByHelpDesk,
                        Tick.Status,
                        Tick.ExpectedCompletionDate,
                        Tick.AssignedTechnicalId
                    FROM
                    " . $this->ticketsTable . " AS Tick
                    INNER JOIN " . $this->departmentTable . " AS dep
                    ON
                        (Tick.DepartmentId = dep.Id)
                    INNER JOIN " . $this->userTable . " AS u
                    ON
                        (Tick.UserId = u.Id)
                    LEFT JOIN " . $this->userTable . " AS helpdesk
                    ON
                        (Tick.AssignetToUserId = helpdesk.Id)
                    WHERE
                    Tick.AssignetToUserId IS NULL AND " . $selectWithStatus;


        // Prevent SqlInjection using params
        $stmt = mysqli_prepare($this->context, $sqlQuery);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $ticketsData = array();

        while ($ticket = mysqli_fetch_assoc($result)) {
            $ticketRow = array();

            $ticketRow[] = $ticket["UniqueId"];
            $ticketRow[] = $ticket["Title"];
            $ticketRow[] = $ticket["Department"];
            $ticketRow[] = $ticket["HelpDeskFullName"];
            $ticketRow[] = $ticket["Status"];
            $ticketRow[] = $ticket["CreatedOn"];
            $ticketRow[] = $ticket["ExpectedCompletionDate"];
            $ticketRow[] = $ticket["IsReadByUser"];
            $ticketRow[] = $ticket["IsReadByHelpDesk"];

            $ticketsData[] = $ticketRow;
        }

        return $ticketsData;
    }

    public function GetOnlyTicketsAssignedToUserId($isClosed)
    {
        $selectWithStatus = '';
        if ($isClosed) {
            $selectWithStatus = "Tick.Status != 'Created' AND Tick.Status != 'InProgress'";
        } else {
            $selectWithStatus = "Tick.Status != 'Cancelled' AND Tick.Status != 'Resolved'";
        }

        $userId = $_SESSION["UserId"];

        $sqlQuery = "SELECT
                        Tick.Id,
                        Tick.UniqueId,
                        Tick.UserId,
                        CONCAT(u.FirstName, ' ', u.LastName) AS UserFullName,
                        Tick.Title,
                        dep.Name AS Department,
                        Tick.InitialMsg,
                        Tick.CreatedOn,
                        Tick.AssignetToUserId,
                        CONCAT(helpdesk.FirstName, ' ', helpdesk.LastName) AS HelpDeskFullName,
                        Tick.IsReadByUser,
                        Tick.IsReadByHelpDesk,
                        Tick.Status,
                        Tick.ExpectedCompletionDate,
                        Tick.AssignedTechnicalId
                    FROM
                    " . $this->ticketsTable . " AS Tick
                    INNER JOIN " . $this->departmentTable . " AS dep
                    ON
                        (Tick.DepartmentId = dep.Id)
                    INNER JOIN " . $this->userTable . " AS u
                    ON
                        (Tick.UserId = u.Id)
                    LEFT JOIN " . $this->userTable . " AS helpdesk
                    ON
                        (Tick.AssignetToUserId = helpdesk.Id)
                    WHERE
                    (Tick.AssignetToUserId = ? OR Tick.AssignedTechnicalId = ?) AND " . $selectWithStatus;


        // Prevent SqlInjection using params
        $stmt = mysqli_prepare($this->context, $sqlQuery);
        mysqli_stmt_bind_param($stmt, "ss", $userId, $userId);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $ticketsData = array();

        while ($ticket = mysqli_fetch_assoc($result)) {
            $ticketRow = array();

            $ticketRow[] = $ticket["UniqueId"];
            $ticketRow[] = $ticket["Title"];
            $ticketRow[] = $ticket["Department"];
            $ticketRow[] = $ticket["HelpDeskFullName"];
            $ticketRow[] = $ticket["Status"];
            $ticketRow[] = $ticket["CreatedOn"];
            $ticketRow[] = $ticket["ExpectedCompletionDate"];
            $ticketRow[] = $ticket["IsReadByUser"];
            $ticketRow[] = $ticket["IsReadByHelpDesk"];

            $ticketsData[] = $ticketRow;
        }

        return $ticketsData;
    }

    public function GetAllTickets($isClosed)
    {
        $selectWithStatus = '';
        if ($isClosed) {
            $selectWithStatus = "Tick.Status != 'Created' AND Tick.Status != 'InProgress'";
        } else {
            $selectWithStatus = "Tick.Status != 'Cancelled' AND Tick.Status != 'Resolved'";
        }

        $sqlQuery = "SELECT
                        Tick.Id,
                        Tick.UniqueId,
                        Tick.UserId,
                        CONCAT(u.FirstName, ' ', u.LastName) AS UserFullName,
                        Tick.Title,
                        dep.Name AS Department,
                        Tick.InitialMsg,
                        Tick.CreatedOn,
                        Tick.AssignetToUserId,
                        CONCAT(helpdesk.FirstName, ' ', helpdesk.LastName) AS HelpDeskFullName,
                        Tick.IsReadByUser,
                        Tick.IsReadByHelpDesk,
                        Tick.Status,
                        Tick.ExpectedCompletionDate,
                        Tick.AssignedTechnicalId
                    FROM
                    " . $this->ticketsTable . " AS Tick
                    INNER JOIN " . $this->departmentTable . " AS dep
                    ON
                        (Tick.DepartmentId = dep.Id)
                    INNER JOIN " . $this->userTable . " AS u
                    ON
                        (Tick.UserId = u.Id)
                    LEFT JOIN " . $this->userTable . " AS helpdesk
                    ON
                        (Tick.AssignetToUserId = helpdesk.Id)
                    WHERE " . $selectWithStatus;


        // Prevent SqlInjection using params
        $stmt = mysqli_prepare($this->context, $sqlQuery);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $ticketsData = array();

        while ($ticket = mysqli_fetch_assoc($result)) {
            $ticketRow = array();

            $ticketRow[] = $ticket["UniqueId"];
            $ticketRow[] = $ticket["Title"];
            $ticketRow[] = $ticket["Department"];
            $ticketRow[] = $ticket["HelpDeskFullName"];
            $ticketRow[] = $ticket["Status"];
            $ticketRow[] = $ticket["CreatedOn"];
            $ticketRow[] = $ticket["ExpectedCompletionDate"];
            $ticketRow[] = $ticket["IsReadByUser"];
            $ticketRow[] = $ticket["IsReadByHelpDesk"];

            $ticketsData[] = $ticketRow;
        }

        return $ticketsData;
    }

    public function GetTicketDetailsByUniqueId($uid)
    {
        $sqlQuery = "SELECT
                        Tick.Id,
                        Tick.UniqueId,
                        Tick.UserId,
                        CONCAT(u.FirstName, ' ', u.LastName) AS UserFullName,
                        Tick.Title,
                        Tick.DepartmentId,
                        dep.Name AS Department,
                        Tick.InitialMsg,
                        Tick.CreatedOn,
                        Tick.AssignetToUserId,
                        CONCAT(helpdesk.FirstName, ' ', helpdesk.LastName) AS HelpDeskFullName,
                        Tick.IsReadByUser,
                        Tick.IsReadByHelpDesk,
                        Tick.Status,
                        Tick.ExpectedCompletionDate,
                        Tick.AssignedTechnicalId,
                        CONCAT(tech.FirstName, ' ', tech.LastName) AS TechnicialFullName
                    FROM
                    " . $this->ticketsTable . " AS Tick
                    INNER JOIN " . $this->departmentTable . " AS dep
                    ON
                        (Tick.DepartmentId = dep.Id)
                    INNER JOIN " . $this->userTable . " AS u
                    ON
                        (Tick.UserId = u.Id)
                    LEFT JOIN " . $this->userTable . " AS helpdesk
                    ON
                        (Tick.AssignetToUserId = helpdesk.Id)
                    LEFT JOIN " . $this->userTable . " AS tech
                    ON
                        (Tick.AssignedTechnicalId = tech.Id)
                    WHERE
                        Tick.UniqueId = ?";

        // Prevent SqlInjection using params
        $stmt = mysqli_prepare($this->context, $sqlQuery);
        mysqli_stmt_bind_param($stmt, "s", $uid);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $ticket = mysqli_fetch_assoc($result);

        // Updating ticket data to show new message for other side
        $sqlUpdate = "";
        if ($_SESSION["Role"] == "HelpDesk" || $_SESSION["Role"] == "Admin") {
            $sqlUpdate = "UPDATE " . $this->ticketsTable . " SET `IsReadByHelpDesk`=1 WHERE `UniqueId` = ?";
        } else {
            $sqlUpdate = "UPDATE " . $this->ticketsTable . " SET `IsReadByUser`=1 WHERE `UniqueId` = ?";
        }

        $stmtUpdate = mysqli_prepare($this->context, $sqlUpdate);
        mysqli_stmt_bind_param($stmtUpdate, "s", $uid);
        mysqli_stmt_execute($stmtUpdate);

        return $ticket;
    }

    public function GetTicketMessagesByUniqueId($uid)
    {
        $sqlQuery = "SELECT
                        resp.Id,
                        resp.UniqueTicketId,
                        resp.ResponseMsg,
                        resp.ResponseBy,
                        CONCAT(u.FirstName, ' ', u.LastName) AS ResponseUser,
                        resp.CreatedOn
                    FROM
                    " . $this->ticketsResponseTable . " AS resp
                    INNER JOIN " . $this->userTable . " AS u
                    ON
                        u.Id = resp.ResponseBy
                    WHERE
                        resp.UniqueTicketId = ?";

        // Prevent SqlInjection using params
        $stmt = mysqli_prepare($this->context, $sqlQuery);
        mysqli_stmt_bind_param($stmt, "s", $uid);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $response = array();

        while ($message = mysqli_fetch_assoc($result)) {
            $row = array();

            $row["ResponseUser"] = $message["ResponseUser"];
            $row["CreatedOn"] = $message["CreatedOn"];
            $row["ResponseMsg"] = $message["ResponseMsg"];
            $response[] = $row;
        }

        return $response;
    }

    public function CreateResponseForTicket()
    {
        $errorMessage = '';

        if (empty($_POST["CreateResponseForTicket"])) {
            return $errorMessage;
        }

        if ($_POST["Message"] == '') {
            $errorMessage = "Message wasn't sent";
            return $errorMessage;
        }

        $uid = $_POST["UId"];
        $message = $_POST["Message"];
        $createdBy = $_SESSION["UserId"];
        $createDate = date('Y-m-d H:i:s');

        $sqlInsert = "INSERT INTO " . $this->ticketsResponseTable . "(`UniqueTicketId`, `ResponseMsg`, `ResponseBy`, `CreatedOn`) VALUES (?, ?, ?, ?)";

        // Prevent SqlInjection using params
        $stmt = mysqli_prepare($this->context, $sqlInsert);
        mysqli_stmt_bind_param($stmt, "ssss", $uid, $message, $createdBy, $createDate);
        mysqli_stmt_execute($stmt);

        // Updating ticket data to show new message for other side
        $sqlUpdate = "UPDATE " . $this->ticketsTable . " SET `IsReadByUser`=?, `IsReadByHelpDesk`=? WHERE `UniqueId` = ?;";
        $stmt = mysqli_prepare($this->context, $sqlUpdate);
        
        $isReadByUser = 0;
        $isReadByHelpDesk = 1;

        if ($_SESSION["Role"] != "HelpDesk" && $_SESSION["Role"] != "Admin") {
            $isReadByUser = 1;
            $isReadByHelpDesk = 0;
        }

        mysqli_stmt_bind_param($stmt, "sss", $isReadByUser, $isReadByHelpDesk, $uid);
        mysqli_stmt_execute($stmt);

        // Set success message and refresh page to prevent sending form again
        $_SESSION['SuccessMessage'] = "Response created successfully";
        header("location: ../Tickets/Ticket.php?Id=" . $uid);

        // move user to bottom of the page
        echo '<script>window.location.hash = "#bottom";</script>';

        return $errorMessage;
    }

    public function AssigneTicketToUser($ticketId)
    {
        $userId = $_SESSION["UserId"];
        $status = "InProgress";
        $sqlUpdate = "UPDATE " . $this->ticketsTable . " SET `AssignetToUserId`=?, `Status`=? WHERE `UniqueId`=?";

        $stmt = mysqli_prepare($this->context, $sqlUpdate);
        mysqli_stmt_bind_param($stmt, "sss", $userId, $status, $ticketId);
        mysqli_stmt_execute($stmt);
    }

    public function UpdateTicketStatus()
    {
        $errorMessage = '';

        if (empty($_POST["UpdateTicketStatus"])) {
            return $errorMessage;
        }

        $uid = $_POST["UId"];
        $status = $_POST["Status"];

        $sqlUpdate = "UPDATE " . $this->ticketsTable . " SET `Status`=? WHERE `UniqueId`=?";

        $stmt = mysqli_prepare($this->context, $sqlUpdate);
        mysqli_stmt_bind_param($stmt, "ss", $status, $uid);
        mysqli_stmt_execute($stmt);

        header("location: ../Tickets/Ticket.php?Id=" . $uid);
        return $errorMessage;
    }

    public function EditTicketData()
    {
        $errorMessage = '';

        if (empty($_POST["EditTicketData"])) {
            return $errorMessage;
        }

        $expectedFinishDate = $_POST["ExpectedFinishDate"];
        if ($_POST["ExpectedFinishDate"] == '') {
            $expectedFinishDate = null;
        }

        $technicial = $_POST["Technicial"];
        if ($_POST["Technicial"] == '') {
            $technicial = null;
        }

        $department = $_POST["Department"];
        $uid = $_POST["UId"];

        $sqlUpdate = "UPDATE " . $this->ticketsTable . " SET `DepartmentId`=?, `ExpectedCompletionDate`=?, `AssignedTechnicalId`=? WHERE `UniqueId`=?";

        $stmt = mysqli_prepare($this->context, $sqlUpdate);
        mysqli_stmt_bind_param($stmt, "ssss", $department, $expectedFinishDate, $technicial, $uid);
        mysqli_stmt_execute($stmt);

        header("location: ../Tickets/Ticket.php?Id=" . $uid);
        return $errorMessage;
    }
}
