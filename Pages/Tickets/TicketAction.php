<?php
require(__DIR__ . '/../../Configuration/Init.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['TicketId'])) {
        $ticketId = $_GET['TicketId'];
        $tickets->AssigneTicketToUser($ticketId);
        $response = array('success' => true); // Sample response

        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        $response = array('success' => false, 'message' => 'Invalid request');
        header('Content-Type: application/json');
        echo json_encode($response);
    }
} else {
    $response = array('success' => false, 'message' => 'Invalid request method');
    header('Content-Type: application/json');
    echo json_encode($response);
}
