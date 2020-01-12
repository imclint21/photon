<?php
require_once(__DIR__ . "/../photon.php");
$photon = new Photon(true);
$photon->use_layout_view = true;
$photon->ignite();
?>