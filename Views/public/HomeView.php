<?php

class HomeView
{
    public function afficherHome() {
       require_once "./views/includes/header.php"?><h1>Accueil</h1>

        <?php
        require_once "./views/includes/footer.php";
    }

}