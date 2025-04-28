// In changeStatus.php

<?php
require_once '../Controller/ReservationController.php';

if (isset($_GET['id']) && isset($_GET['statut'])) {
    $id = $_GET['id'];
    $statut = $_GET['statut'];

    // Create an instance of the ReservationController and change the status
    $reservationController = new ReservationController();
    $reservationController->changeStatus($id, $statut);

    // Redirect back to the reservations list page after changing the status
    header('Location: listReservations.php');
    exit();
} else {
    // If the ID or status is not provided, redirect to the reservations list
    header('Location: listReservations.php');
    exit();
}
?>
