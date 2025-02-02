<?php get_header();?>
<?php while(have_posts()): the_post(); $slideshow = get_field('slideshow'); ?>
<?php if( $slideshow ):  ?>
     <div id="slideshow-secondary">
        <?php
			$key = array_rand( $slideshow,1 );
			$image = $slideshow[$key]['image'];
			$media_id = giang_get_image_id( $image ); ;
			$alt = 'image';
			if($media_id) $alt = giang_get_media_alt( $media_id );
			
			$img_html = '<img class="banner-image" src="'. $image .'" alt="'. $alt .'">';
			echo $img_html;
		?>
     </div>
<?php endif;?>
     <div class="intro-section section1">
        <div class="container">
           <div class="search-box search-form">
              <h2 class="text-center"><?php the_field('search_box_heading');?></h2>
              <h3 class="text-center"><?php the_field('search_box_description');?></h3> 
            <form method="GET" class="search-project-form" action="<?php echo home_url('/');?>annuaire-2/">						
			  <div class="explore-filter md-group wp-search-filter  md-active searchbar__field">
              <input type="text" v-model="facets['place']['search_keywords']" id="5ad486db6a5d5__facet" name="search_keywords" autocomplete="off" autocorrect="off" placeholder="<?php _e('What are you looking for ?','wedo-listing');?>" @keyup="getListings">
              <input type="submit" value="<?php _e('Find a craftsman','wedo-listing');?>">
              </div>
			  <input type="hidden" name="tab" value="search-form">
    		  <input type="hidden" name="type" value="place">
			  <div class="search-result"></div>
			</form>
			
			<script type="text/javascript">
				jQuery(document).ready(function($){
					var timer;
					$(".search-project-form .searchbar__field input[type='text']").on('change keyup paste', function () {
						var element = $(this);
						clearTimeout(timer);
    					timer = setTimeout(function() {
							if( element.val().length >= 3 ) {
								$.ajax({
									type : 'POST',
									data : {
									   'action' : 'hr_search_listing',
									   'lang' : '<?php echo ICL_LANGUAGE_CODE; ?>',
									   'search_key' :  element.val()
									},
									url : '<?php echo admin_url( "admin-ajax.php" ); ?>',
									success : function (result){
										if( result != '' ) {
											$('.search-project-form .search-result').html( result ).show();
										}
										else {
											$('.search-project-form .search-result').hide();
										}
									}
								});
							}
						}, 500 );
					});
					
					$('.search-project-form .searchbar__field input[type="text"]').focus(function() {
						if( $.trim( $('.search-project-form .search-result').html() ) != '' ) {
							$('.search-project-form .search-result').show();
						}
						else {
							$('.search-project-form .search-result').hide();
						}
					});
					
					// $(".search-project-form .searchbar__field input").focusout(function() {
						// $('.search-project-form .search-result').hide();
					// });
					
					$(document).on('click', '.search-project-form .search-result a', function(e){
						e.preventDefault();
						var element = $(this);
						$('.search-project-form .searchbar__field input[type="text"]').val( element.text() );
						$('.search-project-form .search-result').hide();
					});

					
				});
			</script>
			<style type="text/css">
				.search-project-form {
					position: relative;
				}
				form.search-project-form .search-result {
					display: none;
					width: calc(100% - 197px);
					border: 1px solid #e4e4e4;
					padding: 15px;
					border-radius: 4px;
					position: absolute;
					left: -.15rem;
					top: 100%;
					height: auto;
					background: #fff;
					z-index: 1;
				}
				.search-project-form .search-result p:last-child {
					margin: 0;
				}
				.search-project-form .search-result a {
					color: #5c5c68;
				}
				.search-project-form .search-result a:hover {
					color: #ffa602;
				}
				@media screen and (max-width: 767px) {
					form.search-project-form .search-result {
						width: 100%;
					}
				}

			</style>
			
           </div>
           <?php if(get_field('sections')):?>
           <ul>
               <?php while(has_sub_field('sections')):?>
              <li><a href="<?php the_sub_field('url');?>">
				<?php 
					$media_id = giang_get_image_id(get_sub_field('icons')); ;
					$alt = 'image';
					if($media_id) $alt = giang_get_media_alt( $media_id );
				?>
                 <img src="<?php the_sub_field('icons');?>"  class="svg" alt="<?php echo $alt; ?>">
                 <p><?php the_sub_field('title');?></p>
                 </a>
              </li>
              <?php endwhile;?>
           </ul>
           <?php endif;?>
        </div>
     </div>
     <div class="box8 section1" style="background-image:url(<?php the_field('background_image');?>)">
        <div class="container">
           <h2 class="text-center">
             <?php the_field('right_partner_heading');?>
           </h2>
           <?php if(get_field('right_partner_features')):?>
           <div class="row box9">
               <?php while(has_sub_field('right_partner_features')):?>
              <div class="col-md-3 col-sm-6 text-center">
				<?php 
					$media_id = giang_get_image_id(get_sub_field('icon')); ;
					$alt = 'image';
					if($media_id) $alt = giang_get_media_alt( $media_id );
				?>
                 <img src="<?php the_sub_field('icon');?>" alt="<?php echo $alt; ?>">
                 <p><?php the_sub_field('description');?></p>
              </div>
             <?php endwhile;?>
           </div>
             <?php endif;?>
			
            <?php if( get_field('categories_to_show') || get_field('custom_links') ):?>
            <?php $categories = get_field('categories_to_show');?>
           <div class="categories">
              <h2 class="text-center"><?php _e('Our categories','wedo-listing');?></h2>
              <ul>
                  <?php if(get_field('categories_to_show')) : foreach($categories as $category):?>
                 <li><a href="<?php echo get_term_link($category);?>">
                 <?php if($icon_image = get_field('icon_image', $category)):?>
					<?php
						$media_id = giang_get_image_id($icon_image['url']); ;
						$alt = 'image';
						if($media_id) $alt = giang_get_media_alt( $media_id );
					?>
                    <img src="<?php echo $icon_image['url'];?>" class="svg" alt="<?php echo $alt; ?>">
                 <?php endif;?>
                    <p><?php echo $category->name;?></p>
                    </a>
                 </li>
                 <?php endforeach; endif; ?>
				 
                 <?php if(get_field('custom_links')): ?>
                 <?php while(has_sub_field('custom_links')):?>
                 <li><a href="<?php the_sub_field('url');?>">
                 <?php if($icon_image = get_sub_field('icon')):?>
					<?php
						$media_id = giang_get_image_id($icon_image); ;
						$alt = 'image';
						if($media_id) $alt = giang_get_media_alt( $media_id );
					?>
                    <img src="<?php echo $icon_image;?>" class="svg" alt="<?php echo $alt; ?>">
                 <?php endif;?>
                    <p><?php echo get_sub_field('title');?></p>
                    </a>
                 </li>
                 <?php endwhile;?>
                 <?php endif;?>
				 
              </ul>
           </div>
          <?php endif;?>
		  
           <div class="call-to-action">
              <div class="row">
                 <div class="col-md-9 col-sm-6">
                    <p><?php the_field('get_a_quote_heading');?></p>
                 </div>
                 <div class="col-md-3 col-sm-6 text-right">
                    <a href="<?php the_field('get_a_quote_link');?>" class="buttons button-2"><?php _e('Ask for an estimate','wedo-listing');?></a>
                 </div>
              </div>
           </div>
        </div>
     </div>
     <?php 
     $lsting_type = 'place';
     $page = get_page_by_path( $lsting_type , OBJECT, 'case27_listing_type');
     $current_listing_type_id = apply_filters( 'wpml_object_id', $page->ID, 'case27_listing_type' );
     $post_slug = get_post_field( 'post_name', $current_listing_type_id );
