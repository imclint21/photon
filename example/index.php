<?php
require_once(__DIR__ . "/../photon.php");
$photon = new Photon();
$photon->development_mode = true;
$photon->use_layout_view = true;
$photon->ignite();
?>