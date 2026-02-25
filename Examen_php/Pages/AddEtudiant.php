<h1 class="text-center mb-5 mt-5">Ajout d'étudiant</h1>

<!-- ==== FORMULAIRE AJOUT / MODIFICATION ==== -->
<div class="card mb-4 col-md-6 offset-3">
    <div class="card-header bg-primary text-white">
        <?php echo "Ajouter un étudiant" ?>
    </div>
    <?php if (isset($_GET['error'])): ?>
        <?php if ($_GET['error'] == 1): ?>
            <div class="alert alert-danger">
                Cette classe n'existe pas encore !!
            </div>
        <?php elseif ($_GET['error'] == 2): ?>
            <div class="alert alert-danger">
                Veuillez remplir tous les informations
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <div class="card-body">
        <form method="POST" action="http://localhost/examen_php/Traitements/actions.php">

            <?php if ($etudiant): ?>
                <input type="hidden" name="id_etudiant" value="<?= $etudiant['id_etudiant'] ?>">
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label">Prénom</label>
                <input type="text" name="prenom" id="" placeholder="Saisir le prénom" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" name="nom" id="" placeholder="Saisir le nom" class="form-control">
            </div>



            <div class="mb-3">
                <label class="form-label">Filière</label>
                <select name="id_classe" id="" required class="form-control">
                    <option value="">Selectionnez une filière</option>
                    <?php foreach ($classes as $class): ?>
                        <option value="<?= $class['id_classe'] ?>"><?= $class['id_classe'] ?> </option>
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

            <button type="submit" class="btn btn-outline-success" name="AjoutE">
                <?= "Ajouter l'étudiant" ?>
            </button>
            <a href="index.php?page=indexEtudiant" class="btn btn-outline-danger ">
                Retour
            </a>
        </form>
    </div>
</div>