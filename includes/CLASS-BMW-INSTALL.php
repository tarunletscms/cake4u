<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}

/**
 * BMW_INSTALL Class.
 */

class BMW_INSTALL {

	
	private static $background_updater;

	/**
	 * Hook in tabs.
	 */
	public static function init() { 
		 add_filter( 'plugin_action_links_' . BMW_PLUGIN_BASENAME, array( __CLASS__, 'plugin_action_links' ) );
		
	}



	/**
	 * Install BMP.
	 */
	public static function install() {
		if ( ! is_blog_installed() ) {
			return;
		}

		self::create_tables(); 
		self::create_roles();
		self::insert_table_data();
		self::create_pages();
		
	}

	
	private static function create_tables() {
		global $wpdb;
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		$wpdb->hide_errors();
		$get_tables=self::get_schema();
		foreach($get_tables as $get_table){
			dbDelta($get_table);	
			
		}
		
		
	}

	private static function get_schema() { 
		global $wpdb;
		$tables = array();
		$collate = '';

		if ( $wpdb->has_cap( 'collation' ) ) {
			$collate = $wpdb->get_charset_collate();
		}
	
$tables[] = "CREATE TABLE {$wpdb->prefix}bmw_users (
			`id` BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`user_id` BIGINT(20) NOT NULL COMMENT 'foreign key of the {$wpdb->prefix}users table',
			`user_name` VARCHAR(60) NOT NULL ,
			`user_key` VARCHAR(15) NOT NULL ,
			`parent_key` VARCHAR(15) NOT NULL ,
			`sponsor_key` VARCHAR(15) NOT NULL ,
			`position` ENUM('right', 'left') NOT NULL,
			`qualified_points` DOUBLE(25,3) NOT NULL DEFAULT '0.000',
			`own_points` DOUBLE(25,3) NOT NULL DEFAULT '0.000',
			`left_points` DOUBLE(25,3) NOT NULL DEFAULT '0.000',
			`right_points` DOUBLE(25,3) NOT NULL DEFAULT '0.000',
			`creation_date` TINYTEXT NOT NULL DEFAULT '0000-00-00 00:00:00',
			`payment_status` ENUM(  '0',  '1' ) NOT NULL DEFAULT '0' COMMENT ' 0 indicate unpaid AND 1 indicate paid',
			`payment_date` TINYTEXT NOT NULL DEFAULT '0000-00-00 00:00:00',
			`network_row` BIGINT(20) NOT NULL,
			`leader_post` INT(11) NOT NULL,
			KEY index_user_key (user_key),
			KEY index_parent_key (parent_key),
			KEY index_sponsor_key (sponsor_key),
			UNIQUE (user_name)
			) $collate;"; 
$tables[] = "CREATE TABLE {$wpdb->prefix}bmw_hierarchy (
			`id` BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`user_key` VARCHAR(25) NOT NULL,
			`parent_key` VARCHAR(25) NOT NULL,
			`sponsor_key` VARCHAR(25) NOT NULL,
			`position` ENUM('0','1') NOT NULL DEFAULT '0',
			`payout_id` INT(11) default 0,
			`bonus_status` ENUM('0','1') NOT NULL DEFAULT '0',
			`commission_status` ENUM('0','1') NOT NULL DEFAULT '0',
			`n_row` BIGINT(20) NOT NULL,
			`status` ENUM('0','1') NOT NULL DEFAULT '0',
			KEY index_sponsor_key (sponsor_key),
			KEY index_parent_key (parent_key),
			KEY index_user_key (user_key)
			) $collate;";

$tables[] = "CREATE TABLE {$wpdb->prefix}bmw_phone_codes (
			  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			  `iso` VARCHAR(10) NOT NULL,
			  `country_name` VARCHAR(80) NOT NULL,
			  `country_nicename` VARCHAR(250) NOT NULL,
			  `iso3` VARCHAR(8) DEFAULT NULL,
			  `phonecode` INT(15) NOT NULL
			   ) $collate;";
$tables[] = "CREATE TABLE {$wpdb->prefix}bmw_pair_commission (
			`id` BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`user_key` VARCHAR(25) NOT NULL,
			`childs` MEDIUMTEXT NOT NULL,
			`amount` DOUBLE(25,3) NOT NULL DEFAULT 0.00 ,
			`status` int(2) NOT NULL ,
			`payout_id` int(25) NOT NULL DEFAULT '0',
			`insert_date` TINYTEXT NOT NULL DEFAULT '0000-00-00 00:00:00',
			`paid_price` BIGINT(20) NOT NULL,
			KEY index_user_key (user_key)
			) $collate;";