$args = array(
  'posts_per_page' => -1,
  'post_type' => 'job_listing',
  'meta_query' => array(
    'relation' => 'AND',
    array(
        'key'     => '_case27_listing_type',
        'value'   => $post_slug,
        'compare' => '==',
    ),
    array(
        'key'     => '_user_package_id',
        'value'   => '',
        'compare' => '!=',
    ),
  ),
);
$the_query = new WP_Query( $args ); 
if( 0 && $the_query->have_posts()):?>
     <div class="section1 craftsmen">
        <div class="container">
            <div class="carousel2">
           <h2 class="text-center"><?php _e('Our craftsmen on wedo.lu','wedo-listing');?></h2>
           <div class="owl-carousel">
           <?php while($the_query->have_posts()): $the_query->the_post(); ?>
           <?php $listing = MyListing\Src\Listing::get( $the_query->post );?>
           <?php  $user_listing_type = get_post_meta( get_the_ID(), '_user_package_id', true );
                  $listing_type = get_post_meta( get_the_ID(), '_package_id', true );
                  $product_id = get_post_meta( $user_listing_type, '_product_id', true); ?>
              <?php if($user_listing_type && $product_id!= '11347'): ?>
            <div class="item">
                <a href="<?php the_permalink();?>">
                    <div class="card">
                       <div class="card-description">
                       <?php if ($listing_logo = $listing->get_logo( 'medium' )):?>
                    
                    <?php

