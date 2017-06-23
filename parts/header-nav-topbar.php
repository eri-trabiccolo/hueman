<?php
$mobile_menu_opt = hu_get_option( 'header_mobile_menu_layout' );
$topnav_classes = array(
    'nav-container',
    'group',
    'desktop-menu',
    'no_stick' != hu_normalize_stick_menu_opt( hu_get_option('header-desktop-sticky') ) ? 'desktop-sticky' : '',
    hu_has_nav_menu( 'topbar' ) ? '' : 'no-menu-assigned'
);
if ( is_multisite() ) {
    $fallback_cb = '';
} else {
    $fallback_cb = hu_is_checked( "default-menu-header" ) ? 'hu_page_menu' : '';
}
$fallback_cb     = apply_filters( 'hu_topbar_menu_fallback_cb', $fallback_cb );//set to 'hu_page_menu' on prevdem
$display_search  = ( 'topbar' == hu_get_option( 'desktop-search' ) ) && ( 'both_menus' == $mobile_menu_opt || ! wp_is_mobile() ) && ( hu_has_nav_menu( 'topbar' ) || ! empty( $fallback_cb ) );
$display_wc_cart = apply_filters( 'hu_wc_header_cart_enabled', false, ( 'topbar' == hu_get_option( 'desktop-wc-cart' ) ) && ( 'both_menus' == $mobile_menu_opt || ! wp_is_mobile() ) && ( hu_has_nav_menu( 'topbar' ) || ! empty( $fallback_cb ) ) );
?>
<nav class="<?php echo implode(' ', $topnav_classes ); ?>" id="nav-topbar" data-menu-id="<?php echo hu_get_menu_id( 'header'); ?>">
  <?php if ( 'both_menus' == $mobile_menu_opt ) { hu_print_mobile_btn(); } ?>
  <div class="nav-text"><?php apply_filters( 'hu_mobile_menu_text', '' );//put your mobile menu text here ?></div>
  <div class="topbar-toggle-down">
    <i class="fa fa-angle-double-down" aria-hidden="true" data-toggle="down" title="<?php _e('Expand menu', 'hueman' ); ?>"></i>
    <i class="fa fa-angle-double-up" aria-hidden="true" data-toggle="up" title="<?php _e('Collapse menu', 'hueman' ); ?>"></i>
  </div>
  <div class="nav-wrap container">
    <?php
      wp_nav_menu(
        array(
            'theme_location'  => 'topbar',
            'menu_class'      => 'nav container-inner group',
            'container'       => '',
            'menu_id'         => '',
            'fallback_cb'     => $fallback_cb
        )
      );
    ?>
  </div>
  <?php if ( $display_search || $display_wc_cart ) : ?>
    <div id="topbar-header-utils" class="container">
      <div class="container-inner">
        <ul class="topbar-header-utils-inner nav">
          <?php if ( $display_wc_cart ) : ?>
            <li class="topbar-wc-cart">
              <a class="hu-wc-cart" href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" title="<?php _e( 'View your shopping cart', 'hueman' ); ?>">
                <i class="fa fa-shopping-cart"></i>
                <span class="count btn-link hu-wc-count"><?php echo $_cart_count ? $_cart_count : '' ?></span>
              </a>
              <?php if ( apply_filters( 'hu_wc_display_widget_cart_in_header', true ) ) : ?>
              <ul class="sub-menu">
                <li>
                 <?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
                </li>
              </ul>
              <?php endif //widget_cart ?>
            </li>
          <?php endif; //wc-cart ?>
          <?php if ( $display_search ) : ?>
            <li class="topbar-search">
              <div class="toggle-search"><i class="fa fa-search"></i></div>
              <div class="search-expand">
                <div class="search-expand-inner"><?php get_search_form(); ?></div>
              </div>
            </li>
          <?php endif; //search ?>
        </ul><!--/.topbar-header-utils-inner-->
      </div><!--/.container-inner-->
    </div><!--/.container-->
  <?php endif; ?>
</nav><!--/#nav-topbar-->