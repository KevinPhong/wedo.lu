<?php
if(ICL_LANGUAGE_CODE=="en") {
	$case27_listing_type = 'offre-demploi-en';
} elseif(ICL_LANGUAGE_CODE=="fr") {
	$case27_listing_type = 'offre-demploi';
} elseif(ICL_LANGUAGE_CODE=="de") {
	$case27_listing_type = 'offre-demploi-de';
}
/*
  Ajax posts
---------------------------------------------------------------- */
function contract_found_posts($id) {
	global $case27_listing_type;
	$args = array(
		'post_type'  => 'job_listing',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'meta_query'     => array(
			array(
				'key'     => '_case27_listing_type',
				'value'   => $case27_listing_type,
				'compare' => '=',
			),
			array(
				'key'     => '_contrat-de-travail',
				'value'   => $id,
				'compare' => '=',
			),
		),
	);
	$contract_query = new WP_Query( $args );
	if($contract_query->found_posts > 0) {
		return '';
	} else {
		return 'no-post';
	}
}

function category_found_posts($id) {
	global $case27_listing_type;
	$args = array(
		'post_type'  => 'job_listing',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'meta_query'     => array(
			array(
				'key'     => '_case27_listing_type',
				'value'   => $case27_listing_type,
				'compare' => '=',
			),
		),
		'tax_query' => array(
			array(
				'taxonomy'         => 'job_listing_category',
				'field'            => 'id',
				'terms'            => array($id),
			),
		),
	);
	$category_query = new WP_Query( $args );
	if($category_query->found_posts > 0) {
		return '';
	} else {
		return 'no-post';
	}
}

function region_found_posts($id) {
	global $case27_listing_type;
	$args = array(
		'post_type'  => 'job_listing',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'meta_query'     => array(
			array(
				'key'     => '_case27_listing_type',
				'value'   => $case27_listing_type,
				'compare' => '=',
			),
		),
		'tax_query' => array(
			array(
				'taxonomy'         => 'region',
				'field'            => 'id',
				'terms'            => array($id),
			),
		),
	);
	$region_query = new WP_Query( $args );
	if($region_query->found_posts > 0) {
		return '';
	} else {
		return 'no-post';
	}
}

add_action( 'wp_ajax_p_ajax_posts', 'p_ajax_posts_init' );
add_action( 'wp_ajax_nopriv_p_ajax_posts', 'p_ajax_posts_init' );

