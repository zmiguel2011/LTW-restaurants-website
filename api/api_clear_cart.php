<?php
  declare(strict_types = 1);

  require_once(__DIR__. '/../utils/session.php');
  $session = new Session();

  $session->clearCart();
  $session->clearCartRestaurantId();
?>