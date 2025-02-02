<?php
	$data = c27()->merge_options([
			'logo'                    => c27()->get_site_logo(),
            'skin'                    => c27()->get_setting('header_skin', 'dark'),
            'style'                   => c27()->get_setting('header_style', 'default'),
			'fixed'                   => c27()->get_setting('header_fixed', true),
            'scroll_skin'             => c27()->get_setting('header_scroll_skin', 'dark'),
            'scroll_logo'             => c27()->get_setting('header_scroll_logo') ? c27()->get_setting('header_scroll_logo')['sizes']['medium'] : false,
			'border_color'            => c27()->get_setting('header_border_color', 'rgba(29, 29, 31, 0.95)'),
			'menu_location'           => c27()->get_setting('header_menu_location', 'right'),
			'background_color'        => c27()->get_setting('header_background_color', 'rgba(29, 29, 31, 0.95)'),
			'show_search_form'        => c27()->get_setting('header_show_search_form', true),
			'show_call_to_action'     => c27()->get_setting('header_show_call_to_action_button', false),
			'scroll_border_color'     => c27()->get_setting('header_scroll_border_color', 'rgba(29, 29, 31, 0.95)'),
			'search_form_placeholder' => c27()->get_setting('header_search_form_placeholder', 'Type your search...'),
			'scroll_background_color' => c27()->get_setting('header_scroll_background_color', 'rgba(29, 29, 31, 0.95)'),
			'blend_to_next_section'   => false,
            'is_edit_mode'            => false,
		], $data);

	$header_classes = ['c27-main-header', 'header', "header-style-{$data['style']}", "header-{$data['skin']}-skin", "header-scroll-{$data['scroll_skin']}-skin"];

	if ( $data['fixed'] ) {
		$header_classes[] = 'header-fixed';
	}

	if ( $data['menu_location'] == 'right' ) {
		$header_classes[] = 'header-menu-right';
	}

	$GLOBALS['case27_custom_styles'] .= '.c27-main-header .logo img { height: ' . c27()->get_setting( 'header_logo_height', 38 ) . 'px; }';

	if ($data['background_color']) {
		if (!isset($GLOBALS['case27_custom_styles'])) $GLOBALS['case27_custom_styles'] = '';

		$GLOBALS['case27_custom_styles'] .= '.c27-main-header:not(.header-scroll) .header-skin, ';
		$GLOBALS['case27_custom_styles'] .= '.c27-main-header:not(.header-scroll) .i-nav.mobile-menu-open';
		$GLOBALS['case27_custom_styles'] .= '{ background: ' . $data['background_color'] . ' !important; }';
	}

	if ($data['border_color']) {
		if (!isset($GLOBALS['case27_custom_styles'])) $GLOBALS['case27_custom_styles'] = '';

		$GLOBALS['case27_custom_styles'] .= '.c27-main-header:not(.header-scroll) .header-skin { border-bottom: 1px solid ' . $data['border_color'] . ' !important; } ';
	}

	if ($data['scroll_background_color']) {
		if (!isset($GLOBALS['case27_custom_styles'])) $GLOBALS['case27_custom_styles'] = '';

		$GLOBALS['case27_custom_styles'] .= '.c27-main-header.header-scroll .header-skin, .c27-main-header.header-scroll .i-nav.mobile-menu-open ';
		$GLOBALS['case27_custom_styles'] .= '{ background: ' . $data['scroll_background_color'] . ' !important; }';
	}

	if ($data['scroll_border_color']) {
		if (!isset($GLOBALS['case27_custom_styles'])) $GLOBALS['case27_custom_styles'] = '';

		$GLOBALS['case27_custom_styles'] .= '.c27-main-header.header-scroll .header-skin { border-bottom: 1px solid ' . $data['scroll_border_color'] . ' !important; } ';
	}
?>