$media_id = giang_get_image_id($listing_logo); ;
$alt = 'image';
if($media_id) $alt = giang_get_media_alt( $media_id );
			
$img_html = '<img src="'.$listing_logo.'" alt="'. $alt .'">';
$img_html = apply_filters( 'bj_lazy_load_html', $img_html );
echo $img_html;
?>
                    <?php endif;?>
                    <h3><?php the_title();?></h3>
                       <?php if ( $tagline = $listing->get_field('job_tagline') ): ?>
                        <p><?php echo c27()->the_text_excerpt( wp_kses( $tagline, [] ), 100 ) ?></p>
                       <?php elseif ( $description = $listing->get_field('job_description') ): ?>
                        <p><?php echo c27()->the_text_excerpt( wp_kses( $description, [] ), 100 ) ?></p>
                       <?php endif ?>
                       </div>
                       <?php if($cover = $listing->get_cover_image( 'large' )):?>
                    <div class="card-image">
                       
                       <?php
$media_id = giang_get_image_id($cover); ;
$alt = 'image';
if($media_id) $alt = giang_get_media_alt( $media_id );
		
$img_html = '<img src="'.$cover.'" alt="'. $alt .'">';
$img_html = apply_filters( 'bj_lazy_load_html', $img_html );
echo $img_html;
?>
                    </div>
                   <?php endif;?>
                    </div>
                    </a>
            </div>
            <?php endif;?>
            <?php endwhile;?>
          </div>
         <?php /*  <ul class="clearfix carousel-list2">
           <?php while($the_query->have_posts()): $the_query->the_post(); ?>
           <?php $listing = MyListing\Src\Listing::get( $the_query->post );?>
           <?php  $user_listing_type = get_post_meta( get_the_ID(), '_user_package_id', true );
                  $listing_type = get_post_meta( get_the_ID(), '_package_id', true );
                  $product_id = get_post_meta( $user_listing_type, '_product_id', true); ?>
              <?php if($user_listing_type && $product_id!= '11347'): ?>
              <li><a href="<?php the_permalink();?>">
                 <div class="card">
                    <div class="card-description">
                    <?php if ($listing_logo = $listing->get_logo( 'medium' )):?>
                    <img src="<?php echo $listing_logo;?>" alt="image">
                    <?php endif;?>
                       <h3><?php the_title();?></h3>
                       <?php if ( $tagline = $listing->get_field('job_tagline') ): ?>
                        <p><?php echo c27()->the_text_excerpt( wp_kses( $tagline, [] ), 100 ) ?></p>
                       <?php elseif ( $description = $listing->get_field('job_description') ): ?>
                        <p><?php echo c27()->the_text_excerpt( wp_kses( $description, [] ), 100 ) ?></p>
                       <?php endif ?>
                    </div>
                    <?php if($cover = $listing->get_cover_image( 'large' )):?>
                    <div class="card-image">
                       <img src="<?php echo $cover;?>" alt="image">
                    </div>
                   <?php endif;?>
                 </div>
                 </a>
              </li>
             <?php endif;?>
            <?php endwhile;?>     
                  
           </ul>
           <div class="pagination">
                <a href="#" class="pagination-btn prev-btn"><i aria-hidden="true" class="fa fa-angle-left"></i></a>
                <a href="#" class="pagination-btn next-btn"><i aria-hidden="true" class="fa fa-angle-right"></i></a>
             </div> */ ?>
        </div>
        </div>
     </div>
      <?php endif; wp_reset_query();?>
     <?php if(get_field('partners')):?>
     <?php $count = count(get_field('partners'));?>
     <div class="partners section1">
        <div class="container">
           <h2 class="text-center"><?php _e('The partners of the craft industry','wedo-listing');?></h2>
           <ul class="clearfix">
               <?php $i=1; while(has_sub_field('partners')):?>
              <li><a href="<?php the_sub_field('url');?>">
                 
                 <?php
