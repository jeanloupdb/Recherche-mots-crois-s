<?php
    $issetres = 0;
    $pref_mots = "";
    if(isset($_POST['submit'])){
        if(isset($_POST['nieme'])){
            $nieme = $_POST['nieme'];
            $bdd1 = new PDO('mysql:host=localhost;dbname=bdd_chat', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET utf8"));
            $rep1 = $bdd1->query('SELECT ID, mot FROM lexique383 WHERE ID = "'.$nieme.'" ');
            if($nieme==1){
                $pref_mots.='<h3>Le 1er mot du dictionnaire est</h3>';
            }else{
                $pref_mots.='<h3>Le '.$nieme.'ème mot du dictionnaire est</h3>';
            }
            
            while( $donnees = $rep1->fetch()){
                $mot = $donnees['mot'];
                $pref_mots.= '<p class="mot">'.$mot.'</p>';
            }
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
    <title>Trouver le n-ième mot du dictionnaire</title>
</head>
<body>
<div id="contener-total">
<a href="index.php" id="accueil">⇚ Retour à l'accueil</a>
    <div id="contener">
        <h1>Quel est le n-ième mot du dictionnaire ?</h1>
        <form method="POST">
            <label>Le <input type="number" max="142694" min="1" name="nieme"> ier/eme mot du dictionnaire francais est:</label>
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