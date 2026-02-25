<?php include "Traitements/actions.php";
?>

<h1 class="text-center mb-5 mt-5">Gestion des niveaux</h1>

<!-- ==== LISTE DES Niveaux vides ==== -->
<table class="table table-bordered">
    <h3 class="text-center mb-5 mt-5">listes des niveaux vides</h3>
    <tr>
        <th>Niveau</th>
        <th>Etat</th>
    </tr>
    <?php foreach ($niveauVides as $niv): ?>
        <tr>
            <td><?= $niv['id_niveau'] ?></td>
            <td>Vide</td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- ==== LISTE DES MEILLEURS ETUDIANTS PAR NIVEAUX  ==== -->
<table class="table table-bordered">
    <h3 class="text-center mb-5 mt-5">listes des meilleurs etudiants par niveau</h3>
    <tr>
        <th>#</th>
        <th>Nom</th>
        <th>Matricule</th>
        <th>Niveau</th>
        <th>Classe</th>
        <th>Moyenne</th>
    </tr>
    <?php foreach ($m as $meilleur => $value): ?>
        <tr>
            <td><?= $value['id_etudiant'] ?></td>
            <td>
                <?= $value['prenom'] . " " . $value['nom']  ?>
                <i class="fas fa-crown"></i>
            </td>
            <td><?= $value['matricule'] ?></td>
            <td><?= $value['id_niveau'] ?></td>
            <td><?= $value['id_classe'] ?></td>
            <td><?= $value['moyenne'] ?></td>

        </tr>
    <?php endforeach; ?>
</table>