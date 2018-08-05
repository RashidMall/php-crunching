<?php
$string = file_get_contents("dictionnaire.txt", FILE_USE_INCLUDE_PATH);
$dico = explode("\n", $string);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dictionnaire</title>
</head>
<body>
    <div><a href="./film.php">Film</a></div>
    <div class="exo">
        <h1>Combien de mots contient ce dictionnaire ?</h1>
        <p>
            Le dictionnaire contient
            <?php
            echo sizeof($dico);
            ?>
            mots.
        </p>
    </div>
    <div class="exo">
        <h1>Combien de mots font exactement 15 caractères ?</h1>
        <p>
            <?php
            $count = 0;
            foreach($dico as $v){
                if(strlen($v) === 15){$count++;}
            }
            echo $count;
            ?>
        </p>
    </div>
    <div class="exo">
        <h1>Combien de mots contiennent la lettre « w » ?</h1>
        <p>
            <?php
            $count = 0;
            foreach($dico as $v){
                if(strpos($v, 'w') !== false || strpos($v, 'W') !== false){$count++;}
            }
            echo $count;
            ?>
        </p>
    </div>
    <div class="exo">
        <h1>Combien de mots finissent par la lettre « q » ?</h1>
        <p>
            <?php
            $count = 0;
            foreach($dico as $v){
                if(substr($v, -1) === 'q'){$count++;}
            }
            echo $count;
            ?>
        </p>
    </div>
</body>
</html>