$media_id = giang_get_image_id(get_sub_field('icon')); ;
$alt = 'image';
if($media_id) $alt = giang_get_media_alt( $media_id );

$img_html = '<img src="'.get_sub_field('icon').'" alt="'. $alt .'">';
$img_html = apply_filters( 'bj_lazy_load_html', $img_html );
echo $img_html;
?>
                 </a>
              </li>
              <?php if($i==4){ break;}?>
              <?php $i++; endwhile;?>
           </ul>
           <?php if($count > 4){ ?>
           <div class="text-center view-more-btn">
                <a href="#" class=""><?php _e('Other partners','wedo-listing');?></a>
            </div>
           <ul class="clearfix">
           <?php $i=1; while(has_sub_field('partners')):?>
           <?php $i++; if($i<4){ continue;}?>
              <li><a href="<?php the_sub_field('url');?>">
				<?php
					$media_id = giang_get_image_id(get_sub_field('icon')); ;
					$alt = 'image';
					if($media_id) $alt = giang_get_media_alt( $media_id );
				?>
                 <img src="<?php the_sub_field('icon');?>" alt="<?php echo $alt; ?>">
                 </a>
              </li>              
              <?php  endwhile;?>           

         </ul>
           <?php } ?>
        </div>
     </div>
<?php endif;?>
<?php /* $args = array(
  'posts_per_page' => -1,
  'post_type' => 'job_listing',
);
$the_query = new WP_Query( $args ); 
if($the_query->have_posts()):?>
<?php while($the_query->have_posts()): $the_query->the_post();
echo $lsting_type = get_post_meta($the_query->post->ID,'_case27_listing_type', true);
$page = get_page_by_path( $lsting_type , OBJECT, 'case27_listing_type');
echo $page->ID;
$current_listing_type_id = apply_filters( 'wpml_object_id', $page->ID, 'case27_listing_type' );
echo $post_slug = get_post_field( 'post_name', $current_listing_type_id );
update_post_meta( $the_query->post->ID,'_case27_listing_type', $post_slug );
$is_translated = apply_filters( 'wpml_element_has_translations', NULL, $the_query->post->ID, 'job_listing' );
 
if ( !$is_translated ) {
    do_action( 'wpml_admin_make_post_duplicates', $the_query->post->ID );
} 
endwhile;?>
<?php endif; */?>
<?php 
 $lsting_type = 'offre-demploi';
 $page = get_page_by_path( $lsting_type , OBJECT, 'case27_listing_type');
 $current_listing_type_id = apply_filters( 'wpml_object_id', $page->ID, 'case27_listing_type' );
 $post_slug = get_post_field( 'post_name', $current_listing_type_id );
$args = array(
  'posts_per_page' => -1,
  'post_type' => 'job_listing',
  'meta_key'   => '_case27_listing_type',
  'meta_value' => $post_slug
);
$the_query = new WP_Query( $args ); 
if( 0 && $the_query->have_posts()):?>
     <div class="offers section1">
        <div class="container">
           <h2 class="text-center"><?php _e('Jobs Offers','wedo-listing');?></h2>
           <div class="owl-carousel">
           <?php while($the_query->have_posts()): $the_query->the_post(); ?>
           <?php $listing = MyListing\Src\Listing::get( $the_query->post );?>
                <div class="item">
                    <a href="<?php the_permalink();?>">
                        <div class="card">
                            
                           <div class="card-description">
                           <h3><?php the_title();?></h3>
                    <hr>
                    <?php if ($listing_logo = $listing->get_logo( 'medium' )):?>
<?php
	$media_id = giang_get_image_id($listing_logo); ;
	$alt = 'image';
	if($media_id) $alt = giang_get_media_alt( $media_id );
?>
                    <?php
