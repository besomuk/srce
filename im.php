<?php
    $w = $_GET['w'];
    $h = $_GET['h'];
    $txt = $_GET['txt'];
    //$w = 100;
    $my_img = imagecreate( $w, $h );
    $background = imagecolorallocate( $my_img, 0, 0, 255 );
    $text_colour = imagecolorallocate( $my_img, 255, 255, 0 );
    $line_colour = imagecolorallocate( $my_img, 128, 255, 0 );
    imagestring( $my_img, 4, 30, 25, $txt, $text_colour );
    imagesetthickness ( $my_img, 5 );
    imageline( $my_img, 30, 45, 165, 45, $line_colour );

    header( "Content-type: image/png" );
    imagepng( $my_img );
    imagecolordeallocate( $line_color );
    imagecolordeallocate( $text_color );
    imagecolordeallocate( $background );
    imagedestroy( $my_img );
?>