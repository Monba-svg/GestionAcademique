<?php 
include "db.php";

// 1. MODIFIER
if (isset($_POST['action']) && $_POST['action'] === 'modifier') {

    //Récupération des données via extract(plus simple et rapide)
    extract($_POST);
    // on prepare la requête
    $req = "UPDATE tache SET titre=?, description=?, date_limite=?, priorite=?, statut=?,responsable=? WHERE id=?";
    $stmt = $pdo->prepare($req);
    //on vérifie si les champs de modification ne sont pas vides
    if(empty($titre) || empty($description) || empty($date_limite) || empty($priorite))
    {
        header("Location: ../index.php?page=indexTache&error=1");
        exit();
    }
    // on vérifie si la date limite n'est pas inférieure à la date d'aujourd'hui
    if($date_limite < date ('Y-m-d'))
    {
        header("Location: ../index.php?page=indexTache&error=2");
        exit();
    }
    //Execution de la requête  
    $stmt->execute([$titre, $description, $date_limite, $priorite,$statut,$responsable,   $id]);
    header("Location: ../index.php?page=indexTache");
    exit();
    
}

//2. Ajouter une tâche 
if(isset($_POST['action']) && $_POST['action']==='ajouter')
    {
        extract($_POST);
        if(empty($titre) || empty($description) || empty($date_limite) || empty($priorite))
            {
                header("Location: ../index.php?page=indexTache&error=1");
                exit();
            }
        // on vérifie si la date limite n'est pas inférieure à la date d'aujourd'hui
        if($date_limite < date ('Y-m-d'))
            {
                header("Location: ../index.php?page=indexTache&error=2");
                exit();
            }

        $req='INSERT into tache (titre,description,date_limite,priorite) values (?,?,?,?)';
        $stmt = $pdo->prepare($req);
        $stmt->execute([$titre,$description,$date_limite,$priorite]);
        header("Location: ../index.php?page=indexTache");
        exit();
    }
//3. Supprimer une tâche 
if(isset($_GET['action']) && $_GET['action']==='supprimer')
    {
        extract($_GET);
        $id=$_GET["id"];
        //préparation de la requete de suppression
        $req="DELETE from tache WHERE id=?";       
        $stmt=$pdo->prepare($req);
        //excution
        $stmt->execute([$id]);
        header('Location: ../index.php?page=indexTache');
        exit();
    
    }



//4. RECHERCHE de tache
$sql = "SELECT * FROM tache";
$conditions = [];

if (!empty($_GET['filter'])) {
    $filter = $_GET['filter'];
    $conditions[] = "(titre LIKE '%$filter%' OR description LIKE '%$filter%')";
}

if (!empty($_GET['statut'])) {
    $statut = $_GET['statut'];
    $conditions[] = "statut = '$statut'";
}

if (!empty($_GET['priorite'])) {
    $priorite = $_GET['priorite'];
    $conditions[] = "priorite = '$priorite'";
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$stmt = $pdo->query($sql);
$taches = $stmt->fetchAll(PDO::FETCH_ASSOC);

$json = "tache.json";
file_put_contents($json, json_encode($taches, JSON_PRETTY_PRINT));

?>