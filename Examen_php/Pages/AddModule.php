<h1 class="text-center mb-5 mt-5">Gestion des Modules</h1>

<!-- ==== FORMULAIRE AJOUT / MODIFICATION ==== -->
<div class="card mb-4 col-md-6 offset-3">
    <div class="card-header bg-primary text-white">
        <?= "Ajouter un module à une classe" ?>
    </div>
    <?php if (isset($_GET['error'])): ?>
        <?php if ($_GET['error'] == 1): ?>
            <div class="alert alert-danger">
                Cette Classe est inexistante
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <div class="card-body">
        <form method="POST" action="http://localhost/examen_php/Traitements/actions.php">

            <div class="mb-3">
                <label class="form-label">Nom du module</label>
                <input type="text" name="nom_module" id="" placeholder="Nom du Module" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Filière</label>
                <select name="id_classe" id="" required class="form-control">
                    <option value="">Selectionnez une filière</option>
                    <?php foreach ($filieres as $filiere): ?>
                        <option value="<?= $filiere ?>"><?= $filiere ?> </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Niveau</label>
                <select name="id_niveau" id="" class="form-control" required>
                    <option value="">Choisissez le niveau</option>
                    <?php foreach ($niveau as $niv): ?>
                        <option value="<?= $niv['id_niveau'] ?>"><?= $niv['id_niveau'] ?> </option>
                    <?php endforeach; ?>
                </select>
            </div>


            <button type="submit" class="btn btn-outline-success" name="AjoutM">
                <?= "Ajouter le Module" ?>
            </button>
            <a href="index.php?page=indexClasse" class="btn btn-outline-danger ">
                Retour
            </a>
        </form>
    </div>
</div>