<header class="<?php echo esc_attr( apply_filters('case27_header_classes', join( ' ', $header_classes ) ) ) ?>">
	<div class="header-skin"></div>
	<div class="header-container">
		<div class="header-top container-fluid">
			<div class="mobile-menu">
				<a href="#main-menu">
					<div>
						<div class="mobile-menu-lines">
							<i class="material-icons">menu</i>
						</div>
					</div>
				</a>
			</div>

			<div class="logo">
				<?php if ($data['logo']): ?>
					<?php if ($data['scroll_logo']): ?>
						<a href="<?php echo esc_url( home_url('/') ) ?>" class="scroll-logo">
							<?php
								$media_id = giang_get_image_id( $data['scroll_logo'] ); ;
								$alt = 'image';
								if($media_id) $alt = giang_get_media_alt( $media_id );
							?>
							<img src="<?php echo esc_url( $data['scroll_logo'] ) ?>"  alt="<?php echo $alt; ?>">
						</a>
					<?php endif ?>

					<a href="<?php echo esc_url( home_url('/') ) ?>" class="static-logo">
						<?php
							$media_id = giang_get_image_id( $data['logo'] ); ;
							$alt = 'image';
							if($media_id) $alt = giang_get_media_alt( $media_id );
						?>
						<img src="<?php echo esc_url( $data['logo'] ) ?>" alt="<?php echo $alt; ?>" >
					</a>
				<?php else: ?>
					<a href="<?php echo esc_url( home_url('/') ) ?>" class="header-logo-text">
						<?php echo esc_attr( get_bloginfo('sitename') ) ?>
					</a>
				<?php endif ?>
			</div>

			<div class="header-right">
				<?php if (is_user_logged_in()): $current_user = wp_get_current_user(); ?>
					<div class="user-area">
						<div class="user-profile-dropdown dropdown">
							<a class="user-profile-name" href="#" type="button" id="user-dropdown-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
								<div class="avatar">
									<img src="<?php echo esc_url( get_avatar_url( $current_user->ID ) ) ?>">
								</div>
								<?php echo esc_attr( $current_user->display_name ) ?>
								<?php if (class_exists('WooCommerce')): ?>
									<i class="material-icons">keyboard_arrow_down</i>
								<?php endif ?>
							</a>
							<?php if (class_exists('WooCommerce')): ?>
								<ul class="i-dropdown dropdown-menu" aria-labelledby="user-dropdown-menu">
									<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
										<?php do_action( "case27/user-menu/{$endpoint}/before" ) ?>
										<li class="user-menu-<?php echo esc_attr( $endpoint ) ?>">
											<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
										</li>
										<?php do_action( "case27/user-menu/{$endpoint}/after" ) ?>
									<?php endforeach; ?>
								</ul>
							<?php endif ?>
						</div>
					</div>
				<?php else: ?>
					<div class="user-area signin-area"> 
						<i class="material-icons user-area-icon">perm_identity</i> 
						<a href="<?php echo home_url('my-account'); ?>" ><?php _e( 'Sign in', 'my-listing' ) ?></a>
						<?php if (get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes'): ?>
							<span><?php _e( '|', 'my-listing' ) ?></span>
							<a href="<?php echo home_url('my-account'); ?>" ><?php _e( 'Register', 'my-listing' ) ?></a>
						<?php endif ?>
					</div>
					<div class="mob-sign-in">
						<a href="#" data-toggle="modal" data-target="#sign-in-modal"><i class="material-icons">perm_identity</i></a>
					</div>
				<?php endif ?>
				
				<?php  $languages = icl_get_languages('skip_missing=1');?>
			    <div class="language-selector desktop-language">
				<?php foreach($languages as $l){ 
					if($l['active']){ 
					?>
							<?php $active_url = $l['country_flag_url'];
							if($l['language_code']=="en"){
								$active_url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/english-selected.png';
							} elseif($l['language_code']=="fr"){
								$active_url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/french-selected.png';
							}elseif($l['language_code']=="de"){
								$active_url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/german-selected.png';
							}

							?>
							<span><img src="<?php echo $active_url;?>"></span>
				<?php } }?>
               <ul style="display: none;">
			   <?php foreach($languages as $l){ ?>
				<?php $url = $l['country_flag_url'];
							if($l['language_code']=="en"){
								$url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/english-unselected.png';
							} elseif($l['language_code']=="fr"){
								$url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/french-unselected.png';
							}elseif($l['language_code']=="de"){
								$url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/german-unselected.png';
							}
							if(!$l['active']){
								$permalink_url1 = $l['url'];
								
								// if ( get_query_var( 'explore_category' ) && ( $term1 = get_term_by( 'slug', sanitize_title( get_query_var( 'explore_category'  ) ), 'job_listing_category' ) ) ) {
									// $data1 = icl_object_id($term1->term_id, 'job_listing_category', true, $l['language_code']);
									// global $sitepress;
									// remove_filter('get_term', array($sitepress,'get_term_adjust_id'), 1, 1);
									// $original_ob = get_term( $data1, 'job_listing_category' );
									// $permalink_url1 = get_term_link($data1,'job_listing_category');
									// add_filter('get_term', array($sitepress,'get_term_adjust_id'), 1, 1);
									
								// }
								$taxonomies = [
									['tax' => 'region',                  'query_var' => 'explore_region',   'name_filter' => 'single_term_title'],
									['tax' => 'job_listing_category',    'query_var' => 'explore_category', 'name_filter' => 'single_cat_title'],
									['tax' => 'case27_job_listing_tags', 'query_var' => 'explore_tag',      'name_filter' => 'single_tag_title'],
								];
								foreach ( $taxonomies as $tax ) {
									if ( get_query_var( $tax['query_var'] ) && ( $term1 = get_term_by( 'slug', sanitize_title( get_query_var( $tax['query_var'] ) ), $tax['tax'] ) ) ) {
										$data1 = icl_object_id($term1->term_id, $tax['tax'], true, $l['language_code']);
										
										global $sitepress;
										remove_filter('get_term', array($sitepress,'get_term_adjust_id'), 1, 1);
										$original_ob = get_term( $data1, $tax['tax'] );
										$permalink_url1 = get_term_link($data1,$tax['tax']);
										add_filter('get_term', array($sitepress,'get_term_adjust_id'), 1, 1);
									} 
								}
                         ?>

					<li <?php if($l['active']){ echo 'class="active"';}?>><a href="<?php echo $permalink_url1;?>"><img src="<?php echo $url;?>"></a></li>
			 <?php   } }?>
                </ul>
                </div>
				
				
				<?php if (c27()->get_setting('header_call_to_action_label') && c27()->get_setting('header_call_to_action_links_to') && $data['show_call_to_action']): ?>
					<div class="header-button">
						<a href="<?php echo esc_url( c27()->get_setting('header_call_to_action_links_to') ) ?>" class="buttons button-<?php echo $data['skin'] == 'light' ? '2' : '1' ?>">
							<?php echo do_shortcode(c27()->get_setting('header_call_to_action_label')) ?>
						</a>
					</div>
				<?php endif ?>

				<?php if ($data['show_search_form']): ?>
					<div class="search-trigger"> <a href="#"><i class="material-icons">search</i></a></div>
				<?php endif ?>
			</div>
		</div>
		<div class="container">
			<?php if ($data['show_search_form']): ?>
				<?php c27()->get_partial('header-search-form', ['placeholder' => $data['search_form_placeholder']]) ?>
			<?php endif ?>

			<div class="i-nav">
				<div class="mobile-nav-head">
					<div class="mnh-close-icon">
						<a href="#close-main-menu">
							<i class="material-icons">close</i>
						</a>
					</div>
				</div>

				<?php echo str_replace('class="sub-menu"', 'class="sub-menu i-dropdown"', wp_nav_menu([
					'echo' => false,
					'theme_location' => 'primary',
					'container' => false,
					'menu_class' => 'main-menu',
					'items_wrap' => '<ul id="%1$s" class="%2$s main-nav">%3$s</ul>'
					])); ?>
					<?php  $languages = icl_get_languages('skip_missing=1');?>
			    <div class="language-selector hidden-lg hidden-xs">
				<?php foreach($languages as $l){ 
					if($l['active']){ 
					?>
							<?php $active_url = $l['country_flag_url'];
							if($l['language_code']=="en"){
								$active_url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/english-selected.png';
							} elseif($l['language_code']=="fr"){
								$active_url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/french-selected.png';
							}elseif($l['language_code']=="de"){
								$active_url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/german-selected.png';
							}

							?>
							<span><img src="<?php echo $active_url;?>"></span>
				<?php } }?>
               <ul>
			   <?php foreach($languages as $l){ ?>
				<?php $url = $l['country_flag_url'];
							if($l['language_code']=="en"){
								$url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/english-unselected.png';
							} elseif($l['language_code']=="fr"){
								$url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/french-unselected.png';
							}elseif($l['language_code']=="de"){
								$url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/german-unselected.png';
							}

							if($l['active']){
								$url = $active_url;
							}
							$permalink_url1 = $l['url'];
								if ( get_query_var( 'explore_category' ) && ( $term1 = get_term_by( 'slug', sanitize_title( get_query_var( 'explore_category'  ) ), 'job_listing_category' ) ) ) {
									$data1 = icl_object_id($term1->term_id, 'job_listing_category', true, $l['language_code']);
									global $sitepress;
									remove_filter('get_term', array($sitepress,'get_term_adjust_id'), 1, 1);
									$original_ob = get_term( $data1, 'job_listing_category' );
									$permalink_url1 = get_term_link($data1,'job_listing_category');
									add_filter('get_term', array($sitepress,'get_term_adjust_id'), 1, 1);
									
								}
                         ?>

					<li <?php if($l['active']){ echo 'class="active"';}?>><a href="<?php echo $permalink_url1;?>"><img src="<?php echo $url;?>"></a></li>
			 <?php   }?>
                </ul>
                            </div>
			</div>
			<div class="i-nav-overlay"></div>
		</div>
	</div>
</header>

<?php if ( ! $data['blend_to_next_section'] ): ?>
	<div class="c27-top-content-margin"></div>
<?php endif ?>

<?php if ( $data['is_edit_mode'] ): ?>
    <script type="text/javascript">case27_ready_script(jQuery);</script>
<?php endif ?>