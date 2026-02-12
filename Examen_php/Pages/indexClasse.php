<?php include "Traitements/actions.php" ;?>

<h1 class="text-center mb-5 mt-5">Listes des Classes</h1>

        <!-- ==== LISTE DES CLASSES ==== -->
            <table class="table table-bordered">
                <tr>
                    <th>Niveau</th>
                    <th>Nom de classe</th>
                    <!-- <th>Action</th> -->
                </tr>
                <?php foreach ($classes as $classe): ?>
                    <tr>
                        <td><?= htmlspecialchars($classe['id_niveau']) ?></td>
                        <td><?= htmlspecialchars($classe['id_classe']) ?></td>
                    </tr>
                    
                <?php endforeach; ?>
            </table>       
            