$tables[] = "CREATE TABLE {$wpdb->prefix}bmw_level_commission (
			`id` BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`user_key` VARCHAR(25) NOT NULL,
			`sponsor_key` VARCHAR(25) NOT NULL,
			`amount` DOUBLE(25,3) NOT NULL DEFAULT 0.00 ,
			`level` int(11) NOT NULL ,
			`status` int(2) NOT NULL ,
			`payout_id` int(25) NOT NULL DEFAULT '0',
			`insert_date` TINYTEXT NOT NULL DEFAULT '0000-00-00 00:00:00',
			KEY index_user_key (user_key),
			KEY index_sponsor_key (sponsor_key)
			) $collate;";
$tables[] = "CREATE TABLE {$wpdb->prefix}bmw_bonus_commission (
			`id` BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`user_key` VARCHAR(25) NOT NULL,
			`amount` DOUBLE(10,2) NOT NULL DEFAULT 0.00,
			`bonus_count` BIGINT(25) NOT NULL,
			`status` INT(2) NOT NULL DEFAULT '0',
			`payout_id` int(11) NOT NULL DEFAULT '0',
			`insert_date` TINYTEXT NOT NULL DEFAULT '0000-00-00 00:00:00',
			KEY index_user_key (user_key)
			) $collate;";
$tables[] = "CREATE TABLE {$wpdb->prefix}bmw_bank_details (
			`id` BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`user_key` VARCHAR(25) NOT NULL,
			`account_holder` VARCHAR(255) NOT NULL,
			`account_number` VARCHAR(255) NOT NULL,
			`bank_name` VARCHAR(255) NOT NULL,
			`branch` VARCHAR(255) NOT NULL,
			`ifsc_code` VARCHAR(25) NOT NULL,
			`contact_number` VARCHAR(25) NOT NULL,
			`insert_date` TINYTEXT NOT NULL DEFAULT '0000-00-00 00:00:00',
			KEY index_user_key (user_key)
			) $collate;";
$tables[] = "CREATE TABLE {$wpdb->prefix}bmw_payout_master (
			`payout_id` int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`total_payout` DOUBLE(25,3)  NOT NULL DEFAULT '0.00',
			`insert_date` TINYTEXT NOT NULL DEFAULT '0000-00-00 00:00:00'
			) $collate;";
