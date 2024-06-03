jQuery(document).ready(function($) {
        
    // got this information from the localize_script function in the enqueue_scripts file
    let homeUrl = window.cwssData.homeUrl;
    let currentUrl = window.cwssData.currentUrl;
    // let iconColor = window.cwssData.iconColor;
    
    var hash = window.location.hash;

    let iconSvg = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="auto" height="85%" viewBox="0 0 1024 1024"><path fill="#000" d="M904.829 252.63l-147.363 255.233c-23.283 40.251-74.734 54.061-115.028 30.778l-36.42-21.052 42.104-72.882c20.126 11.579 45.893 4.716 57.472-15.41l105.26-182.309c11.621-20.168 4.716-45.893-15.368-57.514l-145.89-84.208c-20.168-11.621-45.893-4.716-57.472 15.41l-105.26 182.309c-11.663 20.168-4.758 45.893 15.368 57.514l-42.104 72.882-36.42-21.052c-40.293-23.241-54.103-74.734-30.82-114.985l147.363-255.233c23.283-40.293 74.734-54.061 115.028-30.82l218.729 126.311c40.293 23.241 54.103 74.734 30.82 115.028zM406.74 694.298c-20.168-11.621-27.073-37.388-15.41-57.514l168.415-291.695c11.621-20.168 37.388-27.073 57.514-15.41s27.073 37.388 15.368 57.514l-168.415 291.695c-11.579 20.126-37.304 26.989-57.472 15.41zM375.92 579.313v0c-20.168-11.621-45.893-4.716-57.514 15.368l-105.26 182.309c-11.621 20.168-4.716 45.893 15.41 57.514l145.89 84.208c20.126 11.621 45.893 4.716 57.472-15.41l105.26-182.309c11.621-20.126 4.716-45.893-15.368-57.514v0l42.104-72.882 36.42 21.052c40.293 23.241 54.103 74.692 30.82 114.985l-147.363 255.233c-23.283 40.293-74.734 54.061-115.028 30.82l-218.771-126.311c-40.293-23.283-54.103-74.734-30.82-115.028l147.363-255.233c23.283-40.293 74.776-54.103 115.070-30.82l36.42 21.052-42.104 72.966z"></path></svg>';


    // find every <h3> element within the page
    $headings = $( 'body' ).find( 'h3' );  
    // console.log('$headings', $headings);

    $headings.each(function(i) {
        // console.log('i', i);
        // check if <h3> already has an ID.
        // if doesn't, create one from its content
        // remember that var or let declares a variable
        let $slug = $(this).attr( 'id' );
        $(this).addClass( 'cwss-h3');

        if ( ! $slug ) {
            let $title = $(this).text();
            $slug = slugify( $title );
            $(this).attr( 'id', $slug );
        }

        // text to be copied is the URL with the string added after it
        let $copyText = currentUrl + '#' + $slug;

        // create a wrapper for the <h3> content
        $(this).wrapInner( '<div class="cwss-h3-wrapper"></div>');

        // create the copy URL button within the <h3> heading
        $(this).find('.cwss-h3-wrapper').append( `<button class="cwss-h3-link-icon">${iconSvg}</button>` );

        // set the width of the button to the height of the <h3> container
        let h3ContainerHeight = $(this).find('.cwss-h3-wrapper').height();
        console.log('h3ContainerHeight', h3ContainerHeight);

        // set the width of the button to the height of the <h3> container
        $(this).find('.cwss-h3-link-icon').css({
            'width': h3ContainerHeight,
        });

        // copy the text when clicked
        $(this).click(function(e) {
            navigator.clipboard.writeText( $copyText );
            console.log( 'Copied: ' + $copyText );
        })
    });

    // if there is a hash in the URL, find the element and scroll to it
    if ( hash ) {
        let element = document.getElementById( hash.substring(1) );
        console.log( 'element', element );
        if ( element ) {
            let pt = window.getComputedStyle( element ).getPropertyValue( 'padding-top' );
            console.log( 'pt', pt );
            
            // check if the element has padding-top
            if (pt==0) {
                element.scrollIntoView();
            } else {
                let offset = $(element).offset().top;
                console.log( 'offset', offset );
                let scroll = offset - 32;
                console.log( 'scroll', scroll );
                $('html, body').animate({
                    scrollTop: scroll
                }, 300);
            
            }
        }
    }


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