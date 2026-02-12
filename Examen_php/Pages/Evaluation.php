<h1 class="text-center mb-5 mt-5">Gestion des Evaluations</h1>

<!-- ==== FORMULAIRE AJOUT / MODIFICATION ==== -->
<div class="card mb-4 col-md-6 offset-3">
    <div class="card-header bg-primary text-white">
        <?= isset($note_a_modifier) ? "Modifier l'évaluation" : "Ajouter une évaluation " ?>
    </div>
    <?php if (isset($_GET['error'])): ?>
        <?php if ($_GET['error'] == 1): ?>
            <div class="alert alert-danger">
                La note n'est jamais négative
            </div>
        <?php else: ?>
            <div class="alert alert-danger">
                La note ne peut pas être supérieur à 20
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <div class="card-body">
        <form method="POST" action="http://localhost/examen_php/Traitements/actions.php">

            <?php if ($note_a_modifier): ?>
                <input type="hidden" name="id_note" value="<?= $note_a_modifier['id_note'] ?>">
                <input type="hidden" name="id_etudiant" value="<?= $note_a_modifier['id_etudiant'] ?>">
            <?php else: ?>
                <input type="hidden" name="id_etudiant" value="<?= $_GET['id'] ?>">
                <input type="hidden" name="id_classe" value="<?= $_GET['classe'] ?>">
                <input type="hidden" name="id_niveau" value="<?= $_GET['niveau'] ?>">
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label">Type de l'évaluation</label>
                <?php if ($note_a_modifier): ?>
                    <input type="text" name="type_eval" value="<?= $note_a_modifier['type'] ?> " id=""
                        placeholder="Type de l'eval" class="form-control">
                <?php else: ?>
                    <select name="type_eval" id="" class="form-control" required>
                        <option value="">Selectionnez le type du devoir</option>
                        <?php foreach ($type as $typ): ?>
                            <option value="<?= $typ ?>"><?= $typ ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <?php if (!$note_a_modifier): ?>
                    <label class="form-label">Module de l'évaluation</label>
                    <select name="id_module" id="" class="form-control" required>
                        <option value="">Selectionnez un Module</option>
                        <?php foreach ($module as $mod): ?>
                            <option value="<?= $mod['id_module'] ?>"><?= $mod['nom_module'] ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label class="form-label">note</label>
                <input type="number" name="note" value="<?= $note_a_modifier['note'] ?>" id="" placeholder="Note"
                    class="form-control">
            </div>

            <button type="submit" class="btn btn-outline-success"
                name="<?= isset($note_a_modifier) ? "modifN" : "AjoutN" ?>">
                <?= isset($note_a_modifier) ? "Modifier l'évaluation" : "Ajouter l'évaluation" ?>
            </button>

            <a href="index.php?page=indexEval&eval=<?= isset($_GET['id']) ? $id = $_GET['id'] : $_GET ?>?>"
                class="btn btn-outline-danger ">
                Retour
            </a>

        </form>
    </div>
</div>