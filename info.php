<?php
$drivers = PDO::getAvailableDrivers();
    foreach ($drivers as $nome) {
      echo 'Disponivel: ' . $nome . '<br />';
    }
?>
