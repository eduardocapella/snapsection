<?php 



// add_filter( 'the_content', __NAMESPACE__ . '\add_id_to_h3' );

// function add_id_to_h3( $content ) {
//     $dom = new \DOMDocument();
//     @$dom->loadHTML( mb_convert_encoding( $content, 'HTML-ENTITIES', 'UTF-8' ) );
//     $h3s = $dom->getElementsByTagName( 'h3' );

//     foreach ( $h3s as $h3 ) {
//         if ( $h3->hasAttribute( 'id' ) ) {
//             continue;
//         } else {
//             $h3Text = $h3->nodeValue;
//             $h3Text = sanitize_title( $h3Text );
//             $h3->setAttribute( 'id', $h3Text );
//         }
//     }

//     $html = $dom->saveHTML();
//     return $html;
// }




