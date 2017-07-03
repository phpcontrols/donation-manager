<?php
use phpGrid\C_DataGrid;

include_once("phpGrid/conf.php");
include_once('inc/head.php');
?>

<h1>My Donation Manager</h1>

<?php
$_GET['currentPage'] = 'donations';
include_once('inc/menu.php');
?>

<?php
$dgDonations = new C_DataGrid("SELECT * FROM donations", "id", "donations");
$dgDonations->set_col_hidden('id')->set_caption('Donations');
$dgDonations->enable_edit();
$dgDonations->enable_autowidth(true);
$dgDonations->set_col_edittype('CampaignId', 'select', 'select id, CampaignName from campaigns');
$dgDonations->set_col_edittype('DonorId', 'select', "select id, concat(FirstName, ' ', LastName) from donors");
//$dgDonations->enable_global_search(true);
$dgDonations->set_col_currency("Amount", "$");
// $dgDonations->enable_dnd_grouping(true);

$dgDonations -> display();
?>

<?php
include_once('inc/footer.php');
?>