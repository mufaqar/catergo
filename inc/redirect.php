<?php
/**
 * ROOT location taxonomy + caterer URL by location
 * - Location term archive: /{location}/
 * - Caterer single: /{location}/caterer/{caterer}/
 *
 * IMPORTANT:
 * 1) DO NOT create Pages with the same slug as any location term.
 * 2) After adding this, flush permalinks (Settings -> Permalinks -> Save).
 */

/**
 * 1) CPT caterer (stable base)
 */
add_action('init', function () {
    register_post_type("caterer", [
        "label"              => "Caterers",
        "public"             => true,
        "publicly_queryable" => true,
        "show_ui"            => true,
        "show_in_rest"       => true,
        "has_archive"        => false,
        "supports"           => ["title", "editor", "thumbnail"],
        "rewrite"            => ["slug" => "caterer", "with_front" => false],
    ]);
}, 0);

/**
 * 2) Taxonomy location at ROOT: /stockholm/
 *
 * We set a normal internal rewrite base (location) BUT output root links
 * and add our own root rewrite rule.
 */
add_action('init', function () {
    register_taxonomy("location", ["caterer"], [
        "label"              => "Locations",
        "public"             => true,
        "publicly_queryable" => true,
        "hierarchical"       => true,
        "show_ui"            => true,
        "show_in_rest"       => true,

        // Keep an internal base to avoid WP edge-cases,
        // we'll override the *public* links to root below.
        "rewrite" => ["slug" => "location", "with_front" => false],
    ]);
}, 0);

/**
 * 3) Make location term links ROOT:
 * /location/stockholm/  ->  /stockholm/
 */
add_filter('term_link', function ($url, $term, $taxonomy) {
    if ($taxonomy !== 'location') return $url;

    // root URL for the term
    return home_url('/' . $term->slug . '/');
}, 10, 3);

/**
 * 4) Root rewrite for location term archives:
 * /{location}/  -> taxonomy=location&term={location}
 *
 * NOTE: This can collide with Pages. Avoid same slugs.
 */
add_action('init', function () {
    add_rewrite_rule(
        '^([^/]+)/?$',
        'index.php?location=$matches[1]',
        'bottom'
    );
}, 20);

/**
 * 5) Caterer single URLs:
 * /{location}/caterer/{caterer}/
 */
add_filter('post_type_link', function ($permalink, $post) {
    if ($post->post_type !== 'caterer') return $permalink;

    $terms = wp_get_post_terms($post->ID, 'location');
    $location_slug = (!empty($terms) && !is_wp_error($terms)) ? $terms[0]->slug : 'location';

    return home_url("/{$location_slug}/caterer/{$post->post_name}/");
}, 10, 2);

add_action('init', function () {
    add_rewrite_rule(
        '^([^/]+)/caterer/([^/]+)/?$',
        'index.php?post_type=caterer&name=$matches[2]',
        'top'
    );
}, 20);

/**
 * 6) IMPORTANT: Flush permalinks once
 * Recommended: WP Admin -> Settings -> Permalinks -> Save
 *
 * If you can't access admin, set to true for ONE request, load once, then set false.
 */
define('GT_FLUSH_REWRITES_ONCE', false);

add_action('init', function () {
    if (defined('GT_FLUSH_REWRITES_ONCE') && GT_FLUSH_REWRITES_ONCE) {
        flush_rewrite_rules(false);
    }
}, 99);


