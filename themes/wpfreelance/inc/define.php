<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
	define("TRANSLATION_URL", get_template_directory() . "/languages");
	define( 'BO_LANG_DIR', WP_CONTENT_DIR . '/lang' );

	define( 'LOG_FILE', WP_CONTENT_DIR.'/box_log.log');
	define( 'ENABLE_LOG', true);
	define( 'PROJECT','project');
	define( 'BID','bid');
	define( 'FREELANCER','freelancer');
	define( 'EMPLOYER','employer');
	define( 'PROFILE', 'profile' );
	define( 'ORDER', '_order');
	define ('PRICE','price'); // price of package plan.
	//Profile meta
	define( 'HOUR_RATE', 'hour_rate' );
	define( 'HOUR_RATE_TEXT', 'hour_rate_text' );
	define( 'PROJECTS_WORKED', 'projects_worked' );

	define( 'COUNTRY','country');
	define('LOCATION_CAT','country');// replace for the country field


	// meta field of project
	define( 'BUDGET', '_budget');
	define( 'AWARDED', 'awarded' ); // project status
	define( 'DONE', 'done' ); // project status
	define( 'CLOSE', 'close' ); // project status
	define( 'ARCHIVED','archived');
	define ('BOX_VIEWS','_box_views');
	// publish => awarded => done =>close.

	define( 'DISPUTED', 'disputed' ); // project status
	define( 'WINNER_ID', '_winner_id');// freelancer ID of this project.

	//META field of BID
	define( 'BID_ID_WIN', 'bid_id_win');
	define( 'BID_PRICE','_bid_price');
	define( 'BID_DEALINE','_dealine');
	// comment meta
	define( 'RATING_SCORE','rating_score'); // rating score of employer for this biding.

	// define mate name of review  content;
	define('REVIEW_MSG','review_msg');
	//USER meta
	define('EMPLOYER_TYPE','employer_type');
	define( 'INDIVIDUAL','individual');
	define( 'COMPANY','company');
	define( 'SPENT', 'spent');
	define('TOTAL_SPENT_TEXT','total_spent');
	define( 'EARNED', 'earned' );
	define( 'EARNED_TXT', 'earned_txt' );
	define('BOX_CDN', FALSE);

?>