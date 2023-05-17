<?php
include($_SERVER['DOCUMENT_ROOT'] . '/Configuration/Init.php');

if (!$users->isLoggedIn()) {
  header('Location: /Pages/Account/Login.php');
}

if (!isset($_GET["Id"])) {
  header('Location: /Pages/Shared/Error.php');
}

$uid = $_GET["Id"];
$ticketDetails = $tickets->GetTicketDetailsByUniqueId($uid);
$ticketResponse = $tickets->GetTicketMessagesByUniqueId($uid);

include($_SERVER['DOCUMENT_ROOT'] . '/Includes/Header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/Includes/Container.php');
include($_SERVER['DOCUMENT_ROOT'] . '/Pages/Shared/Menu.php');
?>
<div class="container mt-5">
  <div class="row">
    <div class="col">
      <h1><strong>Title:</strong> <?php echo $ticketDetails["Title"] ?></h1>
      <hr>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h3 class="card-title">Details</h3>
          <div class="row">
            <div class="col-md-6">
              <p><strong>Department:</strong> <?php echo $ticketDetails["Department"] ?></p>
              <p><strong>Assigned To:</strong> <?php echo $ticketDetails["HelpDeskFullName"] ?></p>

            </div>
            <div class="col-md-6">
              <p><strong>Status: </strong><span class="badge bg-secondary"><?php echo $ticketDetails["Status"] ?></span></p>
              <p><strong>Created Date:</strong> <?php echo $ticketDetails["CreatedOn"] ?></p>
            </div>
          </div>
          <div class="row">
            <h3>Additional information</h3>
            <?php if ($ticketDetails["AssignedTechnicalId"] != '') : ?>
              <div class="col-md-6">
                <p><strong>Technicial helper:</strong> <?php echo $ticketDetails["AssignedTechnicalId"] ?></p>
              </div>
            <?php endif ?>
            <?php if ($ticketDetails["ExpectedCompletionDate"] != '') : ?>
              <div class="col-md-6">
                <p><strong>Expected finish date:</strong> <?php echo $ticketDetails["ExpectedCompletionDate"] ?></p>
              </div>
            <?php endif ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col">
      <hr>
      <div class="text-center">
        <a onclick="goBack()" class="btn btn-outline-primary fw-bold">Go back</a>
        <a href="#ChangeStatus" class="btn btn-outline-primary fw-bold">Change ticket status</a>
        <a href="#UpdateTicket" class="btn btn-outline-primary fw-bold">Update ticket data</a>
      </div>
      <hr>
      <h3 class="text-center">Messages</h3>
      <div class="card">
        <div class="card-header">
          <strong>Initial Message</strong>
          <span class="float-end"> <?php echo $ticketDetails["UserFullName"] . " | " . date('Y, F j | H:i', strtotime($ticketDetails["CreatedOn"]));   ?></span>
        </div>
        <div class="card-body">
          <p><?php echo $ticketDetails["InitialMsg"] ?></p>
        </div>
      </div>

      <?php foreach ($ticketResponse as $value) : ?>
        <div class="card mt-3">
          <div class="card-header">
            <strong>Replay message</strong>
            <span class="float-end"><?php echo $value["ResponseUser"] . " | " . date('Y, F j | H:i', strtotime($value["CreatedOn"])); ?></span>
          </div>
          <div class="card-body">
            <p><?php echo $value["ResponseMsg"] ?></p>
          </div>
        </div>
      <?php endforeach ?>

      <div class="card mt-3">
        <div class="card-header">
          <strong>Create New Response</strong>
        </div>
        <div class="card-body">
          <form id="CreateResponseForTicketForm" class="form-horizontal" role="form" method="POST" action="">
            <div class="mb-3">
              <label for="message">Message</label>
              <textarea class="form-control" id="Message" rows="3" placeholder="Enter your message here"></textarea>
            </div>
            <button type="submit" name="CreateResponseForTicket" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/Includes/Footer.php'); ?>