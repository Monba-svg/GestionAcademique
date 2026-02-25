<?php include "Traitements/actions.php";
?>

<h1 class="text-center mb-5 mt-5">Listes des évaluations</h1>

<!-- ==== LISTE DES Evaluations ==== -->
<table class="table table-bordered">
    <tr>
        <th>#</th>
        <th>Etudiant</th>
        <th>Classe</th>
        <th>Module</th>
        <th>type</th>
        <th>Note</th>
        <th>Action</th>

    </tr>
    <?php foreach ($note as $not): ?>
        <tr>
            <td><?= $not['id_note'] ?></td>
            <td><?= $not['prenom'] . " " . $not["nom"] ?></td>
            <td><?= $not['id_classe'] ?></td>
            <td><?= $not['nom_module'] ?></td>
            <td><?= $not['type_eval'] ?></td>
            <td><?= $not['note'] ?></td>
            <td><a href="index.php?page=Evaluation&note=<?= $not['id_note'] ?>&id=<?= $not['id_etudiant'] ?>"
                    class="btn btn-sm btn-outline-success">
                    Modifier
                </a>
                <a href="http://localhost/examen_php/Traitements/actions.php?action=deleteNote&id=<?= $not['id_note'] ?>&id_etudiant=<?= $not['id_etudiant'] ?>"
                    class="btn btn-sm btn-outline-danger"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette évaluation ?')">
                    Supprimer
                </a>
            </td>
        </tr>

    <?php endforeach; ?>
</table>