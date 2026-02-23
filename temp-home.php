<?php
/* Template Name: HomePage */



// if (!isset($_GET['skip_location_redirect']) || $_GET['skip_location_redirect'] != '1') {

//     if (!empty($_COOKIE['selected_location'])) {

//         $location_slug = sanitize_text_field($_COOKIE['selected_location']);
//         $term = get_term_by('slug', $location_slug, 'location');

//         if ($term && !is_wp_error($term)) {

//             $location_url = home_url('/' . $term->slug . '/');

//             wp_redirect($location_url);
//             exit;
//         }
//     }
// }


// NOW start the header and output
get_header(); ?>
<link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Work+Sans:wght@300;400;500;600;700&display=swap"
    rel="stylesheet" />

<style>
:root {
    --primary-blue: #2748e6;
    --deep-blue: #1a2f9e;
    --accent-orange: #6a32cc;
    --warm-orange: #8b4fe0;
    --fresh-green: #4CAF50;
    --light-green: #81C784;
    --cream: #FFF8F0;
    --light-gray: #F5F5F5;
    --medium-gray: #E0E0E0;
    --dark-gray: #333333;
    --text-primary: #1a1a1a;
    --text-secondary: #666666;
}



.font-display {
    font-family: 'Playfair Display', serif;
}

.text-deep {
    color: var(--deep-blue) !important;
}

.text-accent {
    color: var(--accent) !important;
}

.bg-accent {
    background: var(--accent-orange) !important;
}



/* Brand-ish buttons */
.btn-accent {
    --bs-btn-bg: var(--accent-orange);
    --bs-btn-border-color: var(--accent-orange);
    --bs-btn-hover-bg: var(--warm-orange);
    --bs-btn-hover-border-color: var(--warm-orange);
    --bs-btn-color: #fff;
    --bs-btn-hover-color: #fff;
    border-radius: 999px;
    box-shadow: 0 .5rem 1.5rem rgba(106, 50, 204, .25);
}

.btn-outline-accent {
    --bs-btn-color: #fff;
    --bs-btn-border-color: rgba(255, 255, 255, 1);
    --bs-btn-hover-bg: #fff;
    --bs-btn-hover-border-color: #fff;
    --bs-btn-hover-color: var(--accent);
    border-radius: 999px;
}

/* Location segmented */
.segmented {
    background: #f5f5f5;
    border-radius: 999px;
    padding: .35rem;
}

.segmented .btn {
    border-radius: 999px;
    font-weight: 600;
    padding: .45rem 1rem;
}

.segmented .btn.active {
    background: var(--primary-blue);
    border-color: var(--primary-blue);
    color: #fff;
}

/* Hero */
.hero {
    background: linear-gradient(135deg, var(--cream) 0%, #fff 100%);
    position: relative;
    overflow: hidden;
    padding-top: 6.5rem;
    /* space for fixed navbar */
    padding-bottom: 3rem;
}

.hero::before {
    content: "";
    position: absolute;
    top: -45%;
    right: -18%;
    width: 780px;
    height: 780px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(106, 50, 204, .08) 0%, transparent 70%);
    animation: float 20s ease-in-out infinite;
    z-index: 0;
}

@keyframes float {

    0%,
    100% {
        transform: translate(0, 0) rotate(0deg);
    }

    50% {
        transform: translate(-50px, 50px) rotate(180deg);
    }
}

.highlight {
    position: relative;
    display: inline-block;
    color: var(--accent);
}

.highlight::after {
    content: "";
    position: absolute;
    left: 0;
    right: 0;
    bottom: .25rem;
    height: .75rem;
    background: rgba(106, 50, 204, .2);
    z-index: -1;
    transform: skewX(-12deg);
}

.hero-img {
    border-radius: 1.75rem;
    height: 600px;
    object-fit: cover;
    box-shadow: 0 1.25rem 3.75rem rgba(0, 0, 0, .15);
    width: 100%;
}

@media (max-width: 991.98px) {
    .hero-img {
        height: 420px;
    }
}

.floating-card {
    background: #fff;
    border-radius: 1.25rem;
    box-shadow: 0 .75rem 2.5rem rgba(0, 0, 0, .10);
    animation: floatCard 6s ease-in-out infinite;
}

@keyframes floatCard {

    0%,
    100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-18px);
    }
}

.floating-card-1 {
    top: 10%;
    right: -4%;
}

