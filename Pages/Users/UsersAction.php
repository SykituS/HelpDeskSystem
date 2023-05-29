<?php
require(__DIR__.'/../../Configuration/Init.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (isset($_GET['UserId'])) {
    $userId = $_GET['UserId'];
    $response = $users->ChangeActiveStatusForUser($userId);
    echo $response;
  } else {
    echo 'Invalid request';
  }
} else {
  echo 'Invalid request method';
}
?>