$img_html = '<img src="'.$listing_logo.'" alt="'. $alt .'">';
$img_html = apply_filters( 'bj_lazy_load_html', $img_html );
echo $img_html;
?>
                    <?php else: ?>
                    <img src="<?php echo trailingslashit( get_stylesheet_directory_uri() );?>assets/images/job-offer.svg" alt="image">
                    <?php endif;?>
                    <?php if ( $tagline = $listing->get_field('job_tagline') ): ?>
                        <p><?php echo esc_html( $tagline ) ?></p>
                    <?php elseif ( $description = $listing->get_field('job_description') ): ?>
                        <p><?php echo c27()->the_text_excerpt( wp_kses( $description, [] ), 114 ) ?></p>
                    <?php endif ?>
                           </div>
                        </div>
                        </a>
                </div>
                <?php endwhile;?>
            </div>
           <?php /* <div class="carousel">
           <ul class="clearfix carousel-list">
           <?php while($the_query->have_posts()): $the_query->the_post(); ?>
           <?php $listing = MyListing\Src\Listing::get( $the_query->post );?>
              <li><a href="<?php the_permalink();?>">
                 <div class="card">
                    <h3><?php the_title();?></h3>
                    <hr>
                    <?php if ($listing_logo = $listing->get_logo( 'medium' )):?>
                    <img src="<?php echo $listing_logo;?>" alt="image">
                    <?php else: ?>
                    <img src="<?php echo trailingslashit( get_stylesheet_directory_uri() );?>assets/images/job-offer.svg" alt="image">
                    <?php endif;?>
                    <?php if ( $tagline = $listing->get_field('job_tagline') ): ?>
                        <p><?php echo esc_html( $tagline ) ?></p>
                    <?php elseif ( $description = $listing->get_field('job_description') ): ?>
                        <p><?php echo c27()->the_text_excerpt( wp_kses( $description, [] ), 114 ) ?></p>
                    <?php endif ?>
                </div></a>
              </li>
             <?php endwhile;?>
           </ul>
           <div class="pagination">
                <a href="#" class="pagination-btn prev-btn"><i aria-hidden="true" class="fa fa-angle-left"></i></a>
                <a href="#" class="pagination-btn next-btn"><i aria-hidden="true" class="fa fa-angle-right"></i></a>
            </div>
            </div> */ ?>

            <div class="text-center">
<a href="<?php echo home_url('/jobboard/');?>" class="buttons button-2"><?php _e('See all','wedo-listing');?></a>
            </div>
        </div>
     </div>
<?php endif;wp_reset_query();?>
     <?php
$args = array(
  'posts_per_page' => -1,
  'post_type' => 'post',
);
$the_query = new WP_Query( $args ); 
if( 0 && $the_query->have_posts()):?>
     <div class="blog-wrapper">
        <div class="container-fluid">
           <div class="ow same-heigh">

            <ul>
            <?php while($the_query->have_posts()): $the_query->the_post(); ?>
                <li>

                        <div class="col">
                                <div class="description text-center">
                                   <h2><?php _e('Blog','wedo-listing');?></h2>
                                   <h3><a href="<?php the_permalink();?>"> <?php the_title();?></a></h3>
                                   <h4><?php echo get_the_date('d F Y'); ?></h4>
                                   <p><?php c27()->the_excerpt(91) ?></p>
                                   <a href="<?php the_permalink();?>" class="buttons button-2"><?php _e('Read more about','wedo-listing');?></a>    

                                </div>
                             </div>
                             <div class="col">
                             <?php if(has_post_thumbnail( $post->ID )){
                               $url=wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
                                    <a href="<?php the_permalink();?>"> 
 <?php
	$media_id = giang_get_image_id($url); ;
	$alt = 'image';
	if($media_id) $alt = giang_get_media_alt( $media_id );
?>
                                <?php
$img_html = '<img class="blog-img" src="'.$url.'" alt="'. $alt .'">';
$img_html = apply_filters( 'bj_lazy_load_html', $img_html );
echo $img_html;
?></a>
                             <?php } ?>
                             </div>
                </li>
<?php endwhile;?>
            </ul>

            <div class="pagination">
                    <a href="#" class="pagination-btn prev-btn"><i aria-hidden="true" class="fa fa-angle-left"></i></a>
                    <a href="#" class="pagination-btn next-btn"><i aria-hidden="true" class="fa fa-angle-right"></i></a>
                 </div>


           </div>
        </div>
     </div>
      <?php endif; wp_reset_query();?>
     <div class="call-to-action">
        <div class="container">
           <div class="row">
              <div class="col-sm-9">
                 <p><?php the_field('get_a_quote_heading');?></p>
              </div>
              <div class="col-sm-3">
                 <a href="<?php the_field('get_a_quote_link');?>" class="buttons button-2"><?php _e('Ask for an estimate','wedo-listing');?></a>
              </div>
           </div>
        </div>
     </div>
<?php endwhile;?>
<?php get_footer();?>