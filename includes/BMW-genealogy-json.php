<?php 
require_once('../../../../wp-config.php');
$all_members=bmw_get_all_members_array();
echo json_encode($all_members);