function p_ajax_posts_init() {
	ob_start();
	$lang = $_POST['lang'];
	if($lang=="en") {
		$case27_listing_type = 'offre-demploi-en';
	} elseif($lang=="fr") {
		$case27_listing_type = 'offre-demploi';
	} elseif($lang=="de") {
		$case27_listing_type = 'offre-demploi-de';
	}
	$args = array(
		'post_type'  => 'job_listing',
		'posts_per_page' => 21,
		'post_status' => 'publish'
	);
	if(isset($_POST['current_page']) && !empty($_POST['current_page'])) {
		$current_page = $_POST['current_page'];
		$args['offset'] = ($current_page * 21) - 21;
	}
	if(isset($_POST['keyword']) && !empty($_POST['keyword'])) {
		$keyword = $_POST['keyword'];
		$s_args = array(
			'post_type' => 'job_listing',
			'posts_per_page' => -1,
			's' => $keyword,
			'post_status' => 'publish',
			'meta_query'     => array(
				array(
					'key'     => '_case27_listing_type',
					'value'   => $case27_listing_type,
					'compare' => '=',
				),
			)
		);
		$s_query = new WP_Query( $s_args );
		$s_posts_id = array();
		while($s_query->have_posts()) :
			$s_query->the_post();
				global $post;
				$s_posts_id[] = $post->ID;
		endwhile; wp_reset_postdata();
		$des_args = array(
			'post_type' => 'job_listing',
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'post__not_in' => $s_posts_id,
			'meta_query'     => array(
				array(
					'key'     => '_job_description',
					'value'   => $keyword,
					'compare' => 'LIKE',
				),
				array(
					'key'     => '_case27_listing_type',
					'value'   => $case27_listing_type,
					'compare' => '=',
				),
			)
		);
		$des_query = new WP_Query( $des_args );
		$des_posts_id = array();
		while($des_query->have_posts()) :
			$des_query->the_post();
				global $post;
				$des_posts_id[] = $post->ID;
		endwhile; wp_reset_postdata();
		$k_post_id = array_merge($s_posts_id, $des_posts_id);
		if(empty($k_post_id)) {
			$args['post__in'] = array(99019119);
		} else {
			$args['post__in'] = $k_post_id;
		}
	}
	$meta_query = array();
	$tax_query = array();
	$meta_query[] = array(
		'key'     => '_case27_listing_type',
		'value'   => $case27_listing_type,
		'compare' => '=',
	);
	if(isset($_POST['contract_id']) && !empty($_POST['contract_id'])) {
		$contract_id = $_POST['contract_id'];
		$meta_query[] = array(
			'key'     => '_contrat-de-travail',
			'value'   => $contract_id,
		);
	}
	if(isset($_POST['category_id']) && !empty($_POST['category_id'])) {
		$category_id = $_POST['category_id'];
		$tax_query[] = array(
			'taxonomy'         => 'job_listing_category',
			'field'            => 'id',
			'terms'            => $category_id,
		);
	}
	if(isset($_POST['regions_id']) && !empty($_POST['regions_id'])) {
		$regions_id = $_POST['regions_id'];
		$tax_query[] = array(
			'taxonomy'         => 'region',
			'field'            => 'id',
			'terms'            => $regions_id,
		);
	}
	if(!empty($meta_query)) {
		$args['meta_query'] = $meta_query;
	}
	if(!empty($tax_query)) {
		$args['tax_query'] = $tax_query;
	}
	$query = new WP_Query( $args );
	$max_result = 21;
	$total_row = $query->found_posts;
	$total_page = ceil($total_row/$max_result);
	if($query->have_posts()) :
		echo '<div class="outer-posts"><div class="p-loading"><div class="loader"></div></div><div class="posts">';
		while($query->have_posts()) :
			$query->the_post();
			global $post;
			$post_id = $post->ID;
?>
        <div class="item">
			<a href="<?php the_permalink(); ?>">
			<div class="wrapper">
				<img src="<?php if(get_field('_job_cover', $post_id) && @getimagesize(get_field('_job_cover', $post_id))) { echo get_field('_job_cover', $post_id); } else { echo get_stylesheet_directory_uri() . '/assets/images/offre_d_emploi_luxembourg.jpg'; } ?>">
				<span class="tag"><?= wp_trim_words(get_field('_socit', $post_id), 3, '...'); ?></span>
				<div class="bottom-text">
					<h3><?= get_the_title(); ?></h3>
					<?php
						$region_term = wp_get_post_terms($post_id, 'region', array("fields" => "names"));
						if($region_term) :
						echo '<div class="outer-location">';
							foreach ($region_term as $key => $name) :
					?>
						<p class="location"><?= $name; ?></p>
					<?php endforeach; echo "</div>"; endif; ?>
				</div>
			</div>
			</a>
		</div>
<?php
    endwhile; echo "</div></div>";
	else :
		echo "<div class='outer-posts'><div class='p-loading'><div class='loader'></div></div><div class='no-result'><img src='" . get_stylesheet_directory_uri() . "/assets/images/ico_no_result.png'><p>" . __('No Result Found', 'wedo-listing') . "</p></div></div>";
    endif; wp_reset_postdata();
    if($total_row > 21) :
    	if(!isset($current_page)) :
?>
		<div class="pagination">
			<a href="#" class="arrow prev disabled"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
			<a href="#" class="current">1</a>
			<?php
				for ($i=2; $i <= $total_page; $i++) {
					echo '<a href="#" class="active" data-number="' . $i . '">' . $i .'</a>';
				}
			?>
			<a href="#" class="arrow next active" data-number="2"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
		</div>
<?php
		else:
?>
		<div class="pagination">
			<a href="#" class="arrow prev <?php if($current_page != 1) {echo 'active'; } else { echo 'disabled'; } ?>" data-number="<?= $current_page - 1 ?>"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
			<?php
				for ($i=1; $i <= $total_page; $i++) {
					if($current_page == $i) {
						echo '<a href="#" class="current">' . $i . '</a>';
					} else {
						echo '<a href="#" class="active" data-number="' . $i . '">' . $i .'</a>';
					}
				}
			?>
			<a href="#" class="arrow next <?php if($current_page != $total_page) {echo 'active'; } else { echo 'disabled'; } ?>" data-number="<?= $current_page + 1 ?>"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
		</div>
<?php
	endif;
	endif;
	$result = ob_get_clean();
	wp_send_json_success($result);
    die();
}

add_action( 'wp_ajax_blog_ajax_posts', 'blog_ajax_posts_init' );
add_action( 'wp_ajax_nopriv_blog_ajax_posts', 'blog_ajax_posts_init' );

