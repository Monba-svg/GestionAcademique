<?php
require_once("request.php");
//1.Ajouter une classe
if (isset($_POST['AjoutC'])) {
    extract($_POST);
    try {
        if (AddClasse($id_niveau, $id_classe)) {
            header('Location: ../index.php?page=indexClasse');
        }
    } catch (PDOException $e) {
        header('Location: ../index.php?page=AddClasse&error=1');
    }
}
//2.Liste d'étudiant suivant la classe
if (isset($_GET['filter'])) {
    getEtudiant();
}
//3.Création d'un étudiant
if (isset($_POST['AjoutE'])) {
    extract($_POST);
    try {
        if(empty($prenom)|| empty($nom))
        {
            header('Location: ../index.php?page=AddEtudiant&error=2');
            exit();
        }
        addEtudiant($prenom, $nom, $matricule, $id_classe, $id_niveau);
        header('Location: ../index.php?page=indexEtudiant');
    } catch (PDOException $e) {
        header('Location: ../index.php?page=AddEtudiant&error=1');
    }
}
//4.Création d'un module
if (isset($_POST['AjoutM'])) {
    extract($_POST);
    try {
        addModule($nom_module, $id_classe, $id_niveau);
        header('Location: ../index.php?page=indexClasse');
    } catch (PDOException $e) {
        header('Location: ../index.php?page=AddModule&error=1');
    }
}
//5. Modifier une note
if (isset($_POST['modifN'])) {
    extract($_POST);
    VerifModifyNote($note, $id_note);
    if (modifyNote($type_eval, $note, $id_note)) {
        header("Location: ../index.php?page=indexEval&eval=$id_etudiant");
        exit();
    };
}
//6.Ajouter une évaluation
if (isset($_POST["AjoutN"])) {
    extract($_POST);
    VerifAddNote($note, $id_classe, $id_niveau, $id_etudiant);
    if (addEval($type_eval, $id_module, $note, $id_etudiant)) {
        // Nettoyage et encodage pour l'URL (important pour les espaces dans "Génie Logiciel")
        var_dump($_POST); 
        die();
        $id_niveau_url = urlencode($id_niveau);
        $filiere_url = urlencode($id_classe);
        header("Location: ../index.php?page=indexEval&id_niveau=$id_niveau_url&filiere=$filiere_url&filter=");
        exit(); // Indispensable après un header Location
        header(header: "Location: ../index.php?page=indexEval&id_niveau=$id_niveau&filiere=$id_classe&filter=");
        exit();
    };
}
//7.Supprimer une évaluation
if (isset($_GET["action"]) && $_GET["action"] === "deleteNote") {
    extract($_GET);

    if (deleteNote($id)) {
        header("Location: ../index.php?page=indexEval&eval=$id_etudiant");
        exit();
    }
}
//8.Générer un bulletin
if (isset($_GET['action']) && $_GET['action'] == 'generer') {
    if (isset($_GET['id'])) {
        $id_etudiant = $_GET['id'];
        genererBulletin();
    }
}

//ajout niveau
if (isset($_POST['AjoutNi'])) {
    $ni = $_POST['id_niveau'];

    try {
        (addNiveau($ni));
        header('Location: ../index.php?page=indexNiveau');
        exit();
    } catch (PDOException $e) {
        header('Location: ../index.php?page=Addniveau&error=1');
        exit();
    }
}