.floating-card-2 {
    bottom: 15%;
    left: -4%;
    animation-delay: 2s;
}

@media (max-width: 991.98px) {
    .floating-card {
        display: none;
    }
}

/* Sections */
.section-title {
    font-size: clamp(2rem, 2.6vw + 1rem, 3rem);
    line-height: 1.15;
}

.section-sub {
    color: var(--text-secondary);
    font-size: 1.125rem;
}

/* Cards */
.cat-card {
    border: 0;
    background: var(--cream);
    border-radius: 1.5rem;
    overflow: hidden;
    transition: transform .35s cubic-bezier(.4, 0, .2, 1), box-shadow .35s cubic-bezier(.4, 0, .2, 1);
}

.cat-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 1.25rem 2.5rem rgba(0, 0, 0, .15);
}

.cat-img {
    height: 250px;
    background-size: cover;
    background-position: center;
    position: relative;
}

.cat-img::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, .5) 100%);
}

.supplier-card {
    border: 0;
    border-radius: 1.25rem;
    overflow: hidden;
    box-shadow: 0 .5rem 1.25rem rgba(0, 0, 0, .08);
    transition: transform .25s, box-shadow .25s;
    background: #fff;
}

.supplier-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 .9rem 2.5rem rgba(0, 0, 0, .14);
}

.supplier-img {
    height: 200px;
    background-size: cover;
    background-position: center;
}

/* Why choose */
.why {
    background: var(--primary-blue);
    color: #fff;
}

.why .section-sub {
    color: rgba(255, 255, 255, .85);
}

.benefit-icon {
    width: 70px;
    height: 70px;
    display: grid;
    place-items: center;
    background: rgba(255, 255, 255, .12);
    border-radius: 50%;
    font-size: 2rem;
    margin: 0 auto 1rem;
}

/* Testimonials */
.testimonial {
    background: var(--cream);
    border-radius: 1.5rem;
    border: 0;
}

.quote {
    font-size: 4rem;
    color: var(--accent);
    opacity: .3;
    line-height: 1;
}

.cta-section {
    padding: 6rem 5%;
    background: linear-gradient(135deg, var(--accent-orange), var(--warm-orange));
    color: white;
    text-align: center;
}

.cta-section h2 {
    font-family: 'Playfair Display', serif;
    font-size: 3rem;
    margin-bottom: 1.5rem;
    color: #fff;
}

.cta-section p {
    font-size: 1.3rem;
    margin-bottom: 3rem;
    opacity: 0.95;
}

.cta-buttons {
    display: flex;
    gap: 1.5rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-white {
    background: white;
    color: var(--accent-orange);
    padding: 1rem 2.5rem;
    border: none;
    border-radius: 30px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    font-family: 'Work Sans', sans-serif;
    font-size: 1.1rem;
}

.btn-outline {
    background: transparent;
    color: white;
    padding: 1rem 2.5rem;
    border: 2px solid white;
    border-radius: 30px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    font-family: 'Work Sans', sans-serif;
    font-size: 1.1rem;
}
.btn-outline:hover {
    background: white;
    color: var(--accent-orange);
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}
.btn-white:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.step-number {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--accent-orange), var(--warm-orange));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    font-weight: 700;
    color: white;
    margin: 0 auto 2rem;
    font-family: 'Playfair Display', serif;
    box-shadow: 0 10px 30px rgba(106, 50, 204, 0.3);
}





/* Reveal (IntersectionObserver toggles .in) */
.reveal {
    opacity: 0;
    transform: translateY(18px);
}

.reveal.in {
    opacity: 1;
    transform: none;
    transition: opacity .6s ease, transform .6s ease;
}
</style>

