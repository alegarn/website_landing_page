jQuery(document).ready(function($) {
    // Load part1 immediately
    $.ajax({
        url: ajax_object.ajax_url,
        type: 'POST',
        data: {
            action: 'load_landing_part1',
            nonce: ajax_object.nonce
        },
        success: function(response) {
            $('#ajax-content-container').append(response);
            
            // Load part2 after part1 is loaded
            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'load_landing_part2',
                    nonce: ajax_object.nonce
                },
                success: function(response) {
                    $('#ajax-content-container').append(response);
                }
            });
        }
    });
});
