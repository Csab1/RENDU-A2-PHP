<?php
require __DIR__ . "/vendor/autoload.php";

## ETAPE 0

## CONNECTEZ VOUS A VOTRE BASE DE DONNEE
$pdo = new PDO('mysql:host=127.0.0.1;dbname=jdr', "root", "");

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=jdr', "root", "");
} catch (PDOException $e) {
    echo $e->getMessage();}
## ETAPE 1

## RECUPERER TOUT LES PERSONNAGES CONTENU DANS LA TABLE personnages
$queryperso = $pdo->prepare("SELECT * FROM personnages");
$queryperso->execute();
$allperso= $queryperso->fetchAll(PDO::FETCH_OBJ);?>
<?php
## ETAPE 2

## LES AFFICHERS DANS LE HTML
## AFFICHER SON NOM, SON ATK, SES PV, SES STARS


## ETAPE 3

## DANS CHAQUE PERSONNAGE JE VEUX POUVOIR APPUYER SUR UN BUTTON OU IL EST ECRIT "STARS"

## LORSQUE L'ON APPUIE SUR LE BOUTTON "STARS"

## ON SOUMET UN FORMULAIRE QUI METS A JOURS LE PERSONNAGE CORRESPONDANT (CELUI SUR LEQUEL ON A CLIQUER) EN INCREMENTANT LA COLUMN STARS DU PERSONNAGE DANS LA BASE DE DONNEE

#######################
## ETAPE 4
# AFFICHER LE MSG "PERSONNAGE ($name) A GAGNER UNE ETOILES"


?>



<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rendu Php</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<nav class="nav mb-3">
    <a href="./rendu.php" class="nav-link">Accueil</a>
    <a href="./personnage.php" class="nav-link">Mes Personnages</a>
    <a href="./combat.php" class="nav-link">Combats</a>
</nav>
<h1>Mes personnages</h1>
<div class="w-100 mt-5">


        <?php
            foreach ($allperso as  $item)
            { ;
                 if (isset($_POST["star".$item->id]))
                 {

                    $item->stars=$item->stars +1 ;
                    $queryperso = $pdo->prepare("UPDATE personnages SET stars =:stars WHERE name = :name");
                    $queryperso->execute([":stars"=>$item->stars , ":name"=>$item->name]);
                    echo "le personnage  $item->name  a gagner une etoile";}
                 else {}
                 ?>
<br>
    <form action="" method="POST" class="form-group">

            <input type="hidden" name="id">
                    ID : <?php echo $item->id; ?>
            <input type="hidden" name="nom<?php echo $item->name?>" >
                    Nom : <?php echo $item->name; ?>
            <input type="hidden" name="atk"  >
                    ATK : <?php echo $item->atk; ?>
            <input type="hidden" name="pv" class="form-control">
                    PV : <?php echo $item->pv; ?>
            <input type="hidden" name="stars" class="form-control">
                    STARS : <?php echo $item->stars ;?>
            <input type="submit" class="button" name="star<?php echo $item->id?>" value="STARS" >
        <br>



            <?php
            }
            ?>



    </form>

</div>












</div>


</body>
</html>

