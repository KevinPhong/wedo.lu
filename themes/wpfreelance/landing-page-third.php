<?php
/**
 *	Template Name: LandingPage 3
 */
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
add_action('before_header_menu','box_add_div' );
function box_add_div(){
	echo '<div class="full cover-img"><div class="full opacity"></div>';
}
add_action('after_cover_img','box_after_cover_img' );
function box_after_cover_img(){
	echo '</div>';
}

$main_img = get_theme_mod('main_img',  get_template_directory_uri().'/img/banner.jpg' );
get_header(); ?>
<?php global $role;?>
<div class="full-width cover-content">
	<div class="container">
		<div class="heading-aligner">
	        <h1>#JOIN OUR FREELANCE COMMUNITY</h1>
	        <p class="text-center">We know it's hard to find a online expert when you need one,
	            which is why we've set on a mission to bring them all to one place.
	        </p>
	        <!-- CREATE PRODILE BUTTON -->

	        	<?php if ( !is_user_logged_in() ) { ?>
	        	 <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
	        		<a href="<?php echo box_get_static_link('signup');?>?role=hire" class="btn btn-action btn-primary-bg btn-biggest"> <?php _e('I want to hire','boxtheme');?></a>
	        	</div>
	        	 <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
	        		<a href="<?php echo box_get_static_link('signup');?>?role=work" class="btn btn-action btn-primary-bg btn-biggest"> <?php _e('I want to work','boxtheme');?></a>
	        	</div>
	        	<?php } else { ?>
	        		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6  text-right">

			        	<?php if($role == EMPLOYER){?>
			        		<a href="<?php echo get_post_type_archive_link(PROJECT);?>" class="btn btn-action btn-primary-bg btn-biggest"><?php _e('Find a Freelancer','boxtheme');?></a>
			            <?php } else {?>
			            	<a href="<?php echo get_post_type_archive_link(PROJECT);?>" class="btn btn-action btn-primary-bg btn-biggest"><?php _e('Find a Job','boxtheme');?></a>
			            <?php }?>
			        </div>
		        <?php } ?>

	        <!-- POST A PROJECT BUTTON -->
	        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
	        	<?php if( is_user_logged_in() ){ ?>
		        	<?php if( $role == EMPLOYER || current_user_can('manage_options' ) ){?>
		            	<a href="<?php echo box_get_static_link("post-project");?>" class="btn  find-btn btn-action btn-biggest"><?php _e('Post a Job','boxtheme');?></a>
		            <?php } ?>
	            <?php }?>
	        </div>
	    </div>
	</div>
</div>
<?php do_action('after_cover_img' );?>
<?php the_content();?>
<?php //get_template_part( 'static-block/one', 'how-we-work' );?>
<?php //get_template_part( 'static-block/one', 'why-us' );?>
<?php //get_template_part( 'static-block/one', 'package-plan' );?>
<?php //get_template_part( 'static-block/one', 'list-profiles' );?>
<?php // get_template_part( 'static-block/one', 'stats' );?>

<style type="text/css">
.cover-img{
		background:url('<?php echo $main_img;?>') top center no-repeat;
	    background-size: cover;
	}
	.cover-img, .opacity{
		height: 568px;
	}
	.opacity{
		opacity: 0.8;
		position: absolute;
		background-color: rgba(255, 255, 255, 0.18);
	}
	.cover-img .header{
		background-color: transparent;
	}
	.cover-img .header .container{
		border:none;
	}
	body.fixed .cover-img .header .container{
		background-color: #fff;
	}
	.cover-img .header nav ul li a{
		color: #fff;
	}
	body.fixed .cover-img .header nav ul li a{
		color: #666;
	}
	.cover-img ul.main-login .btn-login{
		background-color: transparent;
		border:none;
		box-shadow: 0 0 0 1px #fff, 0 0 0 1px #fff;
		color: #fff;
	}
	body.fixed .cover-img ul.main-login .btn-login{
		color: #666;
    	background-color: #ddd;
	}
	body.fixed .cover-img .header{
		background-color: #fff;
	}
	.cover-content{
		padding-top: 150px;
	}

