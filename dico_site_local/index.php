<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="index.css">
    <title>Accueil - Outils de la langue française</title>
</head>
<body>
<div id="contener-total">
    
    <h1>Outils de la langue française</h1>
    <div class="contener">
        <div class="div_lien">
            <p><a class="a" href="suf.php">Tous les mots se finisant par <span>[...]</span></a></p>
        </div>
        <div class="div_lien">
            <p><a class="a" href="pre.php">Tous les mots commençant par <span>[...]</span></a></p>
        </div>
        <div class="div_lien">
            <p><a class="a" href="nieme.php">Le <span>n-ième</span> mot du dictionnaire</a></p>
        </div>
        <div class="div_lien">
            <p><a class="a" href="anag.php">Tous les anagrammes de <span>[...]</span></a></p>
        </div>
        <div class="div_lien">
            <p><a class="a" href="freq.php">fréquence de <span>[...]</span> dans la langue française</a></p>
        </div>
        <div class="div_lien">
            <p><a class="a" href="mots_croises.php">Recherches pour les <span>mots croisés</span></a></p>
        </div>
    </div>
</div>
<?php
include('footer.php')
?>
</body>
</html>