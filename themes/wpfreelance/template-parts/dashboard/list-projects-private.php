<?php
/**
 * be included in page-dashboard and list all bidded of current Employer
 * Only available for Employer or Admin account.
**/

	global $user_ID;
	?>

<ul class="dashboard-tab   ul-list-project" id="dashboard-private">
	<?php
		$args = array(
		'post_type' => 'project',
		'author'=> $user_ID,
		'posts_per_page' => -1,
		'post_status' => 'private',
	);
	$query = new WP_Query($args);
	?>
	<li class="heading heading-table list-style-none padding-bottom-10">
		<div class ="col-md-5 "> <?php _e('Project Name','boxtheme'); ?></div>
		<div class ="col-md-2"><?php _e('Bids','boxtheme'); ?></div>
		<div class ="col-md-3"><?php _e('Time','boxtheme'); ?></div>
		<div class ="col-md-2 text-center pull-right "></div>
	</li>
	<?php
	if( $query-> have_posts() ){
		while ($query->have_posts()) {

			global $post;
			$query->the_post();
			$project = BX_Project::get_instance()->convert( $post );

			echo '<li class="list-style-none padding-bottom-10">';
				echo '<div class ="col-md-5 ">';	echo '<a class="primary-color project-title" href="'.get_permalink().'">'. get_the_title().'</a>';	echo '</div>';
				echo '<div class ="col-md-2">';echo count_bids($post->ID);	echo '</div>';
				echo '<div class ="col-md-3">';	echo get_the_date();	echo '</div>';	?>
				<div class ="col-md-2 pull-right text-right text-status text-capitalize">

					<a href="#" class="btn-board btn-archived-job" id="<?php echo $project->ID;?>"  data-toggle="tooltip" title="<?php printf(__('Archived %s','boxtheme'), $project->post_titile);?>">
						<i class="fa fa-archive" aria-hidden="true"></i>
					</a>

				</div>

			</li><?php		}
	} else { ?>
		<li class="no-result" style="padding-top: 20px; list-style:none">
			<p class="col-md-12"><?php _e('There are no projects in private.','boxtheme'); ?></p>
		</li> <?php
	}
	wp_reset_query(); ?>
</ul>