/************* WHY PAYPAL */

.text-xs-center {
    text-align: center!important;
}
/*********************** END STATS */
.top-profile{
	background: transparent;
	padding:0 0 30px 0;
}
.top-profile .container{
	background: transparent;
	background-clip: content-box;
}
.top-profile .container h2{
	padding: 5px 0 15px 0;
	margin-top: 35px;
	text-align: center;
}

.workflow{
	padding: 20px 0 50px 0;
}
.workflow .nav-pills>li>a{
	border-radius: 0;
	text-transform: uppercase;
}
#exTab1 .tab-content {
  padding : 5px 0;
}
.workflow .nav{
	border-bottom: 1px solid #ccc;
}
.packge-plan{
	padding: 60px 0 60px 0;
	background-color: #6c7378;
    background-image: radial-gradient(circle farthest-side at center bottom,#6c7378,#2c2e2f 125%);
    border-bottom: 1px solid #ccc;
}
.packge-plan .package-item{
	margin-bottom: 10px;
}
.pricing-table-plan {
    padding: 2em;
    text-align: center;
    width: 100%;
    background-color: #fff;
}
.plan-monthly {
    font-size: 2.5em;
    line-height: 140%;
    padding: 15px 0;
    font-family: tahoma;
}
.plan-monthly span{

}
.btn.btn-orange:hover {
    background-color: #f99e34 !important;
}
.plan-name {
    font-size: 1.75em;
    font-weight: 600;
    line-height: 100%;
    padding: .4em 0;
    text-transform: uppercase;
}
.plan-features {
    width: 100%;
    margin: 0.5em 0;
    padding: 1em 0;
    list-style: none;
    border-top: 1px solid #DFDFD0;
    text-align: center;
    min-height: 175px;
}
.plan-features ul{
	list-style: none;
    max-width: 219px;
    margin: 0 auto;
}
.plan-features  li {
    padding: 5px;
    font-size: .9375em;
    display: table;
    width: 100%;
    height: 3rem;
}
.plan-features > li span, .plan-features > li a {
    display: table-cell;
    vertical-align: middle;
}
.pricing-table-plan span{
	display: block;
}
.pricing-table-plan span.currency-icon{
	display: inline;
}
.pack-des{
	min-height: 130px;
	text-align: left;
}
.pack-des p{
	margin: 0;
}

@media only screen and (max-width: 768px) {
	.heading-aligner h1{
		font-size: 25px;
		line-height: 35px;
	}
	.heading-aligner > p{
		padding: 25px 20px 0;
	}
	.main-banner{
		height: 450px;
		min-height: 400px;
		padding-top: 50px;
	}
	.top-profile .container{
		background-clip: initial;
	}
	.archive-profile-item .col-md-3{
		padding-left: 0;
	}
	.archive-profile-item .col-xs-8{
		padding-right: 0;
	}
	.col-md-6.archive-profile-item .full{
		padding: 0;
	}
	.archive-profile-item .col-xs-12{
		padding-right: 0;
	}


	.archive-profile-item .col-xs-12{
		padding-left: 15px;
	}
	.container{
		padding-left: 10px;
		padding-right: 10px;
	}

	.small, small{
		font-size: 100%;
	}
	.top-profile .profile-item{
		padding-bottom1: 20px;
	}
	.why-wpfreelance .elementor-element, .why-wpfreelance  .elementor-element-populated,
	.why-wpfreelance .elementor-image-box-img,
	.how-us-work .elementor-element-populated {
		padding-top: 0 !important;
		padding-bottom: 0 !important;
		margin:0 !important;
	}
	.how-us-work .elementor-image-box-description{
		padding-bottom: 15px;
	}
	.why-wpfreelance .elementor-image-box-img {
		float: left !important;
		width: 100% !important;
		clear: both;
		text-align: left;
	}
	.elementor-widget-heading .elementor-heading-title, .top-profile .elementor-heading-title{
		font-size: 25px !important;
	}
}
.how-us-work{
	padding: 50px 0;
	background: #fff;
}
.how-us-work .a-step{
	padding-bottom: 30px;
}
.how-us-work .col-md-3 .full{
	padding: 0 6px;
}
.how-us-work .col-md-3 h3{
	border-bottom: 3px solid #ccc;
	display: inline-block;
	clear: both;
	padding: 0 5px 10px 5px  ;
}
.img_main{
	height: 100px;
	position: relative;
}
.img_main img{
	vertical-align: bottom;
}
.top-profile .profile-item{
    overflow: hidden;
    margin-top: 30px;
    height: 179px;
}
body.home .site-container{
	min-height: 0;
}
.cover-img .header{
	position: fixed;
}
.box-bg{
	background-color: #fff;
	overflow: hidden;
	display: block;
	padding: 20px 0;
	box-shadow: 0px 2px 1px 0px #efefef;
}
.view-all {
    margin-top: 20px;
    float: right;
    border-bottom: 2px solid #5cb85c;
    padding: 6px 5px 6px 16px;
    background: #fff;
}
.why-paypal .organism__header__headline{
	padding: 0 15px;
}
.list-skill{
	overflow: hidden;
}
.why-wpfreelance,.why-wpfreelance-heading{
    color: #fff;
}
.why-wpfreelance{
    background-color: #00717b;
    background-image: radial-gradient(circle farthest-side at center bottom,#36aab3,#037782 124%);
    padding: 60px;
}
.why-wpfreelance *{
	color:#fff;
}
.why-wpfreelance .elementor-widget-image-box .elementor-image-box-content .elementor-image-box-description{
	color: #fff;
}
.why-wpfreelance .elementor-element.elementor-element-2578eb20 .elementor-image-box-content .elementor-image-box-title,
.why-wpfreelance  .elementor-widget-image-box .elementor-image-box-content .elementor-image-box-title{
	color: #fff;
}
.why-wpfreelance  .elementor-element.elementor-element-2578eb20.elementor-position-top .elementor-image-box-img img{
	float: left;
}
.elementor-widget-image-box .elementor-image-box-content{
	text-align: left;
}
.why-wpfreelance .elementor-widget-image-box.elementor-position-left .elementor-image-box-wrapper,
.how-us-work .elementor-widget-image-box.elementor-position-left .elementor-image-box-wrapper{
	display: block;
}

.why-wpfreelance  .elementor-element.elementor-element-75a0ab55 > .elementor-widget-container{
	padding-bottom: 0;
}

.why-wpfreelance .elementor-widget-heading .elementor-heading-title {  color: #fff;}
.elementor-widget-heading .elementor-heading-title, .top-profile .elementor-heading-title{
	font-size: 32px;
    font-family: 'Raleway', sans-serif;
    z-index: 100;
}
.top-profile .elementor-heading-title{
	color: #666;
}
.why-wpfreelance-heading .elementor-row .elementor-heading-title,
.how-us-work .elementor-row .elementor-heading-title,{
	z-index: 100;
	height: 30px;
}
.why-wpfreelance  .elementor-image-box-content .elementor-image-box-description a{
	clear: both;
	display: block;
	margin-top: 25px;
	font-weight: 700;
}
.how-us-work .elementor-element .elementor-image-box-wrapper .elementor-image-box-img{
	width: 100% !important;
	clear: both;
}
.packge-plan .elementor-element-populated{
	padding: 0 !important;
}
.how-us-work .elementor-element .elementor-image-box-content .elementor-image-box-title{
	text-align: center;
	border-bottom: 3px solid #ccc;
    display: inline-block;
    clear: both;
    padding: 0 5px 10px 5px;
}
.how-us-work  .elementor-widget-image-box .elementor-image-box-content{
	text-align: center;
}
</style>

<?php get_footer();
