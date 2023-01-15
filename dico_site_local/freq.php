<?php
    $issetres = 0;

    $pref_mots = "";
    $mot = "";
    if(isset($_POST['submit'])){
        if(isset($_POST['freq'])){
            $freq = htmlspecialchars($_POST['freq']);
            $bdd1 = new PDO('mysql:host=localhost;dbname=bdd_chat', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET utf8"));
            $rep1 = $bdd1->query('SELECT mot, 7_freqlemfilms2, 9_freqfilms2 FROM lexique383 WHERE mot = "'.$freq.'" ');
            $f = 0;
            $l = 0;
            while( $donnees = $rep1->fetch()){
                $mot = $donnees['mot'];
                $f += $donnees['7_freqlemfilms2'];
                $l += $donnees['9_freqfilms2'];
            }
            
            $pref_mots.= '<h3 class="mot">'.$freq.' : </h3><p>Ce mot apparaît en moyenne '.$f.' fois sur 1million de mots dans les films.'.'<p>Ce mot apparaît en moyenne '.$l.' fois sur 1million de mots dans les livres.';
        }
        $issetres = 1;
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-language" content="fr" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" type="text/css" href="algo.css">
    <title>Frequence d'un motdans la langue</title>
</head>
<body>

<div id="contener-total">
<a href="index.php" id="accueil">⇚ Retour à l'accueil</a>
    <h1>Quel est la frequence d'un mot dans la langue française ?</h1>
    <div id="contener">
        <form method="POST">
            
            <label>Fréquence de <input type="text" maxlength="30" name="freq"> :</label>
            <input type="submit" name="submit">
        </form>

        <div class="<?php if($issetres == 1){echo 'resultat';}else{echo 'rien';} ?>">
            <?php
                echo $pref_mots;
            ?>
        </div>
    </div>
</div>

</body>
</html>