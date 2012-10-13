jQuery(document).ready(function() {
        setTimeout(function(){
            jQuery( 'head' ).append( thehacked_timed_css_data.css_to_add );
        }, thehacked_timed_css_data.delay_time);
});