<!-- Hero -->
<header class="hero">
    <div class="container position-relative" style="z-index:1;">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="reveal">
                    <h1 class="font-display fw-black text-deep display-4 lh-sm mb-3" style="font-weight:900;">
                        Stockholms &amp; Göteborgs<br />
                        <span class="highlight">bästa catering</span><br />
                        samlat på ett ställe
                    </h1>

                    <p class="lead section-sub mb-4" style="max-width: 38rem;">
                        Boka restauranger, food trucks och cateringföretag för företagslunch, event och privata fester.
                        Enkelt, snabbt och alltid god mat.
                    </p>

                    <form class="reveal">
                        <div class="input-group shadow-lg"
                            style="border-radius: 999px; overflow:hidden; max-width: 520px;">
                            <input type="text" class="form-control border-0 py-3 ps-4"
                                placeholder="Vad behöver du? (t.ex. food truck, lunch catering)"
                                aria-label="Sök catering" />
                            <button class="btn btn-accent px-4" type="button">Sök →</button>
                        </div>
                    </form>

                    <div class="row mt-4 g-4 text-center text-lg-start">
                        <div class="col-4">
                            <div class="font-display fw-bold fs-2 text-primary">200+</div>
                            <div class="small text-muted">Leverantörer</div>
                        </div>
                        <div class="col-4">
                            <div class="font-display fw-bold fs-2 text-primary">5000+</div>
                            <div class="small text-muted">Nöjda Kunder</div>
                        </div>
                        <div class="col-4">
                            <div class="font-display fw-bold fs-2 text-primary">4.8★</div>
                            <div class="small text-muted">Genomsnittligt Betyg</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="position-relative reveal">
                    <img class="hero-img"
                        src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=1200&h=900&fit=crop&q=80"
                        alt="Food truck catering Stockholm och Göteborg" />

                    <div class="floating-card floating-card-1 p-3 position-absolute">
                        <div class="fw-semibold mb-1">⚡ Snabb leverans</div>
                        <div class="text-muted small">Beställ idag, leverans imorgon</div>
                    </div>

                    <div class="floating-card floating-card-2 p-3 position-absolute">
                        <div class="fw-semibold mb-1">✓ Verifierade leverantörer</div>
                        <div class="text-muted small">Alla leverantörer är granskade</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Categories -->
<section class="py-5 bg-white" id="kategorier">
    <div class="container py-4">
        <div class="text-center mb-5 reveal">
            <h2 class="font-display section-title text-deep mb-3">Utforska våra cateringalternativ</h2>
            <p class="section-sub mb-0 mx-auto" style="max-width: 42rem;">
                Från food trucks till gourmet-catering – vi har allt du behöver för ditt nästa event
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3 reveal" id="food-trucks">
                <div class="card cat-card h-100">
                    <div class="cat-img"
                        style="background-image:url('https://images.unsplash.com/photo-1565123409695-7b5ef63a2efb?w=900&h=600&fit=crop&q=80');">
                    </div>
                    <div class="card-body p-4">
                        <h3 class="font-display h4 text-deep mb-2">Food Trucks</h3>
                        <p class="text-muted mb-3">Över 50 food trucks med allt från gourmetburgare till vegansk
                            streetfood</p>
                        <a class="fw-semibold text-accent text-decoration-none" href="#">Boka food truck →</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 reveal" id="foretagscatering">
                <div class="card cat-card h-100">
                    <div class="cat-img"
                        style="background-image:url('https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=900&h=600&fit=crop&q=80');">
                    </div>
                    <div class="card-body p-4">
                        <h3 class="font-display h4 text-deep mb-2">Företagscatering</h3>
                        <p class="text-muted mb-3">Daglig lunch, möten och konferenser – mat för alla företagsbehov</p>
                        <a class="fw-semibold text-accent text-decoration-none" href="#">Se företagslösningar →</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 reveal" id="event">
                <div class="card cat-card h-100">
                    <div class="cat-img"
                        style="background-image:url('https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=900&h=600&fit=crop&q=80');">
                    </div>
                    <div class="card-body p-4">
                        <h3 class="font-display h4 text-deep mb-2">Event &amp; Fest</h3>
                        <p class="text-muted mb-3">Bröllop, firmafester och privata tillställningar – gör ditt event
                            minnesvärt</p>
                        <a class="fw-semibold text-accent text-decoration-none" href="#">Boka event catering →</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 reveal">
                <div class="card cat-card h-100">
                    <div class="cat-img"
                        style="background-image:url('https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=900&h=600&fit=crop&q=80');">
                    </div>
                    <div class="card-body p-4">
                        <h3 class="font-display h4 text-deep mb-2">Lunch Catering</h3>
                        <p class="text-muted mb-3">Fräsch och mättande lunch för kontor och arbetsplatser, levererad i
                            tid</p>
                        <a class="fw-semibold text-accent text-decoration-none" href="#">Beställ lunch →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How it works -->
