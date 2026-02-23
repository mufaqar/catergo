<?php /* Template Name: Location Archive */ get_header(); 

$term = get_queried_object();
$term_title = $term->post_title;
$term_slug = $term->post_name;





// $term = get_queried_object();

// // echo $term->term_id;
// // echo $term->name;
//  //echo $term->slug;
// //echo $term->taxonomy;

 //print_r($term);






?>

<!-- Hero -->
<header class="hero">
    <div class="container position-relative" style="z-index:1;">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="reveal">
                    <h1 class="font-display fw-black text-deep display-4 lh-sm mb-3" style="font-weight:900;">
                        <?php echo $term_title; ?><br />
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

            <?php 

        // Your query (edit as needed)
            $args = [
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => 4,
            'orderby'        => 'date',
            'order'          => 'DESC',

            // Optional: filter by category slug:
            // 'tax_query' => [[
            //   'taxonomy' => 'product_cat',
            //   'field'    => 'slug',
            //   'terms'    => ['food-trucks'],
            // ]],
            ];

            $q = new WP_Query($args);
            ?>
             <?php if ($q->have_posts()) : ?>
      <?php while ($q->have_posts()) : $q->the_post(); ?>
        <?php
          global $product;
          if ( ! $product instanceof WC_Product ) continue;

          $id    = $product->get_id();
          $title = get_the_title();
          $url   = get_permalink();

          $img = get_the_post_thumbnail_url($id, 'large');
          if (!$img) $img = wc_placeholder_img_src('large');

          // Example “meta line”: use first category name (replace with city field if you have one)
          $terms = get_the_terms($id, 'product_cat');
          $metaLine = (!is_wp_error($terms) && !empty($terms)) ? $terms[0]->name : 'Product';

          $avg   = (float) $product->get_average_rating();
          $count = (int) $product->get_rating_count();

          $filled = (int) round($avg);
          $stars  = str_repeat('★', $filled) . str_repeat('☆', max(0, 5 - $filled));
        ?>


            <div class="col-sm-6 col-lg-3 reveal">
          <a href="<?php echo esc_url($url); ?>" class="card supplier-card h-100 text-decoration-none">
            <div class="supplier-img"
                 style="background-image:url('<?php echo esc_url($img); ?>');">
            </div>

            <div class="card-body p-4">
              <div class="fw-bold text-deep mb-1"><?php echo esc_html($title); ?></div>
              <div class="text-muted small mb-3"><?php echo esc_html($metaLine); ?></div>

              <div class="d-flex align-items-center gap-2 fw-semibold" style="color:var(--accent);">
                <span aria-hidden="true"><?php echo esc_html($count ? $stars : '☆☆☆☆☆'); ?></span>
                <span class="text-muted fw-normal">
                  <?php echo $count ? esc_html(number_format($avg, 1) . " ({$count} reviews)") : esc_html('No reviews yet'); ?>
                </span>
              </div>
            </div>
          </a>
        </div>
            <?php endwhile; wp_reset_postdata(); ?>
            <?php else: ?>
            <p>No products found.</p>
            <?php endif; ?>



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

<?php get_footer(); ?>