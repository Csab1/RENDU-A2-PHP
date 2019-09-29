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
$requeteperso = $pdo->prepare("SELECT * FROM personnages WHERE pv >10 ");
$requeteperso->execute();
$allPerso = $requeteperso->fetchAll(PDO::FETCH_OBJ);
## POUVOIR SELECTIONER UN PERSONNE DANS LE PREMIER SELECTEUR

## ETAPE 2

## POUVOIR SELECTIONER UN PERSONNE DANS LE DEUXIEME SELECTEUR

## ETAPE 3

## LORSQUE LON APPPUIE SUR LE BOUTON FIGHT, RETIRER LES PV DE CHAQUE PERSONNAGE PAR RAPPORT A LATK DU PERSONNAGE QUIL COMBAT

## ETAPE 4

## UNE FOIS LE COMBAT LANCER (QUAND ON APPPUIE SUR LE BTN FIGHT) AFFICHER en dessous du formulaire
# pour le premier perso PERSONNAGE X (name) A PERDU X PV (l'atk du personnage d'en face)
# pour le second persoPERSONNAGE X (name) A PERDU X PV (l'atk du personnage d'en face)

## ETAPE 5

## N'AFFICHER DANS LES SELECTEUR QUE LES PERSONNAGES QUI ONT PLUS DE 10 PV


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
<h1>Combats</h1>
<div class="w-100 mt-5">



    <form action=""method="post">
        <div class="form-group">


            <select name="perso1" id="">
                <option value="" disabled selected>Choissisez votre personnage</option>
                <?php foreach ($allPerso as $item) { ?>
                    <option value="<?= $item->id ?>">
                        <?= $item->name ?>
                    </option>
                <?php } ?>
            </select>*
        </div>
        <form action=""method="post">
            <div class="form-group">


                <select name="perso2" id="">
                    <option value="" disabled selected>Choissisez votre personnage</option>
                    <?php foreach ($allPerso as $item) { ?>
                        <option value="<?= $item->id ?>">
                            <?= $item->name ?>
                        </option>
                    <?php } ?>
                </select>*
            </div>



        <button class="btn">Fight</button>
    </form>

</div>


<?php
if (!empty($_POST)) {
    $idPerso1 = $_POST['perso1'];
    $idPerso2 = $_POST['perso2'];
    $dbPerso1 = getPerso($idPerso1, $pdo);
    $dbPerso2 = getPerso($idPerso2, $pdo);
    $pvPerso1 = $dbPerso1->pv - $dbPerso2->atk;
    $pvPerso2 = $dbPerso2->pv - $dbPerso1->atk;
    $newPerso1 = updatePvPerso($idPerso1, $pvPerso1, $pdo);
    $newPerso2 = updatePvPerso($idPerso2, $pvPerso2, $pdo);

    echo $newPerso1->name . " a perdu " . $newPerso2->atk . " PV";
    ?><br> <br>
<?php
    echo $newPerso2->name ." a perdu " . $newPerso1->atk . " PV " ;

}
function updatePvPerso($id, $pv, $pdo)
{
    $query = $pdo->prepare("UPDATE personnages SET pv = :newPv WHERE id = :id");
    $query->execute(["newPv" => $pv, "id" => $id]);
    $state = $query->fetch(PDO::FETCH_OBJ);
    return getPerso($id, $pdo);
}
function getPerso($id, $pdo)
{
    $query = $pdo->prepare("SELECT * FROM personnages WHERE id = :id");
    $query->execute(['id' => $id]);
    return $query->fetch(PDO::FETCH_OBJ);
}?>

</body>
</html>
