jQuery(document).ready(function($) {
    
    // get JSON url
    var WpJsonUrl = document.querySelector( 'link[rel="https://api.w.org/"]' ).href;
    // then take out the '/wp-json/' part
    var homeurl = WpJsonUrl.replace( '/wp-json/','' );

    // find every <h3> element within the page
    $headings = $( 'body' ).find( 'h3' );

    // remove any IDs in the URL
    $url = $(location).attr( 'href').split('#')[0];

    $headings.each(function(i) {

        // check if <h3> already has an ID.
        // if doesn't, create one from its content
        if ( ! $(this).is('[id]') ) {
            let $title = $(this).text();
            var $slug = slugify( $title );
            $(this).attr( 'id', $slug );
        } else {
            var $slug = $(this).attr( 'id' );
        }

        // text to be copied is the URL with the string added after it
        let $copyText = $url + '#' + $slug;

        // create the copy URL button within the <h3> heading
        $(this).append( '<button class="cwpl-h3-link-icon"><img src="' + homeurl + '/wp-content/plugins/cw-plugin-learning/includes/img/cwpl-copy-url-link.svg"></button> ');

        // copy the text when clicked
        $(this).click(function(e) {
            navigator.clipboard.writeText( $copyText );
        })

    });


    

    function slugify( $stringToSlugify ) {

        $title_slugfied = $stringToSlugify.toLowerCase();

        var from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
        var to   = "aaaaaeeeeeiiiiooooouuuunc------";
        for (var i = 0, l = from.length; i < l; i++) {
            $title_slugfied = $title_slugfied.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
        }

        $title_slugfied = $title_slugfied.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                .replace(/\s+/g, '-') // collapse whitespace and replace by -
                .replace(/-+/g, '-'); // collapse dashes

        return( $title_slugfied );
    }


});