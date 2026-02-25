<h1 class="text-center mb-5 mt-5">Gestion des Modules</h1>

<!-- ==== FORMULAIRE AJOUT / MODIFICATION ==== -->
<div class="card mb-4 col-md-6 offset-3">
    <div class="card-header bg-primary text-white">
        <?= "Ajouter un niveau à l'établissement" ?>
    </div>
    <?php if (isset($_GET['error'])): ?>
        <?php if ($_GET['error'] == 1): ?>
            <div class="alert alert-danger">
                Ce niveau existe déjà
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <div class="card-body">
        <form method="POST" action="http://localhost/examen_php/Traitements/actions.php">




            <div class="mb-3">
                <label class="form-label">Niveau</label>
                <select name="id_niveau" id="" class="form-control" required>
                    <option value="">Choisissez le niveau</option>
                    <?php foreach ($niv as $ni): ?>
                        <option value="<?= $ni ?>"><?= $ni  ?> </option>
                    <?php endforeach; ?>
                </select>
            </div>


            <button type="submit" class="btn btn-outline-success" name="AjoutNi">
                <?= "Ajouter le niveau" ?>
            </button>
            <a href="index.php?page=indexNiveau" class="btn btn-outline-danger ">
                Retour
            </a>
        </form>
    </div>
</div>