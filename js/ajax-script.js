jQuery(document).ready(function($) {
    console.log('AJAX script loaded');
    console.log('ajax_object:', ajax_object);
    
    // Wait 1.5 seconds before loading content (after hero animations)
    setTimeout(function() {
        loadContent();
    }, 1500);
    
    return; // Exit here, the actual loading happens in loadContent()
        
    function loadContent() {
        // Load both parts in PARALLEL
        function loadPart1() {
        return $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'load_landing_part1',
                nonce: ajax_object.nonce
            },
            success: function(response) {
                console.log('Part 1 loaded successfully');
            },
            error: function(xhr, status, error) {
                console.error('Part 1 error:', error, xhr.responseText);
            }
        });
    }
    
    function loadPart2() {
        return $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'load_landing_part2',
                nonce: ajax_object.nonce
            },
            success: function(response) {
                console.log('Part 2 loaded successfully');
            },
            error: function(xhr, status, error) {
                console.error('Part 2 error:', error, xhr.responseText);
            }
        });
    }
    
    // Load both parts simultaneously
    $.when(loadPart1(), loadPart2()).done(function(response1, response2) {
        // response1[0] contains the HTML from part1
        // response2[0] contains the HTML from part2
        $('#ajax-content-container').html(response1[0] + response2[0]);
        console.log('Both parts loaded and inserted');
    }).fail(function() {
        console.error('One or both AJAX requests failed');
        $('#ajax-content-container').html('<p>Error loading content. Please refresh the page.</p>');
    });
    }
});