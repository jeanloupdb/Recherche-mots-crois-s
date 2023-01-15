<?php
    $bdd = new PDO('mysql:host=localhost;dbname=bdd_chat', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET utf8"));
    $suff = "";
    $issetres = 0;
    function suff($mot, $suff){
        $mot = strtolower($mot);
        $test = strtolower($suff);

        $len_mot = strlen($mot);
        $len_suff = strlen($suff);

        $res = true;

        if($len_suff <= $len_mot)
        {
            for($i= 0; $i<$len_suff; $i++)
            {
                $i_mot = $len_mot - $len_suff + $i;
                if($mot[$i_mot] != $suff[$i])
                {
                    $res = false;
                }
            }
        }else{
            $res = false;
        }
        return $res;
    }

    $suf_mots = "";
    if(isset($_POST['submit'])){
        if(isset($_POST['suffixe'])){
            $suff = htmlspecialchars($_POST['suffixe']);
            $bdd1 = new PDO('mysql:host=localhost;dbname=bdd_chat', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET utf8"));
            $rep1 = $bdd1->query('SELECT mot FROM lexique383');
            $suf_mots.='<h3>Tous les mots finissants par "...'.$suff.'"</h3>';
            while( $donnees = $rep1->fetch()){
                $mot = $donnees['mot'];
                if(suff($mot, $suff)){
                    $suf_mots.= '<p class="mot">'.$mot.'</p>';
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
    <title>Tous les mots suffixé par [...]</title>
</head>
<body>
<div id="contener-total">
<a href="index.php" id="accueil">⇚ Retour à l'accueil</a>
    <div id="bar">
        <img src="loading-buffering.gif" alt="Chargement...">
        <p>Calculs en cours...</p>
    </div>
    <div id="contener">
        <h1>Trouver la liste des mots se finissant par ...</h1>
        <form method="POST">
            <label>Suffixe : <input type="text" name="suffixe"></label>
            <input id="submit" type="submit" name="submit">
        </form>
        <script type="text/javascript">
        document.getElementById('submit').onclick = function()
        {
            document.getElementById('bar').style.display = "inline-block";

        }
        </script>
        <div class="<?php if($issetres == 1){echo 'resultat';}else{echo 'rien';} ?>">
            <?php
                echo $suf_mots;
            ?>
        </div>
    </div>
</div>
</body>
</html>