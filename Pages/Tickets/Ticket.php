<?php
include($_SERVER['DOCUMENT_ROOT'] . '/Configuration/Init.php');

if (!$users->isLoggedIn()) {
  header('Location: /Pages/Account/Login.php');
}

if (!$users->HaveAdminPermissions()) {
  header('Location: /Pages/Account/Login.php');
}

include($_SERVER['DOCUMENT_ROOT'] . '/Includes/Header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/Includes/Container.php');
include($_SERVER['DOCUMENT_ROOT'] . '/Pages/Shared/Menu.php');
?>
<div class="container mt-5">
  <div class="row">
    <div class="col">
      <h1><strong>Title:</strong> Ticket Title</h1>
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
              <p><strong>Department:</strong> IT Department</p>
              <p><strong>Assigned To:</strong> John Doe</p>

            </div>
            <div class="col-md-6">
              <p><strong>Status: </strong><span class="badge bg-secondary">Open</span></p>
              <p><strong>Created Date:</strong> September 10, 2023</p>

            </div>
          </div>
          <div class="row">
            <h3>Additional information</h3>
            <div class="col-md-6">
              <p><strong>Technicial helper:</strong> John Somer</p>
            </div>
            <div class="col-md-6">
              <p><strong>Expected finish date:</strong> September 10, 2023</p>
            </div>
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
          <strong>Starting Message</strong>
          <span class="float-end">John Doe | September 10, 2023 | 12:30 PM</span>
        </div>
        <div class="card-body">
          <p>This is the starting message of the ticket.</p>
        </div>
      </div>

      <div class="card mt-3">
        <div class="card-header">
          <strong>Reply Message 1</strong>
          <span class="float-end">Jane Smith | September 11, 2023 | 9:45 AM</span>
        </div>
        <div class="card-body">
          <p>This is a reply to the ticket.</p>
        </div>
      </div>

      <!-- Add more message cards as needed -->

      <div class="card mt-3">
        <div class="card-header">
          <strong>Create New Response</strong>
        </div>
        <div class="card-body">
          <form>
            <div class="mb-3">
              <label for="message">Message</label>
              <textarea class="form-control" id="message" rows="3" placeholder="Enter your message here"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/Includes/Footer.php'); ?>