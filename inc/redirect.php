<?php
/**
 * CPT + Taxonomies + Location-based Caterer URLs
 * - Location term archive: /location/{location}/
 * - Caterer single: /{location}/caterer/{caterer}/
 * - Pages remain normal: /about-us/ uses page.php
 */

/**
 * 1) Register CPT: Caterer
 */
add_action('init', function () {
    $labels = [
        "name"          => esc_html__("Caterers", "gt_theme"),
        "singular_name" => esc_html__("Caterer", "gt_theme"),
    ];

    $args = [
        "label"               => esc_html__("Caterers", "gt_theme"),
        "labels"              => $labels,
        "public"              => true,
        "publicly_queryable"  => true,
        "show_ui"             => true,
        "show_in_rest"        => true,
        "has_archive"         => false,
        "show_in_menu"        => true,
        "show_in_nav_menus"   => true,
        "exclude_from_search" => false,
        "capability_type"     => "post",
        "map_meta_cap"        => true,
        "hierarchical"        => false,
        "supports"            => ["title", "editor", "thumbnail"],

        // IMPORTANT: keep CPT base stable
        "rewrite" => [
            "slug"       => "caterer",
            "with_front" => false,
        ],
    ];

    register_post_type("caterer", $args);
}, 0);


/**
 * 2) Register Taxonomy: Location (with a base, so Pages don't collide)
 * URL: /location/{term}/
 */
add_action('init', function () {
    register_taxonomy('location', ['caterer'], [
        'label'        => __('Locations', 'gt_theme'),
        'public'       => true,
        'hierarchical' => true,
        'show_ui'      => true,
        'show_in_rest' => true,
        'query_var'    => true,
        'rewrite'      => [
            'slug'       => 'location', // keep internal base stable
            'with_front' => false,
        ],
    ]);
}, 0);
/**
 * 3) Register Taxonomy: Caterer Types
 * URL: /caterer_types/{term}/
 */
add_action('init', function () {
    $labels = [
        "name"          => esc_html__("Types", "gt_theme"),
        "singular_name" => esc_html__("Type", "gt_theme"),
    ];

    $args = [
        "label"              => esc_html__("Types", "gt_theme"),
        "labels"             => $labels,
        "public"             => true,
        "publicly_queryable" => true,
        "hierarchical"       => true,
        "show_ui"            => true,
        "show_in_menu"       => true,
        "show_in_nav_menus"  => true,
        "query_var"          => true,
        "show_admin_column"  => true,
        "show_in_rest"       => true,
        "rewrite" => [
            "slug"       => "caterer_types",
            "with_front" => false,
        ],
    ];

    register_taxonomy("caterer_types", ["caterer"], $args);
}, 0);


/**
 * 4) Caterer single URL format:
 * /{location-slug}/caterer/{caterer-slug}/
 *
 * We do two things:
 *  - Generate links in that format (post_type_link)
 *  - Add a rewrite rule so WP resolves that URL to the caterer post (add_rewrite_rule)
 */

// Generate pretty permalinks for caterers
add_filter('post_type_link', function ($permalink, $post) {
    if ($post->post_type !== 'caterer') return $permalink;

    // Get first assigned location term (or fallback)
    $terms = wp_get_post_terms($post->ID, 'location');
    $location_slug = (!empty($terms) && !is_wp_error($terms)) ? $terms[0]->slug : 'location';

    // Build desired URL
    return home_url("/{$location_slug}/caterer/{$post->post_name}/");
}, 10, 2);

// Add rewrite rule for the custom caterer permalink
add_action('init', function () {
    add_rewrite_rule(
        '^([^/]+)/caterer/([^/]+)/?$',
        'index.php?post_type=caterer&name=$matches[2]',
        'top'
    );
}, 20);


/**
 * 5) OPTIONAL: One-time flush helper
 * After you paste code, go to Settings > Permalinks > Save Changes (recommended)
 * If you can't do that, set this to true for ONE reload, then set back to false.
 */
define('GT_FLUSH_REWRITES_ONCE', false);

add_action('init', function () {
    if (defined('GT_FLUSH_REWRITES_ONCE') && GT_FLUSH_REWRITES_ONCE) {
        flush_rewrite_rules(false);
    }
}, 99);

add_filter('term_link', function ($url, $term, $taxonomy) {
    if ($taxonomy !== 'location') return $url;
    return home_url('/' . $term->slug . '/'); // /stockholm/
}, 10, 3);


// Rewrite: /{slug}/ -> taxonomy=location&term={slug}
add_action('init', function () {
    add_rewrite_rule(
        '^([^/]+)/?$',
        'index.php?location=$matches[1]',
        'bottom'
    );
}, 20);

// Resolver: if WP thinks it's a page, convert to location term if term exists
add_filter('request', function ($qv) {
    if (!empty($qv['pagename']) && empty($qv['location'])) {
        $slug = trim($qv['pagename'], '/');

        // If a real Page exists, let Page win
        if (get_page_by_path($slug)) return $qv;

        // If location term exists, treat as taxonomy request
        if (term_exists($slug, 'location')) {
            unset($qv['pagename']);
            $qv['location'] = $slug;
        }
    }
    return $qv;
});

add_action('init', function () {
    if (!get_option('gt_location_root_flushed')) {
        flush_rewrite_rules(false);
        update_option('gt_location_root_flushed', 1);
    }
}, 99);