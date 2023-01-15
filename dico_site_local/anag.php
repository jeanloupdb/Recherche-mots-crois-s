<?php
    $bdd = new PDO('mysql:host=localhost;dbname=bdd_chat', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET utf8"));
    $issetres = 0;
    $issetres2 = 0;

    function replace_str($str, $n){
        $res = "";
        if($n < strlen($str) && $n>=0)
        {
            for($i = 0; $i < strlen($str); $i++)
            {
                if($i != $n)
                {
                    $res.= $str[$i];
                }
            }
        }else
        {
            $res = $str;
        }
        return $res;
    }

    function anag_prf($mot, $test){
        $mot = strtolower($mot);
        $test = strtolower($test);

        $len_mot = strlen($mot);
        $len_test = strlen($test);

        $res = true;

        if($len_mot == $len_test)
        {
            $i = 0;
            while($i<$len_mot && $res)
            {
                $res = false;
                $j = 0;
                while($j < $len_test && $res == false)
                {
                    if($mot[$i] == $test[$j])
                    {
                        $test = replace_str($test, $j);
                        $len_test = strlen($test);
                        $res = true;
                    }
                    $j++;
                }
                $i++;
            }
        }else
        {
            $res = false;
        }
        return $res;
    }

    function anag_part($mot, $test){
        $mot = strtolower($mot);
        $test = strtolower($test);

        $len_mot = strlen($mot);
        $len_test = strlen($test);

        $res = true;

        $count = 0;
        $i = 0;
        while($i<$len_test && $res)
        {
            $res = false;
            $j = 0;
            while($j < $len_mot && $res == false)
            {
                if($mot[$j] == $test[$i])
                {
                    $mot = replace_str($mot, $j);
                    $len_mot = strlen($mot);
                    $res = true;
                }
                $j++;
            }
            $i++;
        }
        return $res;
    }


    $anag_mots = "";
    
    
    if(isset($_POST['submit'])){
        if(isset($_POST['anag'])){
            $anag = htmlspecialchars($_POST['anag']);
            $bdd1 = new PDO('mysql:host=localhost;dbname=bdd_chat', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET utf8"));
            $rep1 = $bdd1->query('SELECT mot FROM lexique383');
            $anag_mots.='<h3>Les anagrammes de "'.$anag.'" : </h3>';
            while( $donnees = $rep1->fetch()){
                $mot = $donnees['mot'];
                if(anag_prf($mot, $anag) && $mot != $anag)
                {
                    $anag_mots.= '<p class="mot">'.$mot.'</p>';
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

    $anag_mots2 = "";
    if(isset($_POST['submit2'])){
        if(isset($_POST['anag2'])){
            $anag = htmlspecialchars($_POST['anag2']);
            $bdd1 = new PDO('mysql:host=localhost;dbname=bdd_chat', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET utf8"));
            $rep1 = $bdd1->query('SELECT mot FROM lexique383');
            $anag_par_l2 = "";
            if(strlen($anag)>0){
                $anag_par_l2.=$anag[0];
                for($k = 1; $k < strlen($anag); $k++){
                    $anag_par_l2.=' - '.$anag[$k];
                }
            }
            $anag_mots2.='<h3>Les mots incluants les lettres : '.$anag_par_l2.' : </h3>';
            while( $donnees = $rep1->fetch()){
                $mot = $donnees['mot'];
                if(anag_part($mot, $anag) && $mot != $anag)
                {
                    $anag_mots2.= '<p class="mot">'.$mot.'</p>';
                }
            }
        }
        $issetres2 = 1;
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
    <title>Tous les anagrammes d'un mot</title>
</head>
<body>
    <div id="contener-total">
    <a href="index.php" id="accueil">⇚ Retour à l'accueil</a>
        <div id="bar">
            <img src="loading-buffering.gif" alt="Chargement...">
            <p>Calculs en cours...</p>
        </div>
        <h1>Trouver les anagrammes d'un mot.</h1>
        <div id="contener">
            <form method="POST">
                <label>Chercher les anagrammes parfaits de <input type="text" name="anag">
                <input id="submit" type="submit" name="submit"></label>
                
            </form>
            <script type="text/javascript">
            document.getElementById('submit').onclick = function()
            {
                document.getElementById('bar').style.display = "inline-block";

            }
            </script>

            
            <div class="subline"></div>
            <div class="<?php if($issetres == 1){echo 'resultat';}else{echo 'rien';} ?>">
                <?php
                    echo $anag_mots;
                ?>
            </div>
            
            <form method="POST">
                <label>Chercher les anagrammes partiels de <input type="text" name="anag2">
                <input id="submit2" type="submit" name="submit2"></label>
            </form>
            <script type="text/javascript">
            document.getElementById('submit2').onclick = function()
            {
                document.getElementById('bar').style.display = "inline-block";

            }
            </script>
            <div class="<?php if($issetres2 == 1){echo 'resultat';}else{echo 'rien';} ?>">
                <?php
                    echo $anag_mots2;
                ?>
            </div>
        </div>
    </div>
</body>
</html>