<section class="py-5" style="background: linear-gradient(180deg, var(--cream) 0%, #fff 100%);">
    <div class="container py-4">
        <div class="text-center mb-5 reveal">
            <h2 class="font-display section-title text-deep mb-3">Så fungerar det</h2>
            <p class="section-sub mb-0">Tre enkla steg till perfekt catering</p>
        </div>

        <div class="row g-4 g-lg-5">
            <div class="col-md-4 reveal">
                <div class="text-center px-lg-3">
                    <div class="mx-auto mb-3 d-grid place-items-center step-number">1 </div>
                    <h3 class="font-display h4 text-deep mb-2">Sök &amp; Välj</h3>
                    <p class="text-muted mb-0">
                        Bläddra bland hundratals catering-alternativ från våra verifierade leverantörer. Filtrera på
                        kök, pris och dietpreferenser.
                    </p>
                </div>
            </div>

            <div class="col-md-4 reveal">
                <div class="text-center px-lg-3">
                    <div class="mx-auto mb-3 d-grid place-items-center step-number">2 </div>
                    <h3 class="font-display h4 text-deep mb-2">Boka</h3>
                    <p class="text-muted mb-0">
                        Skräddarsy din meny, välj tid och leveransplats. Betala enkelt med kort eller faktura.
                    </p>
                </div>
            </div>

            <div class="col-md-4 reveal">
                <div class="text-center px-lg-3">
                    <div class="mx-auto mb-3 d-grid place-items-center step-number">3 </div>
                    <h3 class="font-display h4 text-deep mb-2">Njut</h3>
                    <p class="text-muted mb-0">
                        Vi tar hand om resten – mat levereras precis när du vill ha den. Garanterad kvalitet varje gång.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured suppliers -->
<section class="py-5 bg-white" id="leverantorer">
    <div class="container py-4">
        <div class="text-center mb-5 reveal">
            <h2 class="font-display section-title text-deep mb-3">Utvalda leverantörer</h2>
            <p class="section-sub mb-0">Möt några av våra populäraste food trucks och cateringföretag</p>
        </div>

        <div class="row g-4">
            <div class="col-sm-6 col-lg-3 reveal">
                <div class="card supplier-card h-100">
                    <div class="supplier-img"
                        style="background-image:url('https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=900&h=650&fit=crop&q=80');">
                    </div>
                    <div class="card-body p-4">
                        <div class="fw-bold text-deep mb-1">Street Gourmet Truck</div>
                        <div class="text-muted small mb-3">Food Truck • Stockholm</div>
                        <div class="d-flex align-items-center gap-2 fw-semibold" style="color:var(--accent);">
                            <span aria-hidden="true">★★★★★</span>
                            <span class="text-muted fw-normal">4.9 (127 recensioner)</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 reveal">
                <div class="card supplier-card h-100">
                    <div class="supplier-img"
                        style="background-image:url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=900&h=650&fit=crop&q=80');">
                    </div>
                    <div class="card-body p-4">
                        <div class="fw-bold text-deep mb-1">Nordic Catering AB</div>
                        <div class="text-muted small mb-3">Företagscatering • Stockholm</div>
                        <div class="d-flex align-items-center gap-2 fw-semibold" style="color:var(--accent);">
                            <span aria-hidden="true">★★★★★</span>
                            <span class="text-muted fw-normal">4.8 (93 recensioner)</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 reveal">
                <div class="card supplier-card h-100">
                    <div class="supplier-img"
                        style="background-image:url('https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?w=900&h=650&fit=crop&q=80');">
                    </div>
                    <div class="card-body p-4">
                        <div class="fw-bold text-deep mb-1">Veggie Wagon GBG</div>
                        <div class="text-muted small mb-3">Food Truck • Göteborg</div>
                        <div class="d-flex align-items-center gap-2 fw-semibold" style="color:var(--accent);">
                            <span aria-hidden="true">★★★★★</span>
                            <span class="text-muted fw-normal">5.0 (64 recensioner)</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 reveal">
                <div class="card supplier-card h-100">
                    <div class="supplier-img"
                        style="background-image:url('https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=900&h=650&fit=crop&q=80');">
                    </div>
                    <div class="card-body p-4">
                        <div class="fw-bold text-deep mb-1">BBQ Masters</div>
                        <div class="text-muted small mb-3">Food Truck • Stockholm</div>
                        <div class="d-flex align-items-center gap-2 fw-semibold" style="color:var(--accent);">
                            <span aria-hidden="true">★★★★★</span>
                            <span class="text-muted fw-normal">4.7 (156 recensioner)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why choose -->
