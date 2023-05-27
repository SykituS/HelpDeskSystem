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
$errorMessage = $tickets->CreateResponseForTicket();

include($_SERVER['DOCUMENT_ROOT'] . '/Includes/Header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/Includes/Container.php');
include($_SERVER['DOCUMENT_ROOT'] . '/Pages/Shared/Menu.php');

if (isset($_SESSION["SuccessMessage"])) {
  // Display the toast message
  echo '
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
      <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">    
          <div class="toast-header">
              <strong class="me-auto">Success</strong>
              <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
          <div class="toast-body">
              ' . $_SESSION["SuccessMessage"] . '
          </div>
      </div>
  </div>';

  // Clear the success message session variable
  unset($_SESSION["SuccessMessage"]);

  // Show the toast using JavaScript
  echo '
  <script>
      var toastEl = document.querySelector(".toast");
      var toast = new bootstrap.Toast(toastEl);
      toast.show();
  </script>';
}

$statusStyle = "";
$statusText = "";
switch ($ticketDetails["Status"]) {
  case "Created":
    $statusStyle = "badge text-bg-secondary";
    $statusText = "Created";
    break;
  case "InProgress":
    $statusStyle = "badge text-bg-primary";
    $statusText = "In Progress";
    break;
  case "Resolved":
    $statusStyle = "badge text-bg-success";
    $statusText = "Resolved";
    break;
  case "Cancelled":
    $statusStyle = "badge text-bg-warning";
    $statusText = "Cancelled";
    break;
}

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
              <p><strong>Status: </strong><span class="<?php echo $statusStyle ?>"><?php echo $statusText ?></span></p>
              <p><strong>Created Date:</strong> <?php echo $ticketDetails["CreatedOn"] ?></p>
            </div>
          </div>
          <div class="row">
            <h3>Additional information</h3>
            <?php if ($ticketDetails["AssignedTechnicalId"] != '') : ?>
              <div class="col-md-6">
                <p><strong>Technicial helper:</strong> <?php echo $ticketDetails["TechnicialFullName"] ?></p>
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
      <?php include("TicketMenuSection.php"); ?>
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
          <?php if ($ticketDetails["Status"] == "Canceled" || $ticketDetails["Status"] == "Resolved") : ?>
            <h5 class="text-center">You can't response to this ticket because it is closed!</h5>
          <?php else : ?>
            <?php if (($ticketDetails["HelpDeskFullName"] != '' &&
                ($ticketDetails["AssignetToUserId"] == $_SESSION["UserId"] ||
                  $ticketDetails["AssignedTechnicalId"] == $_SESSION["UserId"])) ||
              $ticketDetails["UserId"] == $_SESSION["UserId"] ||
              $users->HaveAdminPermissions()
            ) : ?>
              <form id="CreateResponseForTicketForm" class="form-horizontal" role="form" method="POST" action="">
                <input type="hidden" name="UId" value="<?php echo $uid ?>" />
                <div class="mb-3">
                  <label for="Message">Message</label>
                  <textarea class="form-control" id="Message" name="Message" rows="3" placeholder="Enter your message here" required></textarea>
                </div>
                <?php if ($errorMessage != '') { ?>
                  <div class="mt-2">
                    <div class="alert alert-danger col-sm-12"><?php echo $errorMessage; ?></div>
                  </div>
                <?php } ?>
                <input type="submit" name="CreateResponseForTicket" class="btn btn-primary" value="Submit" />
              </form>
            <?php else : ?>
              <h5 class="text-center">You can only responde to this ticket if: </h5>
              <ul class="list-group">
                <li class="list-group-item">- You have created this ticket</li>
                <li class="list-group-item">- You are assigned to this ticket</li>
                <li class="list-group-item">- You are technicial</li>
                <li class="list-group-item">- You are admin</li>
              </ul>
            <?php endif ?>
          <?php endif ?>
          <div id="bottom"></div>
        </div>
      </div>
      <?php include("TicketMenuSection.php"); ?>
    </div>
  </div>
</div>

<script>
  function assignTicket(ticketId) {
    console.log("Function start");
    $.ajax({
      url: 'TicketAction.php',
      type: 'GET',
      data: {
        TicketId: ticketId
      },
      dataType: 'json',
      cache: false,
      success: function(response) {
        if (response.success) {
          location.reload();
        } else {
          console.log(response.message);
        }
      },
      error: function() {
        console.log('AJAX request failed');
      }
    });

    return false; // Prevent default form submission behavior
  }
</script>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/Includes/Footer.php'); ?>