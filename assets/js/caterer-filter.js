jQuery(document).ready(function ($) {
    $(document).on('click', '.caterer-type-filter', function (e) {
        e.preventDefault();

        var termId = $(this).data('term-id');

        $('.caterer-type-filter').removeClass('active');
        $(this).addClass('active');

        $('#caterers-results').html('<p class="text-center">Loading...</p>');

        $.ajax({
            url: caterer_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'filter_caterers_by_type',
                nonce: caterer_ajax.nonce,
                term_id: termId,
                location: caterer_ajax.location
            },
            success: function (response) {
                $('#caterers-results').html(response);
            },
            error: function () {
                $('#caterers-results').html('<p class="text-danger text-center">Something went wrong.</p>');
            }
        });
    });
});



jQuery(document).ready(function ($) {

    $(document).on('click', '.caterer-type-filter', function (e) {
        e.preventDefault();

        var termId = $(this).data('term-id');

        $('.caterer-type-filter').removeClass('active');
        $(this).addClass('active');

        $('#caterers-results').html('<p class="text-center">Loading...</p>');

        $.ajax({
            url: caterer_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'filter_caterers_by_type',
                nonce: caterer_ajax.nonce,
                term_id: termId,
                location: caterer_ajax.location
            },
            success: function (response) {
                $('#caterers-results').html(response);
            },
            error: function () {
                $('#caterers-results').html('<p class="text-danger text-center">Something went wrong.</p>');
            }
        });
    });

    $(document).on('click', '.product-cat-filter', function (e) {
        e.preventDefault();

        var termId = $(this).data('term-id');
        alert('Clicked category with term ID: ' + termId); // Debugging alert

        $('.product-cat-filter').removeClass('active');
        $(this).addClass('active');

        $('#caterers-results').html('<p class="text-center">Loading...</p>');

        $.ajax({
            url: caterer_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'filter_caterers_by_product_cat',
                nonce: caterer_ajax.nonce,
                term_id: termId,
                location: caterer_ajax.location
            },
            success: function (response) {
                $('#caterers-results').html(response);
            },
            error: function () {
                $('#caterers-results').html('<p class="text-danger text-center">Something went wrong.</p>');
            }
        });
    });

});




// Filter caterers by product tag

jQuery(document).ready(function ($) {

    $(document).on('click', '.product-tag-filter', function (e) {
        e.preventDefault();

        var termId = $(this).data('term-id');

        $('.product-tag-filter').removeClass('active');
        $(this).addClass('active');

        $('#caterers-results').html('<p class="text-center">Loading...</p>');

        $.ajax({
            url: caterer_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'filter_caterers_by_product_tag',
                nonce: caterer_ajax.nonce,
                term_id: termId,
                location: caterer_ajax.location
            },
            success: function (response) {
                $('#caterers-results').html(response);
            },
            error: function () {
                $('#caterers-results').html('<p class="text-danger text-center">Something went wrong.</p>');
            }
        });
    });

});