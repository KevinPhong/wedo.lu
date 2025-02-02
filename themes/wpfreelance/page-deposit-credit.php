<?php
/**
 *Template Name: Deposit Credit
 */
?>
<?php get_header(); ?>

	<div class="container site-container">
		<div class="site-content" id="content" >
			<div class="col-md-8 col-sm-offset-2">
				<?php the_post(); $packages = array(); ?>
				<h1><?php the_title();?></h1>
				<?php if( is_user_logged_in() ){ ?>
				<form class="frm-buy-credit frm-main-checkout">
					<div class="step step-1">
						<div class="form-group">
						    <h3  class="col-sm-12 col-form-label"><span class="bg-color">1</span> <?php _e('Select a package','boxtheme');?></h3>
					    	<?php
					    	 $args = array(
	                            'post_type' => '_package',
	                            'meta_key' => 'pack_type',
	                            'meta_value' => 'buy_credit'
	                        );

	                        $the_query = new WP_Query($args);
	                        $g_id  = isset($_GET['id']) ? $_GET['id'] : '';
	                        // The Loop
	                        $key = 0;
	                        if ( $the_query->have_posts() ) {
	                        	 while ( $the_query->have_posts() ) {
	                                $the_query->the_post();
	                                global $post;


	                                $post->price = get_post_meta(get_the_ID(),'price', true);
	                                $post->sku = get_post_meta(get_the_ID(),'sku', true);

	                               	array_push( $packages, $post);
	                                ?>
	                                <div class="col-sm-12  package-plan record-line <?php if( get_the_ID() == $g_id ) echo 'activate';?>">
								    	<div class="col-sm-9">
								    		<div class="col-md-8 no-padding-left"><h2 class="pack-name"><?php the_title();?></h2></div><div class="col-md-4 primary-color"><h4 class="pack-price"> <?php box_price($post->price);?> </h4></div>
								    		<div class="pack-detail col-md-12 no-padding-left"><?php echo get_the_content(); ?></div>

								    	</div>
								    	<div class="col-sm-3 align-right">
									    	<label>
									    		<input type="radio"<?php if( $post->ID == $g_id) echo 'checked'; ?> class="required radio radio-package-item" value="<?php echo get_the_ID();?>"  name="package_id" required >

									    		<span class=" no-radius btn align-right btn-select btn-slect-package" id="<?php echo $key;?>" ><span class="default"><?php _e('Select','boxtheme');?></span><span class="activate"><?php _e('Selected','boxtheme');?></span></span>
									    	</label>
								    	</div>
								    	<div class="full f-left"></div>
								    </div>
	                                <?php $key ++;

	                            }
	                              wp_reset_postdata();
	                        } else {
	                        	_e('There is not any packages yet','boxtheme');
	                        }

						?>
					    </div>
					</div>
					<div class="step step-2">
						<?php $label = __('Select a payment method','boxtheme');?>
						<?php bo_list_paymentgateways($label);?>
					</div>
					<div class="form-group">
						<button class="btn f-right no-radius btn-submit disable" type="submit"><?php _e('Check Out','boxtheme');?> <i class="fa fa-spinner fa-spin"></i></button>
					</div>

				</form>
				<?php } else { ?>
				<?php _e('Please login to buy credit','boxtheme');?>
				<?php }?>
				<!-- PAYPAL FORM !-->

			    <?php
               // $paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
               // $return     = box_get_static_link('process-payment');
                ?>
               <!--  <div class="col-md-4">
                	<h2> Test PayPal</h2>
                    <form class="paypal" action="<?php // echo $paypal_url; ?>" method="GET" id="paypal_form">
                        <input type="hidden" name="cmd" value="_xclick" />
                        <input type="hidden" name="currency_code" value="USD" />
                        <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
                        <input type="hidden" name="first_name" value="Customer's First Name"  />
                        <input type="hidden" name="last_name" value="Customer's Last Name"  />
                        <input type="hidden" name="payer_email" value="freelancer@testing.com"  />
                        <input type="hidden" name="business" value="testing@etteam.com">
                        <input type="hidden" name="item_number" id="item_number" value="123" / >
                        <input type="hidden" name="job_id" id="job_id" value="999" / >
                        <input type="hidden" name="item_name" value="Deposite credit" / >
                        <input type="hidden" name="custom" id="custom_field" value="123">
                        <input type="hidden" name="amount" value="1" / >
                        <input type="hidden" name="return" value="<?php //echo $return?>" / >
                        <input type="hidden" name="cancel_return" value="<?php //echo $return;?>" / >
                        <input type="hidden" name="notify_url" value="<?php //echo $return;?>" / >
                        <input type="submit" name="submit" class="btn btn-green" value="Select"/>
                    </form>
                    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">

					  <!- Identify your business so that you can collect the payments. -->

					  <!-- <input type="hidden" name="business" value="contact@boxthemes.net">
					  <input type="hidden" name="cmd" value="_xclick">
					  <input type="hidden" name="item_name" value="Hot Sauce-12oz. Bottle">
					  <input type="hidden" name="amount" value="5.95">
					  <input type="hidden" name="currency_code" value="USD">
					  <input type="hidden" name="return" value="<?php //echo $return?>" / >
					  <!- Display the payment button.

					  <input type="image" name="submit" border="0"
					  src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_buynow_107x26.png"
					  alt="Buy Now">
					  <img alt="" border="0" width="1" height="1"
					  src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >

					</form>
                </div> -->
			    <!-- END PAYPAL !-->

			</div>

		</div>
	</div>
</div>
<script type="text/template" id="json_packages"><?php   echo json_encode($packages); ?></script>
<?php get_footer();?>

