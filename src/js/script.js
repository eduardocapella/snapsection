jQuery(document).ready(function($) {
    
    // get JSON url
    // var WpJsonUrl = document.querySelector( 'link[rel="https://api.w.org/"]' ).href;
    // then take out the '/wp-json/' part
    // var homeurl = WpJsonUrl.replace( '/wp-json/','' );
    
    // got this information from the localize_script function in the enqueue_scripts file
    var homeurl = window.cwssData.homeUrl;

    var homeLocation = window.location.href;
    // console.log( 'AQUI! ' + homeLocation );

    // find every <h3> element within the page
    $headings = $( 'body' ).find( 'h3' );  
    // console.log('$headings', $headings);

    // remove any IDs in the URL
    $url = $(location).attr( 'href').split('#')[0];

    $headings.each(function(i) {
        // console.log('i', i);
        // check if <h3> already has an ID.
        // if doesn't, create one from its content
        // remember that var or let declares a variable
        let $slug = $(this).attr( 'id' );

        // if ( ! $slug ) {
        //     let $title = $(this).text();
        //     $slug = slugify( $title );
        //     $(this).attr( 'id', $slug );
        // }

        // text to be copied is the URL with the string added after it
        let $copyText = $url + '#' + $slug;

        // create the copy URL button within the <h3> heading
        $(this).append( '<button class="cwpl-h3-link-icon"><img src="' + homeurl + '/wp-content/plugins/snap-section/includes/img/cwpl-copy-url-link.svg"></button>' );

        // copy the text when clicked
        $(this).click(function(e) {
            navigator.clipboard.writeText( $copyText );
        })
    });

    function slugify( $stringToSlugify ) {

        $title_slugfied = $stringToSlugify.toLowerCase();

        const from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
        const to   = "aaaaaeeeeeiiiiooooouuuunc------";
        for (let i = 0, l = from.length; i < l; i++) {
            $title_slugfied = $title_slugfied.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
        }

        $title_slugfied = $title_slugfied.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                .replace(/\s+/g, '-') // collapse whitespace and replace by -
                .replace(/-+/g, '-'); // collapse dashes

        return $title_slugfied;
    }

});