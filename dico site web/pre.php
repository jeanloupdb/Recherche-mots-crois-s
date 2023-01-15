<?php
    $bdd = new PDO('mysql:host=localhost;dbname=id16954797_bdd', 'id16954797_dictionnaire', 'X[s??]TyUg6af_%+', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET utf8"));
    $issetres = 0;
    function preff($mot, $preff){
        $mot = strtolower($mot);
        $test = strtolower($preff);

        $len_mot = strlen($mot);
        $len_preff = strlen($preff);

        $res = true;

        if($len_preff <= $len_mot)
        {
            for($i= 0; $i<$len_preff; $i++)
            {
                if($mot[$i] != $preff[$i])
                {
                    $res = false;
                }
            }
        }else{
            $res = false;
        }
        return $res;
    }

    $pref_mots = "";
    if(isset($_POST['submit'])){
        if(isset($_POST['prefixe'])){
            $preff = htmlspecialchars( $_POST['prefixe']);
            $preff = strtolower($preff);
            $bdd1 = new PDO('mysql:host=localhost;dbname=id16954797_bdd', 'id16954797_dictionnaire', 'X[s??]TyUg6af_%+', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET utf8"));
            $rep1 = $bdd1->query('SELECT mot FROM lexique383');
            $pref_mots.='<h3>Les mots comanceant par "'.$preff.'..." : </h3>';
            while( $donnees = $rep1->fetch()){
                $mot = $donnees['mot'];
                if(preff($mot, $preff)){
                    $pref_mots.= '<p class="mot">'.$mot.'</p>';
                }
            }
        }
        $issetres = 1;
        ?>
        <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
        <script type="text/javascript">
            document.getElementById('bar').style.display = "none";
        </script>
        
        <?php
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
    <link rel="icon" type="image/png" href="livre.png" />
    <title>Tous les mot préfixé par [...]</title>
</head>
<body>
<div id="contener-total">
<a href="index.php" id="accueil">⇚ Retour à l'accueil</a>
    <div id="bar">
        <img src="loading-buffering.gif" alt="Chargement...">
        <p>Calculs en cours...</p>
    </div>
    <div id="contener">
        <h1>Trouver la liste des mots comanceant par ...</h1>
        <form method="POST">
            <label>Préfixe : <input type="text" name="prefixe"></label>
            <input id="submit" type="submit" name="submit" value="Valider">
        </form>
        
        <script type="text/javascript">
        document.getElementById('submit').onclick = function()
        {
            document.getElementById('bar').style.display = "inline-block";

        }
        </script>
        <div class="<?php if($issetres == 1){echo 'resultat';}else{echo 'rien';} ?>">
            <?php
                echo $pref_mots;
            ?>
        </div>
    </div>
</div>

</body>
</html>