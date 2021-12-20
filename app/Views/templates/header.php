<?php

use Functions\Session;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Angkothub | <?= $title = Session::getFlashdata() ?></title>
    <link rel="icon" href="<?= BASEURL ?>/img/waifu.png">

    <!-- style -->
    <link rel="stylesheet" href="<?= BASEURL ?>/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASEURL ?>/css/fontawesome-free-5.15.4-web/css/all.min.css">
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= BASEURL ?>/css/leaflet.awesome-markers.css">
    <link rel="stylesheet" href="<?= BASEURL ?>/css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin=""/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <!-- endstyle -->

</head>
<body>
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="<?= BASEURL ?>">Angkot<span class="text-hub">hub</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link <?= $this->sectionCheck($title, 'help'); ?>" href="<?= BASEURL ?>/help">Bantuan</a>
                    <a class="nav-link <?= $this->sectionCheck($title, 'about'); ?>" href="<?= BASEURL ?>/about">Tentang</a>
                </div>
            </div>
        </div>
    </nav>