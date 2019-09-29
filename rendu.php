<?php
require __DIR__ . "/vendor/autoload.php";

## ETAPE 0
$pdo = new PDO('mysql:host=127.0.0.1;dbname=jdr', "root", "");

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=jdr', "root", "");
} catch (PDOException $e) {
echo $e->getMessage();}
## CONNECTEZ VOUS A VOTRE BASE DE DONNEE

### ETAPE 1

####CREE UNE BASE DE DONNEE AVEC UNE TABLE PERSONNAGE, UNE TABLE TYPE
/*
 * personnages
 * id : primary_key int (11)
 * name : varchar (255)
 * atk : int (11)
 * pv: int (11)
 * type_id : int (11)
 * stars : int (11)
 */

/*
 * types
 * id : primary_key int (11)
 * name : varchar (255)
 */
$a = $pdo->prepare("CREATE TABLE personnages(
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(255),
        atk INT(11),
        pv INT(11),
        type_id INT(11) NULL,
        stars INT(11)
        )");
$a->execute();
$a = $pdo->prepare("CREATE TABLE types(
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR (255)
        )");
$a->execute();
#######################
## ETAPE 2

#### CREE DEUX LIGNE DANS LA TALE types
# une ligne avec comme name = feu
# une ligne avec comme name = eau

//$query = $pdo->prepare("INSERT INTO types (name) VALUES (:name)");
//$query->execute(["name" => "Feu"]);

//$query = $pdo->prepare("INSERT INTO types (name) VALUES (:name)");
//$query->execute(["name" => "Eau"]);


#######################
## ETAPE 3

# AFFICHER DANS LE SELECTEUR (<select name="" id="">) tout les types qui sont disponible (cad tout les type contenu dans la table types)
$querytype = $pdo->prepare("SELECT * FROM types");
$querytype->execute();
$alltypes= $querytype->fetchAll(PDO::FETCH_OBJ);

#######################
## ETAPE 4

# ENREGISTRER EN BASE DE DONNEE LE PERSONNAGE, AVEC LE BON TYPE ASSOCIER

if (!empty($_POST)) {
    $name = $_POST['nom'];
    $atk = $_POST['atk'];
    $pv = $_POST['pv'];
    $type = $_POST['type'];
    $querytype = $pdo->prepare("INSERT INTO personnages (name, atk, pv, type_id) VALUES (:nom, :atk,:pv, :type) ");
    $querytype->execute(["nom" => $name, "atk" => $atk, "pv" => $pv, "type" => $type]);

    $querytype = $pdo->prepare("SELECT * FROM personnages INNER JOIN types ON personnages.type_id = types.id");
    $querytype->execute(["type"=>$type]);
}



#######################
## ETAPE 5
# AFFICHER LE MSG "PERSONNAGE ($name) CREER"
if (!empty($_POST)) {
$nameperso = $_POST['nom'];
$pvperso = $_POST['pv'];
$atkperso = $_POST['atk'];
$typeperso =$_POST['type'];
 echo "Le Personnage $nameperso avec $pvperso de vie , $atkperso d'attaque de type $typeperso a été crée";
}


#######################
## ETAPE 6

# ENREGISTRER 5 / 6 PERSONNAGE DIFFERENT

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
<h1>Accueil</h1>
<div class="w-100 mt-5">
    <form action="" method="POST" class="form-group">
        <div class="form-group col-md-4">
            <label for="nom">Nom du personnage</label>
            <input type="text" name="nom" class="form-control"  placeholder="Nom">
        </div>

        <div class="form-group col-md-4">
            <label for="atk">Attaque du personnage</label>
            <input type="text" name="atk" class="form-control"  placeholder="Atk">
        </div>
        <div class="form-group col-md-4">
            <label for="pv">Pv du personnage</label>
            <input type="text" name="pv" class="form-control"  placeholder="Pv">
        </div>
        <div class="form-group col-md-4">
            <label for="type">Type</label>
            <select name="type" id="type">
                <option value="type" selected disabled>Choissisez un type</option>
                <?php
                    foreach ($alltypes as $value)
                { ?>
                        <option value="<?= $value->id ?>"><?= $value->name?> </option>
                <?php
                } ?>

            </select>
        </div>
        <button class="btn btn-primary">Enregistrer</button>
    </form>
</div>

</body>
</html>
