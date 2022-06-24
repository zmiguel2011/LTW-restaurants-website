<?php
    declare(strict_types = 1);

    require_once(__DIR__. '/../utils/session.php');
    $session = new Session();

    if (!$session->isLoggedIn()) { 
        $session->addMessage('warning', 'You need to be logged in to perform this action!');
        die(header("Location: /"));         // redirect to the index page
    }


    require_once(__DIR__. '/../database/connection.db.php');
    require_once(__DIR__. '/../database/restaurant.class.php');
    require_once(__DIR__. '/../database/reservation.class.php');
    require_once(__DIR__. '/../database/user.class.php');
    require_once(__DIR__. '/../database/owner.class.php');

    require_once(__DIR__. '/../templates/common.tpl.php');
    require_once(__DIR__. '/../templates/reservation.tpl.php');

    $db = getDatabaseConnection();
    if ($session->getUsertype() === 0) {
        $user = User::getUser($db, $session->getId());
        $reservations = Reservation::getReservations($db, $session->getId(), 10);
    }
    else if ($session->getUsertype() === 1)  {
        $owner = Owner::getOwner($db, $session->getId());
        $restaurants = Restaurant::getOwnerRestaurants($db, $session->getId());
    }


    drawHeader($session);

    if ($session->getUsertype() === 0)
        drawReservations($reservations);
    else if ($session->getUsertype() === 1) 
        drawReservationsOwner($restaurants);

    drawCancelReservationForm();
    drawFooter();

?>