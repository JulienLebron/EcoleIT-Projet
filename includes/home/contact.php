<section id="contact" class="py-5 bg-white">
    <div class="container">

        <!-- En-tête -->
        <div class="text-center mb-5">
            <div class="d-inline-block px-4 py-2 rounded-pill mb-3" style="background-color: #ffe4e6; color: #e11d48;">
                Contact
            </div>
            <h2 class="display-5 fw-bold text-dark mb-4">Nous trouver</h2>
            <p class="fs-5 text-secondary mx-auto" style="max-width: 48rem;">
                Situé au cœur de Paris, notre salon est facilement accessible en transports en commun.
            </p>
        </div>

        <div class="row g-5 mx-auto" style="max-width: 90rem;">

            <!-- Carte et informations -->
            <div class="col-lg-6">
                <div class="mb-4">
                    <div class="overflow-hidden shadow" style="aspect-ratio: 16 / 9; border-radius: 1.5rem; background-color: #f3f4f6;">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.9916256937595!2d2.3382!3d48.8606!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66e2964e34e2d%3A0x8ddca9ee380ef7e0!2sLouvre%20Museum!5e0!3m2!1sen!2sfr!4v1234567890"
                            width="100%"
                            height="100%"
                            style="border: 0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Localisation du salon">
                        </iframe>
                    </div>
                </div>

                <div class="p-4 shadow-lg" style="background: linear-gradient(135deg, #f9fafb, #fff1f2); border-radius: 1.5rem;">
                    <h3 class="fs-4 text-dark mb-4">Coordonnées & Accès</h3>

                    <div class="d-flex flex-column gap-4">

                        <div class="d-flex gap-3">
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0 text-white"
                                 style="width: 3.5rem; height: 3.5rem; background-color: #f43f5e; border-radius: 1rem;">
                                <i class="fa-solid fa-location-dot" style="font-size: 28px;"></i>
                            </div>
                            <div>
                                <h4 class="text-dark mb-2 fs-5">Adresse</h4>
                                <p class="text-secondary mb-0" style="line-height: 1.7;">
                                    12 Rue de la Beauté<br>
                                    75001 Paris, France
                                </p>
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0 text-white"
                                 style="width: 3.5rem; height: 3.5rem; background-color: #f43f5e; border-radius: 1rem;">
                                <i class="fa-solid fa-phone" style="font-size: 28px;"></i>
                            </div>
                            <div>
                                <h4 class="text-dark mb-2 fs-5">Téléphone</h4>
                                <a href="tel:+33123456789" class="text-secondary text-decoration-none fs-5">
                                    01 23 45 67 89
                                </a>
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0 text-white"
                                 style="width: 3.5rem; height: 3.5rem; background-color: #f43f5e; border-radius: 1rem;">
                                <i class="fa-solid fa-envelope" style="font-size: 28px;"></i>
                            </div>
                            <div>
                                <h4 class="text-dark mb-2 fs-5">Email</h4>
                                <a href="mailto:contact@lelegance.fr" class="text-secondary text-decoration-none">
                                    contact@studio21.fr
                                </a>
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0 text-white"
                                 style="width: 3.5rem; height: 3.5rem; background-color: #f43f5e; border-radius: 1rem;">
                                <i class="fa-solid fa-route" style="font-size: 28px;"></i>
                            </div>
                            <div>
                                <h4 class="text-dark mb-2 fs-5">Transports</h4>
                                <div class="text-secondary">
                                    <p class="mb-1">Métro : Lignes 1, 7, 14 - Palais Royal</p>
                                    <p class="mb-1">Bus : Lignes 21, 27, 39, 48, 95</p>
                                    <p class="mb-0">Parking public à 100m</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Formulaire -->
            <div id="rendez-vous" class="col-lg-6">
                <div class="p-4 p-md-5 text-white shadow-lg" style="background: linear-gradient(135deg, #f43f5e, #fb7185); border-radius: 1.5rem;">
                    <h3 class="fs-3 mb-3">Prendre rendez-vous</h3>
                    <p class="mb-4" style="color: #ffe4e6;">
                        Remplissez le formulaire ci-dessous et nous vous recontacterons dans les plus brefs délais pour confirmer votre rendez-vous.
                    </p>

                    <form action="#" method="post">

                        <div class="mb-3">
                            <label for="name" class="form-label" style="color: #fff1f2;">Nom complet *</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-control py-3"
                                placeholder="Votre nom"
                                required
                                style="background-color: rgba(255,255,255,0.1); backdrop-filter: blur(4px); border: 2px solid rgba(255,255,255,0.2); color: white; border-radius: 1rem;"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label" style="color: #fff1f2;">Email *</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control py-3"
                                placeholder="votre@email.fr"
                                required
                                style="background-color: rgba(255,255,255,0.1); backdrop-filter: blur(4px); border: 2px solid rgba(255,255,255,0.2); color: white; border-radius: 1rem;"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label" style="color: #fff1f2;">Téléphone *</label>
                            <input
                                type="tel"
                                id="phone"
                                name="phone"
                                class="form-control py-3"
                                placeholder="06 12 34 56 78"
                                required
                                style="background-color: rgba(255,255,255,0.1); backdrop-filter: blur(4px); border: 2px solid rgba(255,255,255,0.2); color: white; border-radius: 1rem;"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="service" class="form-label" style="color: #fff1f2;">Service souhaité *</label>
                            <select
                                id="service"
                                name="service"
                                class="form-select py-3"
                                required
                                style="background-color: rgba(255,255,255,0.1); backdrop-filter: blur(4px); border: 2px solid rgba(255,255,255,0.2); color: white; border-radius: 1rem;"
                            >
                                <option value="" style="color: #111827;">Sélectionnez un service</option>
                                <option value="coupe" style="color: #111827;">Coupe</option>
                                <option value="coloration" style="color: #111827;">Coloration</option>
                                <option value="brushing" style="color: #111827;">Brushing</option>
                                <option value="soin" style="color: #111827;">Soin capillaire</option>
                                <option value="mariee" style="color: #111827;">Coiffure de mariée</option>
                                <option value="autre" style="color: #111827;">Autre</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label" style="color: #fff1f2;">Date souhaitée</label>
                            <input
                                type="date"
                                id="date"
                                name="date"
                                class="form-control py-3"
                                style="background-color: rgba(255,255,255,0.1); backdrop-filter: blur(4px); border: 2px solid rgba(255,255,255,0.2); color: white; color-scheme: dark; border-radius: 1rem;"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label" style="color: #fff1f2;">Message</label>
                            <textarea
                                id="message"
                                name="message"
                                rows="4"
                                class="form-control py-3"
                                placeholder="Vos préférences, questions ou demandes spéciales..."
                                style="background-color: rgba(255,255,255,0.1); backdrop-filter: blur(4px); border: 2px solid rgba(255,255,255,0.2); color: white; resize: none; border-radius: 1rem;"
                            ></textarea>
                        </div>

                        <button
                            type="submit"
                            class="btn btn-light w-100 py-3 shadow"
                            style="color: #f43f5e; border-radius: 1rem;">
                            Envoyer la demande
                        </button>

                        <p class="small text-center mt-3 mb-0" style="color: #ffe4e6;">
                            * Champs obligatoires - Nous vous répondrons sous 24h
                        </p>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>