<section id="services" class="py-5" style="background-color: #f9fafb;">
    <div class="container">

        <div class="text-center mb-5">
            <div class="d-inline-block px-4 py-2 rounded-pill mb-3" style="background-color: #ffe4e6; color: #e11d48;">
                Nos prestations
            </div>
            <h2 class="display-5 fw-bold text-dark mb-4">Services & Tarifs</h2>
            <p class="fs-5 text-secondary mx-auto" style="max-width: 48rem;">
                Découvrez notre gamme complète de services avec des tarifs transparents. Chaque prestation inclut un diagnostic personnalisé.
            </p>
        </div>

        <div class="row g-4 mx-auto" style="max-width: 90rem;">

            <?php foreach ($servicesParCategorie as $categorie => $data): ?>
                <div class="col-lg-6">
                    <div class="card bg-white border-0 shadow h-100" style="border-radius: 1.5rem;">
                        <div class="card-header bg-transparent border-0 p-4 pb-0">
                            <div class="d-flex align-items-start gap-3">
                                <div class="d-flex align-items-center justify-content-center flex-shrink-0 text-white"
                                     style="width: 3.5rem; height: 3.5rem; background-color: #f43f5e; border-radius: 1rem;">
                                    <i class="fa-solid <?= getCategorieIcon($categorie) ?>" style="font-size: 28px;"></i>
                                </div>
                                <div>
                                    <h3 class="fs-4 text-dark mb-2"><?= htmlspecialchars($categorie) ?></h3>
                                    <p class="text-secondary mb-0">
                                        <?= htmlspecialchars($data['description_categorie']) ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <div class="d-flex flex-column gap-3">

                                <?php foreach ($data['items'] as $service): ?>
                                    <div class="d-flex align-items-center justify-content-between p-3 rounded-4 service-item">
                                        <div class="flex-grow-1">
                                            <div class="text-dark mb-1">
                                                <?= htmlspecialchars($service['nom']) ?>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 small text-muted">
                                                <i class="fa-regular fa-clock"></i>
                                                <span><?= formatDuree((int)$service['duree_minutes']) ?></span>
                                            </div>
                                        </div>

                                        <div class="fs-5 fw-semibold" style="color: #f43f5e;">
                                            <?= htmlspecialchars(formatPrix((float)$service['prix_euros'])) ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

        <div class="text-center mt-5">
            <div class="p-4 mx-auto rounded-4" style="max-width: 56rem; background-color: #fff1f2;">
                <p class="text-secondary mb-0">
                    <span style="color: #e11d48; font-weight: 600;">Note :</span>
                    Les tarifs sont donnés à titre indicatif. Un devis personnalisé sera établi lors de votre rendez-vous en fonction de la longueur et de l'épaisseur de vos cheveux.
                </p>
            </div>
        </div>

    </div>
</section>