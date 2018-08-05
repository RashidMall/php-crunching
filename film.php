<?php 
    $string = file_get_contents("films.json", FILE_USE_INCLUDE_PATH);
    $brut = json_decode($string, true);
    $top = $brut["feed"]["entry"]; # liste de films
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Films</title>
</head>
<body>
    <div><a href="./index.php">Dico</a></div>
    <div class="exo">
    <h1>Afficher le top10 des films</h1>
    <p>
        <?php
            for($i = 0; $i < 10; $i++){
                echo ($i+1) . ' ' . $top[$i]['im:name']['label'] . '<br/>';
            }
        ?>
    </p>
    </div>
    <div class="exo">
        <h1>Quel est le classement du film « Gravity » ?</h1>
        <p>
            <?php
            $movie = 'Gravity';
            foreach($top as $k => $arr){
                if($arr['im:name']['label'] === $movie){
                    echo $k;
                }
            }
            ?>
        </p>
    </div>
    <div class="exo">
        <h1>Quel est le réalisateur du film « The LEGO Movie » ?</h1>
        <p>
            <?php 
            $movie = 'The LEGO Movie';
            foreach($top as $arr){
                if($arr['im:name']['label'] === $movie){
                    echo $arr['im:artist']['label'];
                }
            }
            ?>
        </p>
    </div>
    <div class="exo">
        <h1>Combien de films sont sortis avant 2000 ?</h1>
        <p>
            <?php
            $count = 0;
            foreach($top as $arr){
                if(substr($arr['im:releaseDate']['label'], 0, 4) < 2000){
                    $count++;
                }
            }
            echo $count;
            ?>
        </p>
    </div>
    <div class="exo">
        <h1>Quel est le film le plus récent ? Le plus vieux ?</h1>
        <p>
            <?php
            usort($top, function($a, $b) {
                return $a['im:releaseDate']['label'] <=> $b['im:releaseDate']['label'];
            });
            echo "Le film le plus vieux: " . $top[0]['im:name']['label'] . "<br/>";
            echo "Le film le plus récent: " . $top[sizeof($top)-1]['im:name']['label'];
            ?>
        </p>
    </div>
    <div class="exo">
        <h1>Quelle est la catégorie de films la plus représentée ?</h1>
        <p>
            <?php
            $categories = [];
            foreach($top as $v){
                $category = $v['category']['attributes']['label'];
                $categories[] = $category;
            }
            $count = array_count_values($categories);
            arsort($count);
            echo key($count);
            ?>
        </p>
    </div>
    <div class="exo">
        <h1>Quel est le réalisateur le plus présent dans le top100 ?</h1>
        <p>
            <?php
            $directors = [];
            foreach($top as $v){
                $director = $v['im:artist']['label'];
                $directors[] = $director;
            }
            $count = array_count_values($directors);
            arsort($count);
            echo key($count);
            ?>
        </p>
    </div>
    <div class="exo">
        <h1>Combien cela coûterait-il d'acheter le top10 sur iTunes ? de le louer ?</h1>
        <p>
            <?php
            $totalPrice = 0.0;
            $totalRentalPrice = 0.0;
            foreach($top as $k => $arr){
                if($k <= 10){
                    $totalPrice += $arr['im:price']['attributes']['amount'];
                    if(isset($arr['im:rentalPrice'])){
                        $totalRentalPrice += $arr['im:rentalPrice']['attributes']['amount'];
                    }
                }
            }
            echo "Acheter le top10: " . $totalPrice ."$<br/>";
            echo "Louer le top10: " . $totalRentalPrice ."$";
            ?>
        </p>
    </div>
    <div class="exo">
        <h1>Quel est le mois ayant vu le plus de sorties au cinéma ?</h1>
        <p>
            <?php
            $mois = [];
            foreach($top as $arr){
                $m = explode(' ', $arr['im:releaseDate']['attributes']['label']);
                $mois[] = $m[0];
            }
            $count = array_count_values($mois);
            arsort($count);
            $count = array_keys($count, max($count) );
            foreach($count as $v){
                echo $v . '<br/>';
            }
            ?>
        </p>
    </div>
    <div class="exo">
        <h1>Quels sont les 10 meilleurs films à voir en ayant un budget limité ?</h1>
        <p>
            <?php
            $prices = [];
            foreach($top as $arr){
                if(isset($arr['im:rentalPrice']))
                $prices[] = $arr['im:rentalPrice']['attributes']['amount'];
            }
            $prices = array_unique($prices);
            asort($prices);
            
            $count = 10;
            foreach($prices as $price){
                for($i=0; $i<sizeof($top); $i++){
                    if($count>0 && isset($top[$i]['im:rentalPrice']) && $price == $top[$i]['im:rentalPrice']['attributes']['amount']){
                        echo $i . ' rang ' . ': ' . $top[$i]['im:name']['label'] . '. prix: ' . round($price,2) . '$<br/>';
                        $count--;
                    }
                }
            }
            ?>
        </p>
    </div>
</body>
</html>