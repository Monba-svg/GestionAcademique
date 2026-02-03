<?php include "Traitements/actions.php" ;?>

<h1 class="text-center mb-5 mt-5">Listes des tâches</h1>

<form action="index.php" method="get">
        <input type="hidden" name="page" value="indexTache">
    <div class="col-md-4 mb-3">
      <input type="text" name="filter" class="form-control"
             placeholder="Recherche (titre ou description)"
             value="<?= $_GET['filter'] ?? '' ?>">
      </div>
       <div class="col-md-3 mb-3">
            <select name="statut" class="form-select">
                <option value="">Tous les statuts</option>
                <option value="a faire" <?= (($_GET['statut'] ?? '') == 'a faire') ? 'selected' : '' ?>>A faire</option>
                <option value="en cours" <?= (($_GET['statut'] ?? '') == 'en cours') ? 'selected' : '' ?>>En cours</option>
                <option value="terminée" <?= (($_GET['statut'] ?? '') == 'terminer') ? 'selected' : '' ?>>Terminer</option>
            </select>
        </div>

        <div class="col-md-3 mb-3">
            <select name="priorite" class="form-select">
                <option value="">Toutes les priorités</option>
                <option value="basse" <?= (($_GET['priorite'] ?? '') == 'basse') ? 'selected' : '' ?>>Basse</option>
                <option value="moyenne" <?= (($_GET['priorite'] ?? '') == 'moyenne') ? 'selected' : '' ?>>Moyenne</option>
                <option value="haute" <?= (($_GET['priorite'] ?? '') == 'haute') ? 'selected' : '' ?>>Haute</option>
            </select>
        </div>
        <div class="col-md-3 mb-3" >
            <button class="btn btn-primary ">Filtrer</button>
        </div>
</form>

        <!-- ==== LISTE DES TÂCHES ==== -->
            <table class="table table-bordered">
                <tr>
                    <th>#</th>
                    <th>titre</th>
                    <th>Description</th>
                    <th>Priorité</th>
                    <th>Statut</th>
                    <th>Date limite</th>
                    <th>Délai</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($taches as $tache): ?>
                    <tr>
                        <td><?= $tache['id'] ?></td>
                        <td><?= $tache['titre'] ?></td>
                        <td><?= $tache['description'] ?></td>
                        <td><?= $tache['priorite'] ?></td>
                        <?php if ($tache['statut']==='à faire') : ?> 
                            <td class='bg-warning'><?= $tache['statut'] ?></td>
                        <?php elseif($tache['statut']==='en cours'):?>
                            <td class='bg-primary'><?= $tache['statut'] ?></td>
                        <?php else : ?>
                            <td class='bg-success'><?= $tache['statut'] ?></td>
                        <?php endif; ?>
                        <td><?= $tache['date_limite'] ?></td>
                        <td>
                            <?php if ($tache['date_limite'] < date('Y-m-d') || $tache['statut'] !== 'terminée'): ?>
                                <div class="alert alert-danger py-1 px-2">⚠ En retard</div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="index.php?page=AddTasks&modifier=<?= $tache['id'] ?>" class="btn btn-sm btn-primary">
                                Modifier
                            </a>
                            <a href="Traitements/actions.php?action=supprimer&id=<?= $tache['id'] ?>"
                            class="btn btn-sm btn-danger"
                            onclick="return confirm('Supprimer cette tâche ?');">
                                Supprimer
                            </a>
                        </td>
                    </tr>
                    
                <?php endforeach; ?>
            </table>       
            