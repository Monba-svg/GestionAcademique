<?php
include("db.php");
function getClasse()
{
    global $pdo;
    $stmt = $pdo->query("Select * from classe");
    return $stmt->fetchAll();
}
function getLevel()
{
    global $pdo;
    $stmt = $pdo->query("Select * from niveau");
    return $stmt->fetchAll();
}
function AddClasse($id_niveau, $id_classe)
{
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO classe(id_niveau,id_classe) VALUES(?,?) ");
    return $stmt->execute([$id_niveau, $id_classe]);
}
function getEtudiant($limit = 2, $offset = 0)
{
    global $pdo;
    if (isset($_GET['filter'])) {
        if (isset($_GET['id_niveau']) && isset($_GET['filiere'])) {

            $id_niveau = $_GET['id_niveau'];
            $filiere = $_GET['filiere'];
            $limit = $limit;
            $offset = $offset;
            $etudiant = $pdo->prepare("
                SELECT * 
                FROM etudiant 
                WHERE id_niveau = ? 
                  AND id_classe = ?
                LIMIT $limit OFFSET $offset
            ");
            $etudiant->execute([$id_niveau, $filiere]);
            return $etudiant->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}

function countEtudiant()
{
    global $pdo;

    if (isset($_GET['filter']) && isset($_GET['id_niveau']) && isset($_GET['filiere'])) {
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM etudiant WHERE id_niveau = ? AND id_classe = ?");
        $stmt->execute([$_GET['id_niveau'], $_GET['filiere']]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res['total'];
    }
    return 0;
}


function addEtudiant($prenom, $nom,$matricule, $id_classe, $id_niveau)
{
    global $pdo;
    $matricule=genererMatricule($prenom,$nom,$id_niveau,$id_classe);
    $stmt = $pdo->prepare('INSERT INTO etudiant(prenom,nom,matricule,id_classe,id_niveau) VALUES (?,?,?,?,?)');
    return $stmt->execute([$prenom, $nom,$matricule, $id_classe, $id_niveau]);
}

function addModule($nom_module, $id_classe, $id_niveau)
{
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO module(nom_module,id_classe,id_niveau) VALUES(? ,?,?)');
    return $stmt->execute([$nom_module, $id_classe, $id_niveau]);
}

function getNote()
{
    global $pdo;
    if (isset($_GET['eval'])) {
        $id = $_GET['eval'];
        $stmt = $pdo->prepare('SELECT * from note n join etudiant e ON e.id_etudiant=n.id_etudiant join module m on m.id_module=n.id_module where n.id_etudiant=?');
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return [];
}
function getNotebyId($id)
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM note WHERE id_note = ?');
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function modifyNote($type_eval, $note, $id_note)
{
    global $pdo;
    $stmt = $pdo->prepare('UPDATE note set type=?,note=? WHERE id_note=?');
    return $stmt->execute([$type_eval, $note, $id_note]);
}

function getModule($id_classe, $id_niveau)
{
    global $pdo;
    $stmt = $pdo->prepare('Select * from module where id_classe=? AND id_niveau=?');
    $stmt->execute([$id_classe, $id_niveau]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function addEval($type_eval, $id_module, $note, $id_etudiant)
{
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO note(type_eval,id_module,note,id_etudiant) values (?,?,?,?)");
    return $stmt->execute([$type_eval, $id_module, $note, $id_etudiant]);
}

function VerifModifyNote($note, $id_note)
{
    if ($note < 0) {
        header("Location: ../index.php?page=Evaluation&note=$id_note&error=1");
        exit();
    }
    if ($note > 20) {
        header("Location:../index.php?page=Evaluation&note=$id_note&error=2");
        exit();
    }
}
function VerifAddNote($note, $id_classe, $id_niveau, $id_etudiant)
{
    if ($note < 0) {
        header("Location: ../index.php?page=Evaluation&classe=$id_classe&niveau=$id_niveau&id=$id_etudiant&error=1");
        exit();
    }
    if ($note > 20) {
        header("Location: ../index.php?page=Evaluation&classe=$id_classe&niveau=$id_niveau&id=$id_etudiant&error=2");
        exit();
    }
}

function deleteNote($id_note)
{
    global $pdo;
    $stmt = $pdo->prepare("Delete  from note where id_note=?");
    return $stmt->execute([$id_note]);
}

function getAverage($id_etudiant, $id_classe, $id_niveau)
{
    global $pdo;
    //Sans TP
    $stmt = $pdo->prepare("SELECT SUM(n.note) AS moy FROM note n WHERE n.id_etudiant = ? AND n.type_eval <> 'TP'");
    $stmt->execute([$id_etudiant]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    //nimbre de module
    $req2 = $pdo->prepare("SELECT Count(*) as total from module where id_classe = ? and id_niveau = ?");
    $req2->execute([$id_classe, $id_niveau]);
    $count = $req2->fetch(PDO::FETCH_ASSOC);

    $moy = $res['moy'] ?? null;
    $total = $count['total'] ?? 0;

    $resultat = ($moy != null && $total > 0) ? ($moy / $total) : null;
    return $resultat;
}

function BestStudentByClasse($id_niveau, $id_classe)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT e.*,SUM(n.note) as total from etudiant e 
    JOiN note n on n.id_etudiant=e.id_etudiant
    WHERE e.id_niveau=? and e.id_classe=? and n.id_etudiant=e.id_etudiant and n.type_eval<>'TP'
    GROUP BY e.id_etudiant
    order by total desc limit 1  ");
    $stmt->execute([$id_niveau, $id_classe]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    return $res ?: null;
}

function genererMatricule($prenom, $nom, $niveau, $filiere) {
    global $pdo;

    // 1. Licence 2 = L2
    $codeNiveau = substr($niveau, 0, 1) . substr($niveau, -1); 

    // 2. Génie Logiciel = GL
    $mots = explode(' ', trim($filiere));
    $codeFiliere = (count($mots) >= 2) 
        ? strtoupper($mots[0][0] . $mots[1][0]) 
        : strtoupper(substr($filiere, 0, 2));

    $initiales = strtoupper($prenom[0] . $nom[0]);

    $annee = date('Y');

    // On cherche tous les matricules qui commencent par L2GL 
    $recherche = $codeNiveau . $codeFiliere . "%_" . $annee . "_%";
    
    $query = $pdo->prepare("SELECT COUNT(*) FROM etudiant WHERE matricule LIKE ?");
    $query->execute([$recherche]);
    
    // On récupère le nombre total d'étudiants déjà inscrits dans cette filière
    $nb = $query->fetchColumn() + 1;
    
    return $codeNiveau . $codeFiliere . $initiales . "_" . $annee . "_" . $nb;
}

function getAverageClasse($id_niveau, $filiere)
{
    global $pdo;
    $sommeDesMoyennes = 0;

    //sans pagin on recup les etudiants :)
    $stmt = $pdo->prepare("SELECT id_etudiant, id_classe, id_niveau FROM etudiant WHERE id_niveau = ? AND id_classe = ?");
    $stmt->execute([$id_niveau, $filiere]);
    $tousLesEtudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($tousLesEtudiants) {
        foreach ($tousLesEtudiants as $etu) {
            $moy = getAverage($etu['id_etudiant'], $etu['id_classe'], $etu['id_niveau']);
            if ($moy !== null && $moy !== false) {
                $sommeDesMoyennes += (float)$moy;
            }
        }
    }

    if (countEtudiant() > 0) {
        return number_format($sommeDesMoyennes / countEtudiant(), 2);
    }

    return "0.00";
}


function getEtudiantById($id_etudiant)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM etudiant WHERE id_etudiant = ?");
    $stmt->execute([$id_etudiant]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getNotesByStudent($id_etudiant, $id_classe, $id_niveau)
{
    global $pdo;
    $sql = "SELECT m.nom_module, n.note 
            FROM module m 
            LEFT JOIN note n ON m.id_module = n.id_module AND n.id_etudiant = ?
            WHERE m.id_classe = ? AND m.id_niveau = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_etudiant, $id_classe, $id_niveau]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


//Commentez par moi
function genererBulletin()
{
    if (isset($_GET['action']) && $_GET['action'] == 'generer' && isset($_GET['id'])) {

        $id_etudiant = $_GET['id'];

        // fpdf utilise de vielles methodes errorreporting permet de masquer les erreurs is depricated ces erreurs corompt le fichier et nous renvoie des textes illisibles
        error_reporting(E_ALL & ~E_DEPRECATED);
        //obstart garde les donnees en memoires permettant de nettoyer les erreurs avant de générer le fichier
        ob_start();
        require_once('fpdf/fpdf.php');
        $etu = getEtudiantById($id_etudiant);
        $id_classe = $etu['id_classe'];
        $id_niveau = $etu['id_niveau'];
        $notes = getNotesByStudent($id_etudiant, $id_classe, $id_niveau);
        $moyenne = getAverage($id_etudiant, $id_classe, $id_niveau);
        // Creation d'un nouveau pdf
        $pdf = new FPDF();
        //Addpage permet de creer une feuille elle definit par defaut une feuille A4 orienté portrait elle peut aussi prendre d'autre parametre tel que l'orientation ou le format de la feuille
        $pdf->AddPage();
        //setfont definit le style de texte elle prend en parametre la famille le style et la taille des ecritures
        $pdf->SetFont('Arial', 'B', 18);
        //cell dessine une cellule elle prend jusqua 7 parametre mais on utilise que 5 que sont largeur hauteur text bordure retour a ligne alignement et remplissage
        $pdf->Cell(190, 15, 'BULLETIN DE NOTES', 0, 1, 'C');
        //Ln saut de ligne qui prend en paramètre la hauteur
        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', 12);
        //utf8_decode gère les accents (convertit le texte UTF8 en format que fpdf comprend)
        $pdf->Cell(0, 8, utf8_decode("Étudiant : " . $etu['prenom'] . " " . $etu['nom']), 0, 1);
        $pdf->Cell(0, 8, utf8_decode("Niveau : " . $id_niveau), 0, 1);
        $pdf->Cell(0, 8, utf8_decode("Classe : " . $id_classe), 0, 1);
        $pdf->Cell(0, 8, utf8_decode("Matricule : " . $etu['matricule']), 0, 1);
        $pdf->Ln(10);
        //setfill permet de definir la couleur de fond de la cellule parametre RVB
        $pdf->SetFillColor(230, 230, 230);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(110, 10, 'MODULE', 1, 0, 'C', true);
        $pdf->Cell(80, 10, 'NOTE / 20', 1, 1, 'C', true);

        $pdf->SetFont('Arial', '', 12);
        foreach ($notes as $n) {
            $nomModule = utf8_decode($n['nom_module'] ?? 'Module');
            $pdf->Cell(110, 10, $nomModule, 1, 0, 'C');

            // Gestion du 0 si pas de note
            $noteVal = ($n['note'] !== null) ? $n['note'] : '0';
            $pdf->Cell(80, 10, $noteVal, 1, 1, 'C');
        }

        // --- TOTAL ---
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(110, 10, 'MOYENNE GENERALE', 1, 0, 'C');
        $pdf->Cell(80, 10, number_format((float)$moyenne, 2) . ' / 20', 1, 1, 'C');
        //ob_get_length mesure la taille stocké en mémoire et ob clean vide la mémoire sans l'afficher
        if (ob_get_length()) ob_clean();
        //Output permet de compiler les instructions precedentes pour creer le fichier elle prend 4 parametre I pour etre rediriger vers une page en pdf D pour le faire download F pour enregistrer le fichier dans un serveur, S qui retourne le pdf en chaines de caractere
        $pdf->Output('D', 'Bulletin_' . $etu['nom'] . '.pdf');
        exit();
    }
}

function getAllClass()
{
    global $pdo;
    $stmt = $pdo->query("SELECT COUNT(*) as tc from classe ");
    $res = $stmt->fetch(PDO::FETCH_ASSOC)['tc'];
    return $res;
}

function getAllStudents()
{
    global $pdo;
    $stmt = $pdo->query("SELECT COUNT(*) as ts from etudiant ");
    $res = $stmt->fetch(PDO::FETCH_ASSOC)['ts'];
    return $res;
}


function getAllLVL()
{
    global $pdo;
    $stmt = $pdo->query("Select COUNT(*) as tn from niveau ");
    return $stmt->fetchColumn();
}

function getNiveauxVides()
{
    global $pdo;
    $sql = "SELECT n.id_niveau 
            FROM niveau n 
            LEFT JOIN classe c ON n.id_niveau = c.id_niveau 
            WHERE c.id_niveau IS NULL";

    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getBestStudentsByLevel()
{
    global $pdo;

    $sql = "SELECT e.id_etudiant, e.nom, e.prenom,e.matricule, e.id_niveau, e.id_classe, 
            SUM(n.note) as somme_notes,
            (SELECT COUNT(*) FROM module m WHERE m.id_classe = e.id_classe AND m.id_niveau = e.id_niveau) as total_modules
            FROM etudiant e
            JOIN note n ON e.id_etudiant = n.id_etudiant
            WHERE n.type_eval <> 'TP'
            GROUP BY e.id_etudiant
            ORDER BY e.id_niveau ASC, (SUM(n.note) / (SELECT COUNT(*) FROM module m WHERE m.id_classe = e.id_classe AND m.id_niveau = e.id_niveau)) DESC";

    $stmt = $pdo->query($sql);
    $all = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $meilleur = [];
    foreach ($all as $etu) {
        if ($etu['total_modules'] > 0) {
            $etu['moyenne'] = ($etu['somme_notes'] / $etu['total_modules']);
        } else {
            $etu['moyenne'] = 0;
        }

        $niv = $etu['id_niveau'];
        if (!isset($meilleur[$niv])) {
            $meilleur[$niv] = $etu;
        }
    }

    return $meilleur;
}

function GETALLMODULE()
{
    global $pdo;
    $stmt=$pdo->query("SELECT COUNT(*) as t from module");
    return $stmt->fetchColumn();
}

function addNiveau($niv)
{
    global $pdo;
    $stmt=$pdo->prepare("Insert into niveau(id_niveau) values (?)");
    return $stmt->execute([$niv]);
}