$tables[] = "CREATE TABLE {$wpdb->prefix}bmw_payout (
			`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`user_key` VARCHAR(25) NOT NULL,
			`payout_id` int(10) unsigned NOT NULL,
			`pair_commission` DOUBLE(25,3) NOT NULL DEFAULT '0.00',
			`referral_commission` DOUBLE(25,3) NOT NULL DEFAULT '0.00',
			`faststart_commission` DOUBLE(25,3) NOT NULL DEFAULT '0.00',
			`leadership_commission` DOUBLE(25,3) NOT NULL DEFAULT '0.00',
			`level_commission` DOUBLE(25,3) NOT NULL DEFAULT '0.00',
			`one_time_bonus` DOUBLE(25,3) DEFAULT '0.00',
			`total_points` DOUBLE(25,3) NOT NULL DEFAULT '0.00',
			`total_amount` DOUBLE(25,3) NOT NULL DEFAULT '0.00',
			`total_bonus` DOUBLE(25,3) NOT NULL DEFAULT '0.00',
			`tax` DOUBLE(25,3) DEFAULT '0.00',
			`service_charge` DOUBLE(25,3) DEFAULT '0.00',
			`insert_date` TINYTEXT NOT NULL DEFAULT '0000-00-00 00:00:00'
			) $collate;";
$tables[] = "CREATE TABLE {$wpdb->prefix}bmw_withdrawal (
			`id` BIGINT(20) NOT NULL  AUTO_INCREMENT PRIMARY KEY,
			`user_id` BIGINT(20) NOT NULL,
			`amount`  double(16,2) NOT NULL,
			`withdrawal_fee`  double(16,2) NOT NULL,
			`witholding_tax` double(16,2) DEFAULT '0.00',
			`tax_status` ENUM('0','1') DEFAULT '0',
			`withdrawal_initiated` TINYINT NOT NULL,
			`withdrawal_mode` VARCHAR(200) NOT NULL,
			`other_method` VARCHAR(200) NOT NULL,
			`withdrawal_initiated_comment` VARCHAR(200) NOT  NULL,
			`withdrawal_initiated_date` TINYTEXT NOT NULL DEFAULT '0000-00-00 00:00:00',
			`payment_processed` TINYINT NOT NULL,
			`payment_processed_date` DATE NOT NULL,
			`payment_mode` VARCHAR(100) NOT NULL,
			`transaction_id` VARCHAR(100) NOT NULL,
			`user_bank_name` VARCHAR(250) NOT NULL,
			`user_bank_account_no` VARCHAR(55) NOT NULL
			) $collate;";
$tables[] = "CREATE TABLE {$wpdb->prefix}bmw_mail_settings (
			`id` int(20) unsigned NOT NULL AUTO_INCREMENT primary key,
			`mail_name` VARCHAR(255) NOT NULL,
			`mail_to` VARCHAR(255) NOT NULL,
			`mail_from` VARCHAR(255) NOT NULL,
			`mail_subject` TEXT NOT NULL,
			`mail_message` LONGTEXT NOT NULL
			) $collate;";
$tables[] = "CREATE TABLE {$wpdb->prefix}bmw_referral_commission (
			`id` BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`user_key` BIGINT(20) NOT NULL,
			`child_key` VARCHAR(60) NOT NULL,
			`amount` DOUBLE(25,3) NOT NULL DEFAULT 0.000,
			`status` int(2) NOT NULL DEFAULT '0',
			`payout_id` int(11) NOT NULL DEFAULT '0',
			`order_id` BIGINT NOT NULL DEFAULT 0,
			`date_notified` TINYTEXT NOT NULL DEFAULT '0000-00-00 00:00:00',
			KEY index_user_key (user_key)
			) $collate;";
$tables[] = "CREATE TABLE {$wpdb->prefix}bmw_orders (
			`id` BIGINT(25) unsigned NOT NULL auto_increment PRIMARY KEY,
			`order_id` BIGINT(25) NOT NULL UNIQUE KEY,
			`user_id` int(11) NULL,
			`total_amount` DOUBLE(25,3) NOT NULL,
			`total_points` DOUBLE(25,3) NOT NULL,
			`order_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			`status` int(11) NOT NULL DEFAULT '0'
			) $collate;";
$tables[] = "CREATE TABLE {$wpdb->prefix}bmw_faststart_bonus_commission (
		 	`id` BIGINT(25) unsigned NOT NULL auto_increment PRIMARY KEY,
	   	`user_key` BIGINT(20) NOT NULL,
			`amount` DOUBLE(25,3) NOT NULL,
			 `insert_date` datetime NOT ,
			  `status` int(2) NOT NULL,
			  `bonus_amount` double(15,3) NOT NULL,
			  `payout_id` bigint(18) NOT NULL
			) $collate;";
$tables[] = "CREATE TABLE {$wpdb->prefix}bmw_leadership_bonus_commission (
		 	`id` BIGINT(25) unsigned NOT NULL auto_increment PRIMARY KEY,
	   	`user_key` BIGINT(20) NOT NULL,
			`amount` DOUBLE(25,3) NOT NULL,
			 `insert_date` datetime NOT NULL ,
			 `leadership_bonus` BIGINT(20) NOT NULL,
			  `status` int(2) NOT NULL,
			  `bonus_type` int(5) NOT NULL,
			  `payout_id` bigint(18) NOT NULL
			) $collate;";
$tables[] = "CREATE TABLE {$wpdb->prefix}bmw_leadership_commission_setting (
		 	`id` BIGINT(25) unsigned NOT NULL auto_increment PRIMARY KEY,
	    `leader_name` varchar(50) NOT NULL,
		  `personal_sponsor` int(5) NOT NULL,
		  `personal_volume` double(15,3) NOT NULL,
		  `inline_leader_count` int(4) NOT NULL,
		  `Leader_type` int(3) NOT NULL,
		  `group_volume` double(15,3) NOT NULL,
		  `one_time_bonus` double(15,3) NOT NULL,
		  `binary_bonus` double(15,3) NOT NULL,
		  `leadership_bonus` double(15,3) NOT NULL
			) $collate;";
$tables[] = "CREATE TABLE {$wpdb->prefix}bmw_leader_one_time_bonus (
		 	`id` BIGINT(25) unsigned NOT NULL auto_increment PRIMARY KEY,
	     `user_key` varchar(15) NOT NULL,
		  `amount` double(25,3) NOT NULL,
		  `status` int(2) NOT NULL,
		  `leader_post` varchar(30) NOT NULL,
		  `insert_date` datetime NOT NULL ,
		  `payout_id` int(11) NOT NULL
			) $collate;";
