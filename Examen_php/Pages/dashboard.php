                    <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body fs-5">Nombre de Total de Classe : 
                                        <div class="text-center fs-1 me-4"><?php echo $TotalClasse; ?> </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="text-white stretched-link" href="index.php?page=indexClasse">Gestion Classe</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body fs-5">Total d'étudiant : 
                                        <div class="text-center fs-1 me-4"><?php echo $Totaletudiant ;?> </div> </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="text-white stretched-link" href="index.php?page=indexEtudiant">Gestion des étudiants</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body fs-5">Total de module enregistrer : 
                                      <div class="text-center fs-1 me-4">  <?php echo $mod ?> </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <!-- <a class="text-white stretched-link" href="index.php?page=indexTache">Voir tâches</a> -->
                                        <!-- <div class="small text-white"><i class="fas fa-angle-right"></i></div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body fs-5">Nombre Total de niveau : 
                                        <div class="text-center fs-1 me-4"><?php echo $TotalNiveau ;?> </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="index.php?page=indexNiveau">Gestion des Niveaux</a> 
                                         <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
