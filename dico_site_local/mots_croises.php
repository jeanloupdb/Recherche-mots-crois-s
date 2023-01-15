<?php
    session_start();
    $bdd = new PDO('mysql:host=localhost;dbname=bdd_chat', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET utf8"));
    $form_ltr = "";
    $mots_valid ="";
    $issetres = 0;

    function is_not_utf8($char){
        return 
        $char != 'a' && $char != 'A' &&
        $char != 'e' && $char != 'E' &&
        $char != 'r' && $char != 'R' &&
        $char != 'z' && $char != 'Z' &&
        $char != 't' && $char != 'T' &&
        $char != 'y' && $char != 'Y' &&
        $char != 'u' && $char != 'U' &&
        $char != 'i' && $char != 'I' &&
        $char != 'o' && $char != 'O' &&
        $char != 'p' && $char != 'P' &&
        $char != 'q' && $char != 'Q' &&
        $char != 's' && $char != 'S' &&
        $char != 'd' && $char != 'D' &&
        $char != 'f' && $char != 'F' &&
        $char != 'g' && $char != 'G' &&
        $char != 'h' && $char != 'H' &&
        $char != 'j' && $char != 'J' &&
        $char != 'k' && $char != 'K' &&
        $char != 'l' && $char != 'L' &&
        $char != 'm' && $char != 'M' &&
        $char != 'w' && $char != 'W' &&
        $char != 'x' && $char != 'X' &&
        $char != 'c' && $char != 'C' &&
        $char != 'v' && $char != 'V' &&
        $char != 'b' && $char != 'B' &&
        $char != 'n' && $char != 'N' && $char != '0';
    }

    function insert_char($str, $n, $char){
        $res = "";
        if($n < strlen($str) && $n>=0)
        {
            for($i = 0; $i < strlen($str); $i++)
            {
                if($i != $n)
                {
                    $res.= $str[$i];
                }else{
                    $res.= $char;
                    $res.= $str[$i];
                }
            }
        }else
        {
            $res = $str;
        }
        return $res;
    }

    function len_str($mot)
    {
        $count = 0;
        $i = 0;
        while($i<strlen($mot))
        {
            if( is_not_utf8($mot[$i]))
            {
                $i+=2;
                $count++;
            }
            else{
                $i++;
                $count++;
            }
        }
        return $count;
    }


    function mot_valid($mot, $test)
    {
        $len_mot = len_str($mot);
        $len_test = len_str($test);

        if(len_str($mot)==len_str($test))
        {
            if(strlen($mot)!=strlen($test))
            {
                $k=0;
                while($k<strlen($test))
                {
                    if(is_not_utf8($test[$k]))
                    {
                        $mot = insert_char($mot, $k, '0');
                        $k++;
                    }
                    $k++;
                    
                    
                }
            }
        }
    
        $res = true;
        if($len_test == $len_mot)
        {
            for($i = 0; $i<$len_mot; $i++)
            {
                if($mot[$i] != '0' && $test[$i] != $mot[$i])
                {
                    $res = false;
                }
            }
        }else
        {
            $res = false;
        }
        
        return $res;
    }




    if(isset($_POST['submit']))
    {
        if(isset($_POST['nb_ltr']))
        {
            $form_ltr.= '<br><form method="POST"><p>Saisissez le mot que vous recherchez <strong>EN Minuscule</strong> en laissant un <strong>ESPACE</strong> ou une <strong>CASE VIDE</strong> pour les lettres inconnues</p>';
            $nb_ltr = $_POST['nb_ltr'];
            $_SESSION['nb_ltr'] = $_POST['nb_ltr'];
            for($i=0; $i<$nb_ltr; $i++)
            {
                if($nb_ltr > 0 && $i<$nb_ltr - 1){
                    $in =  'onKeyUp="suivant(this,\'lettre'.((int)$i+1).'\', 1)"';
                }else{
                    $in = "";
                }
                $form_ltr.= '<input class="lettre" id="lettre'.$i.'" type="text" maxlength="1" size="1" name="lettre'.$i.'" '.$in.'>';
            }
            $form_ltr.= '<input id="submit2" type="submit" name="submit2" value="Valider..."></form>';
            $issetres = 0;
        }

    }
    if(isset($_POST['submit2'])){
        ?>
        
        <?php
        $issetres = 1;
    }


    if(isset($_SESSION['nb_ltr'])){
        $nb_ltr = $_SESSION['nb_ltr'];
    }
    
    $lemot = "";
    if(isset($_POST['submit2']))
    {
        for($i=0; $i<$nb_ltr; $i++){
            if(isset($_POST['lettre'.$i]) && $_POST['lettre'.$i] != '' && $_POST['lettre'.$i] != ' ')
            {
                $lemot.=$_POST['lettre'.$i];
            }else
            {
                $lemot.='0';
            }
        }
        $bdd1 = new PDO('mysql:host=localhost;dbname=bdd_chat', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET utf8"));
        $rep1 = $bdd1->query('SELECT mot FROM lexique383');
        $mots_valid.='<h3>Tous les mots de la langue française respectants cette structure sont : </h3>';
        while( $donnees = $rep1->fetch()){
            $mot = $donnees['mot'];
            if(mot_valid($lemot, $mot)){
                $mots_valid.= '<p class="mot">'.$mot.'</p>';
            }
        }
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
    <title>Résoudre une ligne de mots croisés</title>
</head>
<body>
<div id="contener-total">
<div id="bar">
    <img src="loading-buffering.gif" alt="Chargement...">
    <p>Calculs en cours...</p>
</div>
<a href="index.php" id="accueil">⇚ Retour à l'accueil</a>
<h1>Résolution d'une ligne de mots croisés</h1>
<div id="contener">
    <form method="POST">
        <label>Nombre de lettres dans le mot : <input type="number" min="1" max="50" name="nb_ltr"></label>
        <input type="submit" name="submit">
    </form>

    <div class="subline"></div>
    <?php
        echo $form_ltr;
    ?>

    

    <script type="text/javascript">
        function suivant(enCours, id_suivant, limite)
        {
            if (enCours.value.length >= limite)
            {
                document.getElementById(id_suivant).focus();
            }
        }

        document.getElementById('submit2').onclick = function()
        {
            document.getElementById('bar').style.display = "inline-block";
        }
    </script>

    <div class="<?php if($issetres == 1){echo 'resultat';}else{echo 'rien';} ?>">
        <?php
            echo $mots_valid;
        ?>
    </div>
</div>
</div>
</body>
</html>