<section class="why py-5">
    <div class="container py-4">
        <div class="text-center mb-5 reveal">
            <h2 class="font-display section-title mb-3 text-white">Varför välja Catergo?</h2>
            <p class="section-sub mb-0">Vi gör catering enkelt, pålitligt och prisvärt</p>
        </div>

        <div class="row g-4 g-lg-5">
            <div class="col-sm-6 col-lg-3 reveal text-center">
                <div class="benefit-icon">🎯</div>
                <h3 class="h5 fw-semibold mb-2">Störst Urval</h3>
                <p class="mb-0" style="color:rgba(255,255,255,.85);">Över 200 verifierade leverantörer i Stockholm och
                    Göteborg</p>
            </div>

            <div class="col-sm-6 col-lg-3 reveal text-center">
                <div class="benefit-icon">⚡</div>
                <h3 class="h5 fw-semibold mb-2">Enkel Bokning</h3>
                <p class="mb-0" style="color:rgba(255,255,255,.85);">Boka flera leverantörer samtidigt med en enda
                    beställning</p>
            </div>

            <div class="col-sm-6 col-lg-3 reveal text-center">
                <div class="benefit-icon">✓</div>
                <h3 class="h5 fw-semibold mb-2">Trygg Leverans</h3>
                <p class="mb-0" style="color:rgba(255,255,255,.85);">Garanterad leverans i tid, varje gång. 99%
                    i-tid-garanti</p>
            </div>

            <div class="col-sm-6 col-lg-3 reveal text-center">
                <div class="benefit-icon">💳</div>
                <h3 class="h5 fw-semibold mb-2">Flexibel Betalning</h3>
                <p class="mb-0" style="color:rgba(255,255,255,.85);">Betala med faktura, kort eller delbetalning</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5 reveal">
            <h2 class="font-display section-title text-deep mb-3">Vad våra kunder säger</h2>
            <p class="section-sub mb-0">Över 5000 nöjda kunder i Stockholm och Göteborg</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 reveal">
                <div class="card testimonial h-100 p-4">
                    <div class="quote font-display">"</div>
                    <p class="mb-4">
                        Catergo gjorde vår företagskickoff till en succé! Enkelt att boka food trucks och maten var
                        fantastisk.
                        Alla anställda var supernöjda.
                    </p>
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-secondary-subtle" style="width:50px;height:50px;"></div>
                        <div>
                            <div class="fw-semibold text-deep">Anna Svensson</div>
                            <div class="text-muted small">HR-chef, TechStart AB</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 reveal">
                <div class="card testimonial h-100 p-4">
                    <div class="quote font-display">"</div>
                    <p class="mb-4">
                        Vi använder Catergo för daglig lunch på kontoret. Variationen är stor och kvaliteten är alltid
                        hög.
                        Bästa cateringlösningen vi provat!
                    </p>
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-secondary-subtle" style="width:50px;height:50px;"></div>
                        <div>
                            <div class="fw-semibold text-deep">Erik Johansson</div>
                            <div class="text-muted small">VD, Bygggruppen Stockholm</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 reveal">
                <div class="card testimonial h-100 p-4">
                    <div class="quote font-display">"</div>
                    <p class="mb-4">
                        Bokade catering till vårt bröllop via Catergo. Professionell service från start till slut och
                        maten var helt magisk.
                        Varmt rekommenderat!
                    </p>
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-secondary-subtle" style="width:50px;height:50px;"></div>
                        <div>
                            <div class="fw-semibold text-deep">Maria Andersson</div>
                            <div class="text-muted small">Privatkund, Göteborg</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <h2>Redo att boka din catering?</h2>
    <p>Börja utforska våra leverantörer och hitta perfekt mat för ditt nästa event</p>
    <div class="cta-buttons">
        <button class="btn-white">Boka Food Truck</button>
        <button class="btn-outline">Se Alla Leverantörer</button>
    </div>
</section>


<!-- Rest of your home page content here -->

<?php get_footer(); ?>

<script>
// Reveal on scroll (Bootstrap-friendly)
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) entry.target.classList.add('in');
    });
}, {
    threshold: 0.12,
    rootMargin: '0px 0px -50px 0px'
});

document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>