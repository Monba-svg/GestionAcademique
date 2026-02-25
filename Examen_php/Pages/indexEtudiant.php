<?php include "Traitements/actions.php"; ?>

<h1 class="text-center mb-5 mt-5">Gestion des étudiants</h1>

<form action="http://localhost/examen_php/index.php" method="get">
    <input type="hidden" name="page" value="indexEtudiant">
    <div class="col-md-3 mb-3">
        <select name="id_niveau" class="form-select">
            <option value="">Séléctionnez le niveau</option>
            <?php foreach ($niveau as $niv): ?>
                <option value="<?= $niv['id_niveau'] ?>"> <?= $niv['id_niveau'] ?> </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-3 mb-3">
        <select name="filiere" class="form-select">
            <option value="">Séléctionner la filiere</option>
            <?php foreach ($filieres as $filiere): ?>
                <option value="<?= $filiere ?>"><?= $filiere ?> </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3 mb-3">
        <button class="btn btn-primary" name="filter">Filtrer</button>
    </div>
</form>

<?php if (!$etudiant): ?>

    <div class="alert alert-danger">
        Classe Vide ou Veuillez choisir le niveau ainsi que la filière pour avoir la classe
    </div>

<?php endif; ?>

<!-- ==== LISTE DES ETUDIANTS ==== -->
<?php if ($best) : ?>
    <h3 class="text-center mb-5 mt-5">Meilleur élève</h3>
    <table class="table table-bordered mb-5">
        <tr>
            <th>#</th>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Filiere</th>
            <th>Classe</th>
            <th>Moyenne</th>
            <th>Moyenne Classe</th>
        </tr>
        <tr>
            <th>
                Meilleur élève de la classe
                <i class="fas fa-crown"></i>
            </th>
            <td><?= $best['prenom'] ?></td>
            <td><?= $best['nom'] ?></td>
            <td><?= $best['id_classe'] ?></td>
            <td><?= $best['id_niveau'] ?></td>
            <td><?php $moyB = getAverage($best['id_etudiant'], $_GET['filiere'], $_GET['id_niveau']);
                echo $moyB != null ? $moyB : "Aucune Evaluation";
                ?>
            </td>
            <td><?= $moyG ?></td>
        </tr>
    </table>
<?php endif;  ?>

<?php if ($etudiant): ?>
    <h3 class="text-center mb-5 mt-5">Liste des eleves</h3>
    <table class="table table-bordered">
        <tr>
            <th>#</th>
            <th>Nom</th>
            <th>prenom</th>
            <th>Matricule</th>
            <th>Filiere</th>
            <th>Niveau</th>
            <th>Moyenne</th>
            <th>Moyenne de la classe</th>
            <th>Mention</th>
            <th>Action</th>
        </tr>
        <?php foreach ($etudiant as $etu): ?>
            <tr>
                <td><?= $etu['id_etudiant'] ?></td>
                <td><?= $etu['nom'] ?></td>
                <td><?= $etu['prenom'] ?></td>
                <td><?= $etu['matricule'] ?></td>
                <td><?= $etu['id_classe'] ?></td>
                <td><?= $etu['id_niveau'] ?></td>
                <td><?php
                    $moy = getAverage($etu['id_etudiant'], $etu['id_classe'], $etu['id_niveau']);
                    echo $moy != null ? $moy : "Aucune note";
                    ?>
                </td>
                <td><?= $moyG ?></td>
                <td><?= ($moy >= 10) ? "Admis" : (($moy < 5) ? "Exclu" : "Ajournée") ?></td>
                <td>
                    <a href="index.php?page=indexEval&eval=<?= $etu['id_etudiant'] ?>" class="btn btn-sm btn-outline-primary">
                        Voir évaluation
                    </a>
                    <a href="index.php?page=Evaluation&classe=<?= $etu['id_classe'] ?>&niveau=<?= $etu['id_niveau'] ?>&id=<?= $etu['id_etudiant'] ?>" class="btn btn-sm btn-outline-success">
                        Ajouter une évaluation
                    </a>
                    <a href="http://localhost/examen_php/Traitements/actions.php?action=generer&id=<?= $etu['id_etudiant'] ?>" class="btn btn-sm btn-outline-danger">
                        Générer Bulletin
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class="d-flex justify-content-between">
        <?php if ($page_num > 1): ?>
            <a href="index.php?page=indexEtudiant&id_niveau=<?= $_GET['id_niveau'] ?>&filiere=<?= $_GET['filiere'] ?>&filter=1&page_num=<?= $page_num - 1 ?>" class="btn btn-secondary">
                Précédent
            </a>
        <?php endif; ?>
        <?php if ($page_num < $totalPages): ?>
            <a href="index.php?page=indexEtudiant&id_niveau=<?= $_GET['id_niveau'] ?>&filiere=<?= $_GET['filiere'] ?>&filter=1&page_num=<?= $page_num + 1 ?>" class="btn btn-secondary">
                Suivant
            </a>
        <?php endif; ?>
    </div>
<?php endif; ?>