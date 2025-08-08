<?php
    header ("Content-Type:text/css");
    $color = "#746EF1"; // Change your Color Here

    function checkhexcolor($color) {
        return preg_match('/^#[a-f0-9]{6}$/i', $color);
    }

    if( isset( $_GET[ 'color' ] ) AND $_GET[ 'color' ] != '' ) {
        $color = "#".$_GET[ 'color' ];
    }

    if( !$color OR !checkhexcolor( $color ) ) {
        $color = "#746EF1";
    }


    function hex2rgba( $color, $opacity) {

        if ($color[0] == '#') {
            $color = substr($color, 1);
        }
        if (strlen($color) == 6) {
            list($r, $g, $b) = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
        } elseif (strlen($color) == 3) {
            list($r, $g, $b) = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
        } else {
            return false;
        }
        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);
        $rgb = 'rgba('.$r. ',' .$g .',' .$b. ',' . $opacity.')';

        return $rgb;
    }

?>

.home-3 .navbar-area .nav-container .navbar-collapse .navbar-nav li:hover a,
.breadcrumb-area .page-list,
.blog-share-area ul li:hover a,
.widget_catagory ul li a:hover,
.blog-details-page-content .single-blog-inner .details .blog-meta li i, .blog-details-page-content .single-blog-inner .details .blog-meta li svg,
.text--base,
a:hover,
.navbar-top ul li a:hover,
.navbar-top ul li span, .navbar-top ul li i, .navbar-top ul li svg{
    color : <?php echo  $color ?> !important;
}

.home-3 .navbar-area .nav-container .navbar-collapse .navbar-nav li:hover a:after,
.home-3 .navbar-area .nav-container .navbar-collapse .navbar-nav li.menu-item-has-children .sub-menu li:hover,
.home-3 .navbar-area .nav-container .navbar-collapse .navbar-nav li:hover::before, .home-3 .navbar-area .nav-container .navbar-collapse .navbar-nav li:hover::after,
.footer-area-3 .single-subscribe-inner .btn,
.single-blog-inner-2 .details .read-more-text::after,
.back-to-top{
    background : <?php echo $color ?> !important;
}