<?php
$dossierPublic = "http://localhost/examen_php/Public/";
include_once("Includes/header.php");
include_once("Includes/navbar.php");
include_once("Includes/sidebar.php");
require_once("Traitements/request.php");

//********************PAGINATION****************************//

    $limit = 2;
    $page_num = isset($_GET['page_num']) ? $_GET['page_num'] : 1;
    $offset = ($page_num - 1) * $limit;
    $totalStudents = countEtudiant();

    //ceil est une fonction php qui arrondis à l'extreme :-)
    $totalPages = ceil($totalStudents / $limit);

//********************GET ETUDIANT****************************//

     $etudiant = getEtudiant($limit, $offset);

//********************GET ETUDIANT****************************//

//********************PAGINATION****************************//

//********************GET Classe****************************//

                $classes = getClasse();

//********************GET Classe****************************//

//********************GET Niveau****************************//

                $niveau = getLevel();
                
//********************GET Niveau****************************//

$filieres = ["Génie Logiciel", "IAGE", "Cybersécurité", "Data-science", "Multimédia", "Réseaux", "Comptabilité", "Gestion"];
$niv =['Licence 1','Licence 2','Licence 3','Master 1','Master 2'];
//********************GET NOTE****************************//
                    
                    $note = getNote();

//********************GET NOTE****************************//

$type = ["devoir", "examen", "TP"];

if (isset($_GET['filter']) && !empty($_GET['id_niveau']) && !empty($_GET['filiere'])) {
    $best = BestStudentByClasse($_GET['id_niveau'], $_GET['filiere']);
   $moyG=getAverageClasse($_GET['id_niveau'],$_GET['filiere']);
} else {
    $best = null;
    
}

if (isset($_GET['classe']) && isset($_GET['niveau'])) {
    $module = getModule($_GET['classe'], $_GET['niveau']);
} else {
    $module = false;
}

if (isset($_GET['note'])) {
    $note_a_modifier = getNotebyId($_GET['note']);
} else {
    $note_a_modifier = null;
}

$TotalClasse= getAllClass();
$Totaletudiant=getAllStudents();
$mod=GETALLMODULE();
$TotalNiveau=getAllLVL();
$niveauVides=getNiveauxVides();
$m=getBestStudentsByLevel();
$page = isset($_GET['page']) ? $_GET['page'] : 'Accueil';
if (file_exists("Pages/$page.php")) {
    include("Pages/$page.php");
} else {
    include_once("Pages/Erreur404.php");
}


include_once("Includes/footer.php");
