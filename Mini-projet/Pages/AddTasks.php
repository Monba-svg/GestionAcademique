   <h1 class="text-center mb-5 mt-5">Gestion des tâches</h1>

   <!-- ==== FORMULAIRE AJOUT / MODIFICATION ==== -->
        <div class="card mb-4 col-md-6 offset-3">
            <div class="card-header bg-primary text-white">
                <?= $tache_a_modifier ? "Modifier une tâche" : "Ajouter une tâche" ?>
            </div>
            <?php if(isset($_GET['error'])) : ?>
                <?php if($_GET['error']==1) : ?>
                    <div class="alert alert-danger">
                        Veuillez remplir tous les champs
                    </div>
                <?php elseif($_GET['error']==2) : ?>
                    <div class="alert alert-danger">
                        La date limite doit être supérieure ou égale à Aujourd'hui
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <div class="card-body">
                <form method="POST" action="Traitements/actions.php">

                    <input type="hidden" name="action" value="<?= $tache_a_modifier ? "modifier" : "ajouter" ?>">

                    <?php if ($tache_a_modifier): ?>
                        <input type="hidden" name="id" value="<?= $tache_a_modifier['id'] ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Titre</label>
                        <input type="text" class="form-control" name="titre" required
                            value="<?= $tache_a_modifier['titre'] ?? '' ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3"><?= $tache_a_modifier['description'] ?? '' ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Responsable</label>
                       <input type="text" class="form-control" name="responsable" required
                            value="<?= $tache_a_modifier['responsable'] ?? '' ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date Limite</label>
                        <input type="date" name="date_limite" class="form-control"
                        value="<?= $tache_a_modifier['date_limite'] ?? '' ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Priorité</label>
                        <select class="form-select" name="priorite">
                            <option value="basse" <?= ($tache_a_modifier['priorite'] ?? '') == "basse" ? "selected" : "" ?>>basse</option>
                            <option value="moyenne" <?= ($tache_a_modifier['priorite'] ?? '') == "moyenne" ? "selected" : "" ?>>moyenne</option>
                            <option value="haute" <?= ($tache_a_modifier['priorite'] ?? '') == "haute" ? "selected" : "" ?>>haute</option>
                        </select>
                    </div>

                       <?php if ($tache_a_modifier): ?>
                
                            <div class="mb-3">
                                <label class="form-label">Statut</label>
                                <select class="form-select" name="statut">
                                    <?php if($tache_a_modifier['statut']==='à faire') : ?>
                                        <option value="à faire" <?= ($tache_a_modifier['statut'] ?? '') == "à faire" ? "selected" : "" ?>>A faire</option>
                                        <option value="en cours" <?= ($tache_a_modifier['statut'] ?? '') == "en cours" ? "selected" : "" ?>>En cours</option>
                                        <option value="terminée" <?= ($tache_a_modifier['statut'] ?? '') == "terminée" ? "selected" : "" ?>>Terminée</option>
                                    <?php elseif($tache_a_modifier['statut']==='en cours'): ?>
                                        <option value="en cours" <?= ($tache_a_modifier['statut'] ?? '') == "en cours" ? "selected" : "" ?>>En cours</option>
                                        <option value="terminée" <?= ($tache_a_modifier['statut'] ?? '') == "terminée" ? "selected" : "" ?>>Terminée</option>
                                    <?php else : ?>
                                        <option value="terminée" <?= ($tache_a_modifier['statut'] ?? '') == "terminée" ? "selected" : "" ?>>Terminée</option>
                                    <?php endif;?>
                                </select>
                            </div>
                        <?php endif; ?>

                    <button type="submit" class="btn btn-success">
                        <?= $tache_a_modifier ? "Enregistrer les modifications" : "Ajouter la tâche" ?>
                    </button>

                    <?php if ($tache_a_modifier): ?>
                        <a href="index.php?page=indexTache" class="btn btn-secondary">Annuler</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