function blog_ajax_posts_init() {
	ob_start();
	$args = array(
		'post_type'  => 'post',
		'posts_per_page' => 12,
		'post_status' => 'publish'
	);
	if(isset($_POST['current_page']) && !empty($_POST['current_page'])) {
		$current_page = $_POST['current_page'];
		$args['offset'] = ($current_page * 12) - 12;
	}
	if(isset($_POST['keyword']) && !empty($_POST['keyword'])) {
		$keyword = $_POST['keyword'];
		$args['s'] = $keyword;
	}
	if(isset($_POST['category_id']) && !empty($_POST['category_id'])) {
		$category_id = $_POST['category_id'];
		$args['category__in'] = $category_id;
	}
	$query = new WP_Query( $args );
	$max_result = 12;
	$total_row = $query->found_posts;
	$total_page = ceil($total_row/$max_result);
	if($query->have_posts()) :
		echo '<div class="outer-posts"><div class="p-loading"><div class="loader"></div></div><div class="posts">';
		while($query->have_posts()) :
			$query->the_post();
			global $post;
			$post_id = $post->ID;
			$image = c27()->featured_image($post_id, 'large');
			if (!$image) $image = c27()->get_setting('blog_default_post_image');
			$style='';
			if($image){$style='';}else{$style='background: #ffa602;opacity:0.4;height:125px';}
?>
        <div class="item">
			<div class="wrapper">
				<?php
					$categories = wp_get_post_categories( $post_id );
					if($categories) {
						$cat = get_category( $categories[0] );
				?>
						<a href="<?= get_term_link($cat->slug, 'category') ?>" class="tag"><?= $cat->name ?></a>
				<?php } ?>
				<a href="<?php the_permalink(); ?>">
					<div class="img-wrap" style="<?php echo $style; ?>">
						<?php if ($image): ?>
							<img src="<?php echo esc_url( $image ) ?>" alt="wedo.lu" />
						<?php endif ?>
					</div>
					<div class="bottom-text">
						<h3><?= get_the_title(); ?></h3>
						<div class="description">
							<p><?php c27()->the_excerpt(125) ?></p>
						</div>
						<div class="bottom">
							<span class="date"><?php echo get_the_date( 'j M, Y' ); ?></span>
							<span class="read-more"><?php echo __('Read More', 'wedo-listing'); ?></span>
						</div>
					</div>
				</a>
			</div>
		</div>
<?php
    endwhile; echo "</div></div>";
	else :
		echo "<div class='outer-posts'><div class='p-loading'><div class='loader'></div></div><div class='no-result'><img src='" . get_stylesheet_directory_uri() . "/assets/images/ico_no_result.png'><p>" . __('No Result Found', 'wedo-listing') . "</p></div></div>";
    endif; wp_reset_postdata();
    if($total_row > 12) :
    	if(!isset($current_page)) :
?>
		<div class="pagination">
			<a href="#" class="arrow prev disabled"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
			<a href="#" class="current">1</a>
			<?php
				if($total_page > 9) {
					echo '<a href="#" class="active" data-number="2">2</a>';
					echo '<a href="#" class="active" data-number="3">3</a>';
					echo '<a href="#" class="active" data-number="4">4</a>';
					echo '<a href="#" class="active" data-number="5">5</a>';
					echo '<a href="#" class="dots disabled">...</a>';
					echo '<a href="#" class="active" data-number="' . $total_page . '">' . $total_page . '</a>';
				} else {
					for ($i=2; $i <= $total_page; $i++) {
						echo '<a href="#" class="active" data-number="' . $i . '">' . $i .'</a>';
					}
				}
			?>
			<a href="#" class="arrow next active" data-number="2"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
		</div>
<?php
		else:
?>
		<div class="pagination">
			<a href="#" class="arrow prev <?php if($current_page != 1) {echo 'active'; } else { echo 'disabled'; } ?>" data-number="<?= $current_page - 1 ?>"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
			<?php
				if($total_page > 9) {
					if($current_page < 5) {
						for ($i=1; $i <= 5; $i++) {
							if($current_page == $i) {
								echo '<a href="#" class="current">' . $i . '</a>';
							} else {
								echo '<a href="#" class="active" data-number="' . $i . '">' . $i .'</a>';
							}
						}
						echo '<a href="#" class="dots disabled">...</a>';
						echo '<a href="#" class="active" data-number="' . $total_page . '">' . $total_page . '</a>';
					} else if($current_page >=5 && $current_page <= ($total_page - 4)) {
						echo '<a href="#" class="active" data-number="1">1</a>';
						echo '<a href="#" class="dots disabled">...</a>';
						echo '<a href="#" class="active" data-number="' . ($current_page - 1) . '">' . ($current_page - 1) .'</a>';
						echo '<a href="#" class="current">' . $current_page . '</a>';
						echo '<a href="#" class="active" data-number="' . ($current_page + 1) . '">' . ($current_page + 1) .'</a>';
						echo '<a href="#" class="dots disabled">...</a>';
						echo '<a href="#" class="active" data-number="' . $total_page . '">' . $total_page . '</a>';
					} else {
						echo '<a href="#" class="active" data-number="1">1</a>';
						echo '<a href="#" class="dots disabled">...</a>';
						for ($i=($total_page - 4); $i <= $total_page; $i++) {
							if($current_page == $i) {
								echo '<a href="#" class="current">' . $i . '</a>';
							} else {
								echo '<a href="#" class="active" data-number="' . $i . '">' . $i .'</a>';
							}
						}
					}
				} else {
					for ($i=1; $i <= $total_page; $i++) {
						if($current_page == $i) {
							echo '<a href="#" class="current">' . $i . '</a>';
						} else {
							echo '<a href="#" class="active" data-number="' . $i . '">' . $i .'</a>';
						}
					}
				}
			?>
			<a href="#" class="arrow next <?php if($current_page != $total_page) {echo 'active'; } else { echo 'disabled'; } ?>" data-number="<?= $current_page + 1 ?>"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
		</div>
<?php
	endif;
	endif;
	$result = ob_get_clean();
	wp_send_json_success($result);
    die();
}

function p_vdump($a) {
	echo "<pre>";
	echo "<pre>";
		var_dump($a);
	echo "</pre>";
	echo "</pre>";
}