$tables[] = "CREATE TABLE {$wpdb->prefix}bmw_point_transaction(
			`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`user_key` VARCHAR(25) NOT NULL,
			`details` TEXT NOT NULL,
			`debit_own` DOUBLE(25,3) NOT NULL,
			`debit_left` DOUBLE(25,3) NOT NULL,
			`debit_right` DOUBLE(25,3) NOT NULL,
			`credit_own` DOUBLE(25,3) NOT NULL,
			`credit_left` DOUBLE(25,3) NOT NULL,
			`credit_right` DOUBLE(25,3) NOT NULL,
			`type` TINYTEXT NOT NULL,
			`date` TINYTEXT NOT NULL DEFAULT '0000-00-00 00:00:00',
			`status` INT(2) NOT NULL
			) $collate;";


		return $tables;
	}


/**
 * Create roles and capabilities.
 */
public static function create_roles() {
	global $wp_roles;

	if ( ! class_exists( 'WP_Roles' ) ) {
		return;
	}

	if ( ! isset( $wp_roles ) ) {
		$wp_roles = new WP_Roles();
	}
	
	add_role('bmw_user','BMW USER',array('read' => false,));

	$capabilities = self::get_core_capabilities();

    foreach ( $capabilities as $cap_group ) {
      foreach ( $cap_group as $cap ) {
        $wp_roles->add_cap( 'bmw_user', $cap );
        $wp_roles->add_cap( 'administrator', $cap );
      }
    }
}



private static function get_core_capabilities() {
    $capabilities = array();

    $capabilities['core'] = array(
      'manage_bmw',
    );

    return $capabilities;
  }

	
/**
 * Show action links on the plugin screen.
 *
 * @param mixed $links Plugin Action links.
 *
 * @return array
 */
public static function plugin_action_links( $links ) {
	$action_links = array(
		'settings' => '<a href="' . admin_url( 'admin.php?page=bmw-settings' ) . '" aria-label="' . esc_attr__( 'View Binary MLM WooCommerce Settings', 'BMW' ) . '">' . esc_html__( 'Settings', 'BMW' ) . '</a>',
	);

	return array_merge( $action_links, $links );
}


public static function insert_table_data(){
	global $wpdb;
		
		$phone_codes="INSERT INTO {$wpdb->prefix}bmw_phone_codes (`iso`, `country_name`, `country_nicename`, `iso3`, `phonecode`) VALUES
		('AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', '93'),
		('AL', 'ALBANIA', 'Albania', 'ALB', '355'),
		('DZ', 'ALGERIA', 'Algeria', 'DZA', '213'),
		('AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', '1684'),
		('AD', 'ANDORRA', 'Andorra', 'AND', '376'),
		('AO', 'ANGOLA', 'Angola', 'AGO', '244'),
		('AI', 'ANGUILLA', 'Anguilla', 'AIA', '1264'),
		('AQ', 'ANTARCTICA', 'Antarctica', NULL, '672'),
		('AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', '1268'),
		('AR', 'ARGENTINA', 'Argentina', 'ARG', '54'),
		('AM', 'ARMENIA', 'Armenia', 'ARM', '374'),
		('AW', 'ARUBA', 'Aruba', 'ABW', '297'),
		('AU', 'AUSTRALIA', 'Australia', 'AUS', '61'),
		('AT', 'AUSTRIA', 'Austria', 'AUT', '43'),
		('AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', '994'),
		('BS', 'BAHAMAS', 'Bahamas', 'BHS', '1242'),
		('BH', 'BAHRAIN', 'Bahrain', 'BHR', '973'),
		('BD', 'BANGLADESH', 'Bangladesh', 'BGD', '880'),
		('BB', 'BARBADOS', 'Barbados', 'BRB', '1246'),
		('BY', 'BELARUS', 'Belarus', 'BLR', '375'),
		('BE', 'BELGIUM', 'Belgium', 'BEL', '32'),
		('BZ', 'BELIZE', 'Belize', 'BLZ', '501'),
		('BJ', 'BENIN', 'Benin', 'BEN', '229'),
		('BM', 'BERMUDA', 'Bermuda', 'BMU', '1441'),
		('BT', 'BHUTAN', 'Bhutan', 'BTN', '975'),
		('BO', 'BOLIVIA', 'Bolivia', 'BOL', '591'),
		('BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', '387'),
		('BW', 'BOTSWANA', 'Botswana', 'BWA', '267'),
		('BV', 'BOUVET ISLAND', 'Bouvet Island', NULL, '47'),
		('BR', 'BRAZIL', 'Brazil', 'BRA', '55'),
		('IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', NULL, '246'),
		('BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', '673'),
		('BG', 'BULGARIA', 'Bulgaria', 'BGR', '359'),
		('BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', '226'),
		('BI', 'BURUNDI', 'Burundi', 'BDI', '257'),
		('KH', 'CAMBODIA', 'Cambodia', 'KHM', '855'),
		('CM', 'CAMEROON', 'Cameroon', 'CMR', '237'),
		('CA', 'CANADA', 'Canada', 'CAN', '1'),
		('CV', 'CAPE VERDE', 'Cape Verde', 'CPV', '238'),
		('KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', '1345'),
		('CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', '236'),
		('TD', 'CHAD', 'Chad', 'TCD', '235'),
		('CL', 'CHILE', 'Chile', 'CHL', '56'),
		('CN', 'CHINA', 'China', 'CHN', '86'),
		('CX', 'CHRISTMAS ISLAND', 'Christmas Island', NULL, '61'),
		('CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', NULL, '672'),
		('CO', 'COLOMBIA', 'Colombia', 'COL', '57'),
		('KM', 'COMOROS', 'Comoros', 'COM', '269'),
		('CG', 'CONGO', 'Congo', 'COG', '242'),
		('CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', '242'),
		('CK', 'COOK ISLANDS', 'Cook Islands', 'COK', '682'),
		('CR', 'COSTA RICA', 'Costa Rica', 'CRI', '506'),
		('CI', 'COTE DIVOIRE', 'Cote DIvoire', 'CIV', '225'),
		('HR', 'CROATIA', 'Croatia', 'HRV', '385'),
		('CU', 'CUBA', 'Cuba', 'CUB', '53'),
		('CY', 'CYPRUS', 'Cyprus', 'CYP', '357'),
		('CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', '420'),
		('DK', 'DENMARK', 'Denmark', 'DNK', '45'),
		('DJ', 'DJIBOUTI', 'Djibouti', 'DJI', '253'),
		('DM', 'DOMINICA', 'Dominica', 'DMA', '1767'),
		('DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', '1809'),
		('EC', 'ECUADOR', 'Ecuador', 'ECU', '593'),
		('EG', 'EGYPT', 'Egypt', 'EGY', '20'),
		('SV', 'EL SALVADOR', 'El Salvador', 'SLV', '503'),
		('GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', '240'),
		('ER', 'ERITREA', 'Eritrea', 'ERI', '291'),
		('EE', 'ESTONIA', 'Estonia', 'EST', '372'),
		('ET', 'ETHIOPIA', 'Ethiopia', 'ETH', '251'),
		('FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', '500'),
		('FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', '298'),
		('FJ', 'FIJI', 'Fiji', 'FJI', '679'),
		('FI', 'FINLAND', 'Finland', 'FIN', '358'),
		('FR', 'FRANCE', 'France', 'FRA', '33'),
		('GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', '594'),
		('PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', '689'),
		('TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', NULL, '262'),
		('GA', 'GABON', 'Gabon', 'GAB', '241'),
		('GM', 'GAMBIA', 'Gambia', 'GMB', '220'),
		('GE', 'GEORGIA', 'Georgia', 'GEO', '995'),
		('DE', 'GERMANY', 'Germany', 'DEU', '49'),
		('GH', 'GHANA', 'Ghana', 'GHA', '233'),
		('GI', 'GIBRALTAR', 'Gibraltar', 'GIB', '350'),
		('GR', 'GREECE', 'Greece', 'GRC', '30'),
		('GL', 'GREENLAND', 'Greenland', 'GRL', '299'),
		('GD', 'GRENADA', 'Grenada', 'GRD', '1473'),
		('GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', '590'),
		('GU', 'GUAM', 'Guam', 'GUM', '1671'),
		('GT', 'GUATEMALA', 'Guatemala', 'GTM', '502'),
		('GN', 'GUINEA', 'Guinea', 'GIN', '224'),
		('GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', '245'),
		('GY', 'GUYANA', 'Guyana', 'GUY', '592'),
		('HT', 'HAITI', 'Haiti', 'HTI', '509'),
		('HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', NULL, '672'),
		('VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', '39'),
		('HN', 'HONDURAS', 'Honduras', 'HND', '504'),
		('HK', 'HONG KONG', 'Hong Kong', 'HKG', '852'),
		('HU', 'HUNGARY', 'Hungary', 'HUN', '36'),
		('IS', 'ICELAND', 'Iceland', 'ISL', '354'),
		('IN', 'INDIA', 'India', 'IND', '91'),
		('ID', 'INDONESIA', 'Indonesia', 'IDN', '62'),
		('IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', '98'),
		('IQ', 'IRAQ', 'Iraq', 'IRQ', '964'),
		('IE', 'IRELAND', 'Ireland', 'IRL', '353'),
		('IL', 'ISRAEL', 'Israel', 'ISR', '972'),
		('IT', 'ITALY', 'Italy', 'ITA', '39'),
		('JM', 'JAMAICA', 'Jamaica', 'JAM', '1876'),
		('JP', 'JAPAN', 'Japan', 'JPN', '81'),
		('JO', 'JORDAN', 'Jordan', 'JOR', '962'),
		('KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', '7'),
		('KE', 'KENYA', 'Kenya', 'KEN', '254'),
		('KI', 'KIRIBATI', 'Kiribati', 'KIR', '686'),
		('KP', 'KOREA, DEMOCRATIC PEOPLE''S REPUBLIC OF', 'Korea, Democratic People''s Republic of', 'PRK', '850'),
		('KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', '82'),
		('KW', 'KUWAIT', 'Kuwait', 'KWT', '965'),
		('KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', '996'),
		('LA', 'LAO PEOPLE''S DEMOCRATIC REPUBLIC', 'Lao People''s Democratic Republic', 'LAO', '856'),
		('LV', 'LATVIA', 'Latvia', 'LVA', '371'),
		('LB', 'LEBANON', 'Lebanon', 'LBN', '961'),
		('LS', 'LESOTHO', 'Lesotho', 'LSO', '266'),
		('LR', 'LIBERIA', 'Liberia', 'LBR', '231'),
		('LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', '218'),
		('LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', '423'),
		('LT', 'LITHUANIA', 'Lithuania', 'LTU', '370'),
		('LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', '352'),
		('MO', 'MACAO', 'Macao', 'MAC', '853'),
		('MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', '389'),
		('MG', 'MADAGASCAR', 'Madagascar', 'MDG', '261'),
		('MW', 'MALAWI', 'Malawi', 'MWI', '265'),
		('MY', 'MALAYSIA', 'Malaysia', 'MYS', '60'),
		('MV', 'MALDIVES', 'Maldives', 'MDV', '960'),
		('ML', 'MALI', 'Mali', 'MLI', '223'),
		('MT', 'MALTA', 'Malta', 'MLT', '356'),
		('MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', '692'),
		('MQ', 'MARTINIQUE', 'Martinique', 'MTQ', '596'),
		('MR', 'MAURITANIA', 'Mauritania', 'MRT', '222'),
		('MU', 'MAURITIUS', 'Mauritius', 'MUS', '230'),
		('YT', 'MAYOTTE', 'Mayotte', NULL, '269'),
		('MX', 'MEXICO', 'Mexico', 'MEX', '52'),
		('FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', '691'),
		('MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', '373'),
		('MC', 'MONACO', 'Monaco', 'MCO', '377'),
		('MN', 'MONGOLIA', 'Mongolia', 'MNG', '976'),
		('MS', 'MONTSERRAT', 'Montserrat', 'MSR', '1664'),
		('MA', 'MOROCCO', 'Morocco', 'MAR', '212'),
		('MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', '258'),
		('MM', 'MYANMAR', 'Myanmar', 'MMR', '95'),
		('NA', 'NAMIBIA', 'Namibia', 'NAM', '264'),
		('NR', 'NAURU', 'Nauru', 'NRU', '674'),
		('NP', 'NEPAL', 'Nepal', 'NPL', '977'),
		('NL', 'NETHERLANDS', 'Netherlands', 'NLD', '31'),
		('AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', '599'),
		('NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', '687'),
		('NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', '64'),
		('NI', 'NICARAGUA', 'Nicaragua', 'NIC', '505'),
		('NE', 'NIGER', 'Niger', 'NER', '227'),
		('NG', 'NIGERIA', 'Nigeria', 'NGA', '234'),
		('NU', 'NIUE', 'Niue', 'NIU', '683'),
		('NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', '672'),
		('MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', '1670'),
		('NO', 'NORWAY', 'Norway', 'NOR', '47'),
		('OM', 'OMAN', 'Oman', 'OMN', '968'),
		('PK', 'PAKISTAN', 'Pakistan', 'PAK', '92'),
		('PW', 'PALAU', 'Palau', 'PLW', '680'),
		('PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', NULL, '970'),
		('PA', 'PANAMA', 'Panama', 'PAN', '507'),
		('PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', '675'),
		('PY', 'PARAGUAY', 'Paraguay', 'PRY', '595'),
		('PE', 'PERU', 'Peru', 'PER', '51'),
		('PH', 'PHILIPPINES', 'Philippines', 'PHL', '63'),
		('PN', 'PITCAIRN', 'Pitcairn', 'PCN', '64'),
		('PL', 'POLAND', 'Poland', 'POL', '48'),
		('PT', 'PORTUGAL', 'Portugal', 'PRT', '351'),
		('PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', '1787'),
		('QA', 'QATAR', 'Qatar', 'QAT', '974'),
		('RE', 'REUNION', 'Reunion', 'REU', '262'),
		('RO', 'ROMANIA', 'Romania', 'ROM', '40'),
		('RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', '70'),
		('RW', 'RWANDA', 'Rwanda', 'RWA', '250'),
		('SH', 'SAINT HELENA', 'Saint Helena', 'SHN', '290'),
		('KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', '1869'),
		('LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', '1758'),
		('PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', '508'),
		('VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', '1784'),
		('WS', 'SAMOA', 'Samoa', 'WSM', '684'),
		('SM', 'SAN MARINO', 'San Marino', 'SMR', '378'),
		('ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', '239'),
		('SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', '966'),
		('SN', 'SENEGAL', 'Senegal', 'SEN', '221'),
		('CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', NULL, '381'),
		('SC', 'SEYCHELLES', 'Seychelles', 'SYC', '248'),
		('SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', '232'),
		('SG', 'SINGAPORE', 'Singapore', 'SGP', '65'),
		('SK', 'SLOVAKIA', 'Slovakia', 'SVK', '421'),
		('SI', 'SLOVENIA', 'Slovenia', 'SVN', '386'),
		('SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', '677'),
		('SO', 'SOMALIA', 'Somalia', 'SOM', '252'),
		('ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', '27'),
		('GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', NULL, '500'),
		('ES', 'SPAIN', 'Spain', 'ESP', '34'),
		('LK', 'SRI LANKA', 'Sri Lanka', 'LKA', '94'),
		('SD', 'SUDAN', 'Sudan', 'SDN', '249'),
		('SR', 'SURINAME', 'Suriname', 'SUR', '597'),
		('SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', '47'),
		('SZ', 'SWAZILAND', 'Swaziland', 'SWZ', '268'),
		('SE', 'SWEDEN', 'Sweden', 'SWE', '46'),
		('CH', 'SWITZERLAND', 'Switzerland', 'CHE', '41'),
		('SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', '963'),
		('TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', '886'),
		('TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', '992'),
		('TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', '255'),
		('TH', 'THAILAND', 'Thailand', 'THA', '66'),
		('TL', 'TIMOR-LESTE', 'Timor-Leste', NULL, '670'),
		('TG', 'TOGO', 'Togo', 'TGO', '228'),
		('TK', 'TOKELAU', 'Tokelau', 'TKL', '690'),
		('TO', 'TONGA', 'Tonga', 'TON', '676'),
		('TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', '1868'),
		('TN', 'TUNISIA', 'Tunisia', 'TUN', '216'),
		('TR', 'TURKEY', 'Turkey', 'TUR', '90'),
		('TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', '7370'),
		('TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', '1649'),
		('TV', 'TUVALU', 'Tuvalu', 'TUV', '688'),
		('UG', 'UGANDA', 'Uganda', 'UGA', '256'),
		('UA', 'UKRAINE', 'Ukraine', 'UKR', '380'),
		('AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', '971'),
		('GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', '44'),
		('US', 'UNITED STATES', 'United States', 'USA', '1'),
		('UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', NULL, '1'),
		('UY', 'URUGUAY', 'Uruguay', 'URY', '598'),
		('UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', '998'),
		('VU', 'VANUATU', 'Vanuatu', 'VUT', '678'),
		('VE', 'VENEZUELA', 'Venezuela', 'VEN', '58'),
		('VN', 'VIET NAM', 'Viet Nam', 'VNM', '84'),
		('VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', '1284'),
		('VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', '1340'),
		('WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', '681'),
		('EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', '212'),
		('YE', 'YEMEN', 'Yemen', 'YEM', '967'),
		('ZM', 'ZAMBIA', 'Zambia', 'ZMB', '260'),
		('ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', '263')";
		
     $rows= $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}bmw_phone_codes");
    if (empty($rows)) {
    	if(!empty($phone_codes))
    	{
    		$wpdb->query($phone_codes);
    	}
    }
}

public static function get_pages_array(){
	return apply_filters(
			'bmw_create_pages', array(
				'dashboard'      => array(
					'name'    => _x( 'Dashboard', 'Page slug', 'BMW' ),
					'title'   => _x( 'Dashboard', 'Page title', 'BMW' ),
					'content' => '',
				),
				'personal_info'      => array(
					'name'    => _x( 'Personal Info', 'Page slug', 'BMW' ),
					'title'   => _x( 'Personal Info', 'Page title', 'BMW' ),
					'content' => '',
				),
				'bank_details'      => array(
					'name'    => _x( 'Bank Details', 'Page slug', 'BMW' ),
					'title'   => _x( 'Bank Details', 'Page title', 'BMW' ),
					'content' => '',
				),
				'genealogy'      => array(
					'name'    => _x( 'Genealogy', 'Page slug', 'BMW' ),
					'title'   => _x( 'Genealogy', 'Page title', 'BMW' ),
					'content' => '',
				),
				'payout_list'      => array(
					'name'    => _x( 'Payout List', 'Page slug', 'BMW' ),
					'title'   => _x( 'Payout List', 'Page title', 'BMW' ),
					'content' => '',
				),
				'withdrawal_amount'      => array(
					'name'    => _x( 'Withdrawal Amount', 'Page slug', 'BMW' ),
					'title'   => _x( 'Withdrawal Amount', 'Page title', 'BMW' ),
					'content' => '',
				),
				'register'      => array(
					'name'    => _x( 'Register', 'Page slug', 'BMW' ),
					'title'   => _x( 'Register', 'Page title', 'BMW' ),
					'content' => '',
				),	
				'join_network'      => array(
					'name'    => _x( 'Join Network', 'Page slug', 'BMW' ),
					'title'   => _x( 'Join Network', 'Page title', 'BMW' ),
					'content' => '',
				),
				'invitation'      => array(
					'name'    => _x( 'Invitation', 'Page slug', 'BMW' ),
					'title'   => _x( 'Invitation', 'Page title', 'BMW' ),
					'content' => '',
				)
			)
		);
}


	public static function create_pages() {
		
		$pages = self::get_pages_array();
		//print_r($pages );die;
		if(!empty($pages)){
		foreach ( $pages as $key => $page ) {
			$page_id=get_page_by_title( $page['title'], OBJECT, 'page');
			
			if(empty($page_id)){
				$pageid=self::bmw_create_page($page['title'],$page['content'], $key);
			}
		}
		}

		$menu = wp_get_nav_menu_object( 'primary' );
		if(empty($menu)){
			wp_update_nav_menu_object( 0, array('menu-name' => 'primary') );
		}
		$menu = wp_get_nav_menu_object( 'primary' );
		$args = array( "post_type" => "nav_menu_item",
		 					"name" =>__('Binary MLM WooCommerce','BMW'),
		 					'title'=>__('Binary MLM WooCommerce','BMW'));
		$query = new WP_Query( $args );
		if(empty($query->posts)){
		 	wp_update_nav_menu_item($menu->term_id, 0, array(
	 				'menu-item-title' =>  __('Binary MLM WooCommerce','BMW'),
	 				'menu-item-classes' => 'BMW',
	 				'menu-item-url' => get_url_bmw('dashboard'),
	 				'menu-item-status' => 'publish',
	 				'menu-item-type' => 'custom',
			 		)
			 );

		 	update_post_meta( $parent_id, 'menu_item_bmw','BMW');
	 	}
	
	}
	public static function bmw_create_page( $page_title, $page_content, $slug) {
		global $wpdb;
    $page_id = wp_insert_post(
        array(
        'comment_status' => 'close',
        'ping_status'    => 'close',
        'post_author'    => 1,
        'post_title'     => $page_title,
        'post_name'      => $slug,
        'post_status'    => 'publish',
        'post_content'   => $page_content,
        'post_type'      => 'page',
        'post_parent'    => ''
        )
    );
	update_post_meta($page_id, 'bmw_page_title',$page_title);
	return $page_id;
	}

}

BMW_INSTALL::init();
