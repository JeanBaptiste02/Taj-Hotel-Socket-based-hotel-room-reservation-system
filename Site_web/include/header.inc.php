<!DOCTYPE html>
<html lang="fr">

    <head>

        <meta charset="UTF-8">
        <meta name="author" content="Damodarane Jean-Baptiste" />
        <meta name="date" content="2022-09-23" />
        <meta name="keywords" content="Projet de Developpement web" />

        <title><?php echo $titre;?></title>

        <!-- style lien cdn -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
        <!-- style avec css -->
        <link rel="stylesheet" href="<?php echo $link ?>"/>

    </head>

    <body>

        <header class="header">

            <a href="index.php" class = "logo">
                <img src="./images/logopic.png" alt="">
            </a>

            <nav class="navigbar">
                <a href="index.php" class="active">Accueil</a>
                <a href="connectClient.php" class="active">Se Connecter</a>
            </nav>

        </header>
