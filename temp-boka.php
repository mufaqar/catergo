<?php /* Template Name: Page-Booka */ get_header(); ?>

<style>
    :root {
        --primary-blue: #2748e6;
        --deep-blue: #1a2f9e;
        --accent-purple: #6a32cc;
        --warm-purple: #8b4fe0;
        --cream: #FFF8F0;
        --light-gray: #F5F5F5;
        --text-primary: #1a1a1a;
        --text-secondary: #666666;
    }


    /* Hero Section */
    .hero {
        background: linear-gradient(135deg, var(--cream) 0%, #FFF 100%);
        padding: 6.5rem 0 3rem;
        position: relative;
        overflow: hidden;
    }

    .hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 800px;
        height: 800px;
        background: radial-gradient(circle, rgba(106, 50, 204, 0.08) 0%, transparent 70%);
        border-radius: 50%;
    }

    .hero-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
        position: relative;
        z-index: 2;
    }

    .hero-text h1 {
        font-family: 'Playfair Display', serif;
        font-size: 3.5rem;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        color: var(--deep-blue);
    }

    .hero-text .highlight {
        color: var(--accent-purple);
        position: relative;
    }

    .hero-text p {
        font-size: 1.2rem;
        color: var(--text-secondary);
        margin-bottom: 2rem;
        line-height: 1.8;
    }

    .hero-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        margin-top: 3rem;
    }

    .stat {
        text-align: center;
    }

    .stat-number {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-blue);
        display: block;
    }

    .stat-label {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .hero-image img {
        width: 100%;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .cta-group {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .btn-primary {
        background: var(--accent-purple);
        color: white;
        padding: 1rem 2.5rem;
        border: none;
        border-radius: 30px;
        font-weight: 600;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary:hover {
        background: var(--warm-purple);
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(106, 50, 204, 0.3);
    }

    .btn-secondary {
        background: transparent;
        color: var(--primary-blue);
        padding: 1rem 2.5rem;
        border: 2px solid var(--primary-blue);
        border-radius: 30px;
        font-weight: 600;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-secondary:hover {
        background: var(--primary-blue);
        color: white;
    }

    /* Trust Indicators */
    .trust-bar {
        background: white;
        padding: 2rem 0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .trust-items {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
        text-align: center;
    }

    .trust-item {
        padding: 1rem;
    }

    .trust-icon {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
    }

    .trust-text {
        font-weight: 600;
        color: var(--text-primary);
    }

    /* Content Sections */
    .section {
        padding: 5rem 0;
    }

    .section h2 {
        font-family: 'Playfair Display', serif;
        font-size: 2.8rem;
        margin-bottom: 1.5rem;
        color: var(--deep-blue);
    }

    .section h3 {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        margin: 2rem 0 1rem;
        color: var(--deep-blue);
    }

    .section p {
        font-size: 1.1rem;
        line-height: 1.8;
        color: var(--text-secondary);
        margin-bottom: 1.5rem;
    }

    /* Food Truck Grid */
    .truck-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .truck-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s;
        cursor: pointer;
    }

    .truck-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .truck-image {
        height: 220px;
        background-size: cover;
        background-position: center;
    }

    .truck-info {
        padding: 1.5rem;
    }

    .truck-name {
        font-weight: 700;
        font-size: 1.3rem;
        margin-bottom: 0.5rem;
        color: var(--deep-blue);
    }

    .truck-cuisine {
        color: var(--accent-purple);
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .truck-description {
        color: var(--text-secondary);
        font-size: 0.95rem;
        margin-bottom: 1rem;
    }

    .truck-rating {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .stars {
        color: #FFB800;
    }

    .rating-count {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .truck-price {
        font-weight: 700;
        color: var(--primary-blue);
        font-size: 1.1rem;
    }

    /* Process Steps */
    .process-steps {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 3rem;
        margin-top: 3rem;
    }

    .step {
        text-align: center;
        position: relative;
    }

    .step-number {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--accent-purple), var(--warm-purple));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 700;
        color: white;
        margin: 0 auto 1.5rem;
        font-family: 'Playfair Display', serif;
    }

    .step h4 {
        font-size: 1.3rem;
        margin-bottom: 0.8rem;
        color: var(--deep-blue);
    }

    .step p {
        font-size: 1rem;
    }

    /* Use Cases */
    .use-cases {
        background: var(--light-gray);
    }

    .use-case-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
        margin-top: 2rem;
    }

    .use-case {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        border-left: 4px solid var(--accent-purple);
    }

    .use-case h4 {
        font-size: 1.4rem;
        margin-bottom: 1rem;
        color: var(--deep-blue);
    }

    .use-case ul {
        list-style: none;
        padding: 0;
    }

    .use-case li {
        padding: 0.5rem 0;
        padding-left: 1.5rem;
        position: relative;
    }

    .use-case li::before {
        content: "✓";
        position: absolute;
        left: 0;
        color: var(--accent-purple);
        font-weight: bold;
    }

    /* Pricing Section */
    .pricing-section {
        background: white;
    }

    .pricing-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        margin-top: 3rem;
    }

    .pricing-card {
        background: var(--cream);
        padding: 2.5rem;
        border-radius: 20px;
        text-align: center;
        border: 2px solid transparent;
        transition: all 0.3s;
    }

    .pricing-card.featured {
        background: var(--primary-blue);
        color: white;
        transform: scale(1.05);
        border-color: var(--accent-purple);
    }

    .pricing-card.featured h4,
    .pricing-card.featured .price {
        color: white;
    }

    .pricing-card h4 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        color: var(--deep-blue);
    }

    .price {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--accent-purple);
        margin-bottom: 0.5rem;
    }

    .price-detail {
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
        opacity: 0.8;
    }

    .pricing-features {
        list-style: none;
        padding: 0;
        margin-bottom: 2rem;
    }

    .pricing-features li {
        padding: 0.8rem 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    /* FAQ Section */
    .faq-section {
        background: var(--cream);
    }

    .faq-list {
        margin: 3rem auto 0;
    }

    .faq-item {
        background: white;
        margin-bottom: 1.5rem;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .faq-question {
        padding: 1.5rem;
        font-weight: 600;
        font-size: 1.1rem;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: var(--deep-blue);
    }

    .faq-question:hover {
        background: var(--light-gray);
    }

    .faq-answer {
        padding: 0 1.5rem 1.5rem;
        color: var(--text-secondary);
        line-height: 1.8;
    }

    /* CTA Section */
    .cta-section {
        background: linear-gradient(135deg, var(--accent-purple), var(--warm-purple));
        color: white;
        padding: 5rem 5%;
        text-align: center;
    }

    .cta-section h2 {
        color: white;
        font-size: 3rem;
        margin-bottom: 1.5rem;
    }

    .cta-section p {
        color: white;
        font-size: 1.3rem;
        margin-bottom: 2.5rem;
        opacity: 0.95;
    }

    .btn-white {
        background: white;
        color: var(--accent-purple);
        padding: 1.2rem 3rem;
        border: none;
        border-radius: 30px;
        font-weight: 600;
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-white:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    /* Areas Served */
    .areas-section {
        background: white;
    }

    .areas-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-top: 2rem;
    }

    .area-tag {
        background: var(--light-gray);
        padding: 1rem;
        border-radius: 10px;
        text-align: center;
        font-weight: 500;
        transition: all 0.3s;
    }

    .area-tag:hover {
        background: var(--accent-purple);
        color: white;
        transform: translateY(-2px);
    }



    /* Responsive */
    @media (max-width: 968px) {
        .hero-content {
            grid-template-columns: 1fr;
        }

        .hero-text h1 {
            font-size: 2.5rem;
        }

        .truck-grid,
        .process-steps,
        .pricing-grid {
            grid-template-columns: 1fr;
        }

        .use-case-grid {
            grid-template-columns: 1fr;
        }

        .trust-items {
            grid-template-columns: repeat(2, 1fr);
        }

        .areas-grid {
            grid-template-columns: repeat(2, 1fr);
        }


    }

    @media (max-width: 640px) {
        .hero-text h1 {
            font-size: 2rem;
        }

        .cta-group {
            flex-direction: column;
        }

        .hero-stats {
            grid-template-columns: 1fr;
        }
    }
</style>


<!-- Hero Section -->
<section class="hero">
    <div class="container hero-content">
        <div class="hero-text">
            <h1>Boka <span class="highlight">Food Truck</span> i Stockholm</h1>
            <p>Från gourmetburgare till vegansk streetfood – hitta den perfekta food trucken för ditt event,
                företagslunch eller privata fest. Över 50 verifierade food trucks, enkel bokning och leverans samma dag
                möjlig.</p>

            <div class="cta-group">
                <a href="#trucks" class="btn-primary">Se Våra Food Trucks</a>
                <a href="#priser" class="btn-secondary">Se Priser</a>
            </div>

            <div class="hero-stats">
                <div class="stat">
                    <span class="stat-number">50+</span>
                    <span class="stat-label">Food Trucks</span>
                </div>
                <div class="stat">
                    <span class="stat-number">4.8★</span>
                    <span class="stat-label">Genomsnittligt Betyg</span>
                </div>
                <div class="stat">
                    <span class="stat-number">2500+</span>
                    <span class="stat-label">Nöjda Kunder</span>
                </div>
            </div>
        </div>

        <div class="hero-image">
            <img src="https://images.unsplash.com/photo-1565123409695-7b5ef63a2efb?w=800&h=600&fit=crop&q=80"
                alt="Food truck i Stockholm serverar mat vid företagsevent">
        </div>
    </div>
</section>

<!-- Trust Bar -->
<section class="trust-bar">
    <div class="container trust-items">
        <div class="trust-item">
            <div class="trust-icon">✓</div>
            <div class="trust-text">Verifierade Leverantörer</div>
        </div>
        <div class="trust-item">
            <div class="trust-icon">⚡</div>
            <div class="trust-text">Snabb Bokning</div>
        </div>
        <div class="trust-item">
            <div class="trust-icon">💳</div>
            <div class="trust-text">Säker Betalning</div>
        </div>
        <div class="trust-item">
            <div class="trust-icon">🎯</div>
            <div class="trust-text">Garanterad Leverans</div>
        </div>
    </div>
</section>

<!-- Main Content: Why Choose Food Truck -->
<section class="section">
    <div class="container section-content">
        <h2>Varför Välja Food Truck för Ditt Event?</h2>
        <p>Food trucks har blivit den mest populära cateringlösningen i Stockholm för både företag och privatpersoner.
            Med en food truck får du inte bara fantastisk mat – du skapar en unik upplevelse som dina gäster kommer att
            minnas.</p>

        <p>Våra food trucks erbjuder professionell catering med en avslappnad och rolig atmosfär. Perfekt för allt från
            företagsluncher och kickoffer till bröllop, festivaler och privata fester. Mat tillagas färskt på plats
            vilket ger både autenticitet och kvalitet.</p>

        <h3>Fördelar med Food Truck Catering</h3>
        <p>Till skillnad från traditionell catering erbjuder food trucks en interaktiv upplevelse där gästerna kan se
            maten tillagas och välja precis vad de vill ha. Det skapar en mer avslappnad och social atmosfär som
            fungerar perfekt för både formella och informella evenemang.</p>
    </div>
</section>

<!-- Featured Food Trucks -->
<section class="section" id="trucks" style="background: var(--light-gray);">
    <div class="container section-content">
        <h2>Populära Food Trucks i Stockholm</h2>
        <p>Bläddra bland våra mest bokade food trucks. Alla leverantörer är noggrant utvalda och verifierade för att
            garantera högsta kvalitet.</p>

        <div class="truck-grid">
            <div class="truck-card">
                <div class="truck-image"
                    style="background-image: url('https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=400&h=300&fit=crop&q=80')">
                </div>
                <div class="truck-info">
                    <div class="truck-cuisine">Gourmet Burgers</div>
                    <div class="truck-name">Street Gourmet Truck</div>
                    <div class="truck-description">Saftigaste burgarna i Stockholm med ekologiskt kött och hemlagade
                        såser</div>
                    <div class="truck-rating">
                        <span class="stars">★★★★★</span>
                        <span class="rating-count">4.9 (127 recensioner)</span>
                    </div>
                    <div class="truck-price">Från 195 kr/person</div>
                </div>
            </div>

            <div class="truck-card">
                <div class="truck-image"
                    style="background-image: url('https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=400&h=300&fit=crop&q=80')">
                </div>
                <div class="truck-info">
                    <div class="truck-cuisine">Italienskt</div>
                    <div class="truck-name">La Strada Mobile</div>
                    <div class="truck-description">Autentisk italiensk pizza från stenugn på hjul</div>
                    <div class="truck-rating">
                        <span class="stars">★★★★★</span>
                        <span class="rating-count">4.8 (93 recensioner)</span>
                    </div>
                    <div class="truck-price">Från 165 kr/person</div>
                </div>
            </div>

            <div class="truck-card">
                <div class="truck-image"
                    style="background-image: url('https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?w=400&h=300&fit=crop&q=80')">
                </div>
                <div class="truck-info">
                    <div class="truck-cuisine">Vegansk Street Food</div>
                    <div class="truck-name">Green Wagon</div>
                    <div class="truck-description">100% växtbaserad gourmet som får även köttätare att förälska sig
                    </div>
                    <div class="truck-rating">
                        <span class="stars">★★★★★</span>
                        <span class="rating-count">5.0 (64 recensioner)</span>
                    </div>
                    <div class="truck-price">Från 175 kr/person</div>
                </div>
            </div>

            <div class="truck-card">
                <div class="truck-image"
                    style="background-image: url('https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=400&h=300&fit=crop&q=80')">
                </div>
                <div class="truck-info">
                    <div class="truck-cuisine">American BBQ</div>
                    <div class="truck-name">BBQ Masters Stockholm</div>
                    <div class="truck-description">Slowcooked BBQ med hemmarökt kött och Texas-stil</div>
                    <div class="truck-rating">
                        <span class="stars">★★★★★</span>
                        <span class="rating-count">4.7 (156 recensioner)</span>
                    </div>
                    <div class="truck-price">Från 215 kr/person</div>
                </div>
            </div>

            <div class="truck-card">
                <div class="truck-image"
                    style="background-image: url('https://images.unsplash.com/photo-1562059392-096320bccc7e?w=400&h=300&fit=crop&q=80')">
                </div>
                <div class="truck-info">
                    <div class="truck-cuisine">Asiatisk Fusion</div>
                    <div class="truck-name">Wok On Wheels</div>
                    <div class="truck-description">Färsk wok och dumplings med asiatiska smaker</div>
                    <div class="truck-rating">
                        <span class="stars">★★★★★</span>
                        <span class="rating-count">4.9 (89 recensioner)</span>
                    </div>
                    <div class="truck-price">Från 185 kr/person</div>
                </div>
            </div>

            <div class="truck-card">
                <div class="truck-image"
                    style="background-image: url('https://images.unsplash.com/photo-1599974179-c0c74a2b0c5b?w=400&h=300&fit=crop&q=80')">
                </div>
                <div class="truck-info">
                    <div class="truck-cuisine">Mexikanskt</div>
                    <div class="truck-name">Taco Nomad</div>
                    <div class="truck-description">Autentiska tacos och burritos med färska ingredienser</div>
                    <div class="truck-rating">
                        <span class="stars">★★★★★</span>
                        <span class="rating-count">4.8 (112 recensioner)</span>
                    </div>
                    <div class="truck-price">Från 155 kr/person</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How to Book -->
<section class="section">
    <div class="container section-content">
        <h2>Så Här Bokar Du en Food Truck i 3 Enkla Steg</h2>
        <div class="process-steps">
            <div class="step">
                <div class="step-number">1</div>
                <h4>Välj Food Truck</h4>
                <p>Bläddra bland våra verifierade food trucks och välj den som passar ditt event och din budget perfekt
                </p>
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <h4>Fyll i Detaljer</h4>
                <p>Ange datum, plats, antal gäster och eventuella specialönskemål. Vi hjälper dig hitta rätt meny</p>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <h4>Bekräfta & Njut</h4>
                <p>Vi bekräftar din bokning inom 24 timmar. Food trucken kommer i tid och serverar fantastisk mat</p>
            </div>
        </div>
    </div>
</section>

<!-- Use Cases -->
<section class="section use-cases">
    <div class="container section-content">
        <h2>Perfekt för Dessa Tillfällen</h2>
        <div class="use-case-grid">
            <div class="use-case">
                <h4>🏢 Företagsevent & Kontor</h4>
                <ul>
                    <li>Företagslunch för anställda</li>
                    <li>Kickoffer och teambuilding</li>
                    <li>Konferenser och mässor</li>
                    <li>After work och mingel</li>
                    <li>Invigningar och öppethus</li>
                </ul>
            </div>

            <div class="use-case">
                <h4>🎉 Privata Fester</h4>
                <ul>
                    <li>Bröllop och förlovningar</li>
                    <li>Födelsedagsfester</li>
                    <li>Studentfester</li>
                    <li>Dop och namngivningar</li>
                    <li>Jubileum och minnesstunder</li>
                </ul>
            </div>

            <div class="use-case">
                <h4>🎪 Evenemang & Festival</h4>
                <ul>
                    <li>Stadsfestivaler och marknader</li>
                    <li>Sportevents och tävlingar</li>
                    <li>Musikfestivaler och konserter</li>
                    <li>Midsommarfirande</li>
                    <li>Julmarknader</li>
                </ul>
            </div>

            <div class="use-case">
                <h4>🏗️ Byggarbetsplatser</h4>
                <ul>
                    <li>Daglig lunch för arbetslag</li>
                    <li>Byggprojekt och renoveringar</li>
                    <li>Mättande portioner för hårt arbete</li>
                    <li>Punktlig leverans till platsen</li>
                    <li>Volymrabatter för stora crew</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Pricing -->
<section class="section pricing-section" id="priser">
    <div class="container section-content">
        <h2>Transparent Prissättning</h2>
        <p>Inga dolda avgifter. Du betalar endast för maten och eventuell körtid. Priserna nedan är vägledande.</p>

        <div class="pricing-grid">
            <div class="pricing-card">
                <h4>Litet Event</h4>
                <div class="price">2 500 kr</div>
                <div class="price-detail">10-30 personer</div>
                <ul class="pricing-features">
                    <li>1 Food Truck</li>
                    <li>Grundmeny</li>
                    <li>2-3 timmar servering</li>
                    <li>Standardleverans Stockholm</li>
                </ul>
                <a href="#boka" class="btn-secondary">Boka Nu</a>
            </div>

            <div class="pricing-card featured">
                <h4>Mellanstor Event</h4>
                <div class="price">5 500 kr</div>
                <div class="price-detail">30-80 personer</div>
                <ul class="pricing-features">
                    <li>1-2 Food Trucks</li>
                    <li>Utökad meny</li>
                    <li>3-4 timmar servering</li>
                    <li>Hela Stockholmsområdet</li>
                    <li>Vegetariska alternativ</li>
                </ul>
                <a href="#boka" class="btn-white">Populärast</a>
            </div>

            <div class="pricing-card">
                <h4>Stor Event</h4>
                <div class="price">12 000+ kr</div>
                <div class="price-detail">80+ personer</div>
                <ul class="pricing-features">
                    <li>2+ Food Trucks</li>
                    <li>Premium meny</li>
                    <li>4+ timmar servering</li>
                    <li>Dedikerad eventkoordinator</li>
                    <li>Alla dietpreferenser</li>
                    <li>Flexibel setup</li>
                </ul>
                <a href="#boka" class="btn-secondary">Kontakta Oss</a>
            </div>
        </div>

        <p style="text-align: center; margin-top: 2rem; font-size: 0.95rem;">* Priserna är vägledande och varierar
            beroende på meny, dag och plats. Kontakta oss för exakt offert.</p>
    </div>
</section>

<!-- FAQ Section -->
<section class="section faq-section">
    <div class="container section-content">
        <h2>Vanliga Frågor om Food Truck Bokning</h2>

        <div class="faq-list">
            <div class="faq-item">
                <div class="faq-question">
                    Hur bokar jag en food truck i Stockholm?
                    <span>▼</span>
                </div>
                <div class="faq-answer">
                    Att boka en food truck i Stockholm är enkelt med Catergo. Välj din önskade food truck från vårt
                    urval, fyll i datum, plats och antal gäster. Välj meny och eventuella specialönskemål. Vi bekräftar
                    din bokning inom 24 timmar och food trucken kommer i tid till ditt event.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    Vad kostar det att boka en food truck?
                    <span>▼</span>
                </div>
                <div class="faq-answer">
                    Priserna för food trucks i Stockholm börjar från 2500 kr för mindre event och varierar beroende på
                    antal gäster, meny och evenemangslängd. Genomsnittligt pris ligger på 150-250 kr per person. Vi
                    erbjuder alltid transparent prissättning utan dolda avgifter. Kontakta oss för en exakt offert
                    baserad på dina behov.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    Hur långt i förväg måste jag boka?
                    <span>▼</span>
                </div>
                <div class="faq-answer">
                    Vi rekommenderar att boka minst 2 veckor i förväg för att säkra din önskade food truck. För större
                    evenemang eller bokningar under högsäsong (maj-september) bör du boka 1-2 månader i förväg. Sista
                    minuten-bokningar kan ibland arrangeras beroende på tillgänglighet.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    Vilka områden i Stockholm levererar ni till?
                    <span>▼</span>
                </div>
                <div class="faq-answer">
                    Vi levererar food trucks till hela Stockholmsområdet inklusive: Södermalm, Östermalm, Vasastan,
                    Kungsholmen, Norrmalm, Bromma, Lidingö, Solna, Sundbyberg, Nacka, Huddinge och Täby. För platser
                    utanför Stockholm stad kan en liten transportavgift tillkomma.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    Kan food trucken hantera specialdieter?
                    <span>▼</span>
                </div>
                <div class="faq-answer">
                    Ja! Alla våra food trucks kan anpassa menyer för olika dietbehov inklusive vegetariskt, veganskt,
                    glutenfritt, laktosfritt, halal och kosher. Meddela oss i förväg om några gäster har allergier eller
                    speciella dietkrav så ser vi till att alla får fantastisk mat.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    Vad händer om vädret blir dåligt?
                    <span>▼</span>
                </div>
                <div class="faq-answer">
                    Food trucks fungerar i alla väder! De flesta har tält eller överhäng där gäster kan stå skyddade.
                    Vid extremt väder kan vi hjälpa dig hitta en alternativ lösning. Du kan alltid avboka upp till 7
                    dagar innan eventet utan kostnad vid dokumenterat oväder.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    Behöver food trucken tillgång till el och vatten?
                    <span>▼</span>
                </div>
                <div class="faq-answer">
                    De flesta food trucks är självförsörjande med egen generator och vattentank. För längre event (4+
                    timmar) uppskattas tillgång till el (230V, 16A) och vatten. Vi meddelar specifika krav när du bokar
                    beroende på vilken food truck du väljer.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    Kan jag boka flera food trucks samtidigt?
                    <span>▼</span>
                </div>
                <div class="faq-answer">
                    Absolut! För större event eller om du vill erbjuda variation rekommenderar vi att boka 2-3 olika
                    food trucks med olika kök. Detta är populärt för företagsevent, festivaler och bröllop. Vi hjälper
                    dig komponera det perfekta food truck-upplägget för ditt event.
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Areas Served -->
<section class="section areas-section">
    <div class="container section-content">
        <h2>Vi Levererar Food Trucks Till Hela Stockholm</h2>
        <p>Oavsett var i Stockholmsområdet ditt event är, kan vi leverera fantastiska food trucks till din plats.</p>

        <div class="areas-grid">
            <div class="area-tag">Södermalm</div>
            <div class="area-tag">Östermalm</div>
            <div class="area-tag">Vasastan</div>
            <div class="area-tag">Kungsholmen</div>
            <div class="area-tag">Norrmalm</div>
            <div class="area-tag">Bromma</div>
            <div class="area-tag">Lidingö</div>
            <div class="area-tag">Solna</div>
            <div class="area-tag">Sundbyberg</div>
            <div class="area-tag">Nacka</div>
            <div class="area-tag">Huddinge</div>
            <div class="area-tag">Täby</div>
            <div class="area-tag">Danderyd</div>
            <div class="area-tag">Sollentuna</div>
            <div class="area-tag">Järfälla</div>
            <div class="area-tag">Upplands Väsby</div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section" id="boka">
    <h2>Redo att Boka Din Food Truck?</h2>
    <p>Hitta den perfekta food trucken för ditt nästa event i Stockholm. Enkel bokning, transparenta priser och
        garanterad kvalitet.</p>
    <a href="#trucks" class="btn-white">Boka Food Truck Nu</a>
    <p style="margin-top: 2rem; font-size: 1rem; opacity: 0.9;">Eller ring oss på 08-XXX XXX XX för personlig rådgivning
    </p>
</section>

<?php get_footer(); ?>
<script>
    // FAQ Accordion
    document.querySelectorAll('.faq-question').forEach(question => {
        question.addEventListener('click', function () {
            const answer = this.nextElementSibling;
            const isOpen = answer.style.display === 'block';

            // Close all answers
            document.querySelectorAll('.faq-answer').forEach(a => a.style.display = 'none');

            // Toggle current answer
            answer.style.display = isOpen ? 'none' : 'block';
        });
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>