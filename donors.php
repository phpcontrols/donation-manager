<?php
use phpGrid\C_DataGrid;

include_once("phpGrid/conf.php");
include_once('inc/head.php');
?>

<h1>My Donation Manager</h1>

<?php
$_GET['currentPage'] = 'donors';
include_once('inc/menu.php');
?>

<?php
$dgDonors = new C_DataGrid(
		"SELECT d.id, 
		concat(d.FirstName, ' ', d.LastName) As Name, 
		d.Address, d.Email, 
		sum(dn.Amount) As 'TotalDonation' 
/*		,avg(dn.Amount) As 'AverageDonation', 
		max(dn.Amount) As 'LargestDonation', 
		min(dn.Amount) As 'SmallestDonation'
*/		FROM donors d
		INNER JOIN donations dn on d.id = dn.donorid
		GROUP BY d.Address, d.Email ", 
	"id", "donors");
$dgDonors->set_col_hidden('id')->set_caption('Donors');
$dgDonors->set_col_format('Email', 'email');

// prevent aggrated columnn from editing 
$dgDonors ->set_col_readonly("Name", true);  
$dgDonors -> set_col_currency("TotalDonation", "$")->set_col_readonly("TotalDonation", true);
//$dgDonors -> set_col_currency("AverageDonation", "$")->set_col_readonly("AverageDonation", true);
//$dgDonors -> set_col_currency("LargestDonation", "$")->set_col_readonly("LargestDonation", true);
//$dgDonors -> set_col_currency("SmallestDonation", "$")->set_col_readonly("SmallestDonation", true);
$dgDonors->enable_edit();
$dgDonors->set_dimension('1000px');

// Donations detail grid
$dgDonations = new C_DataGrid("SELECT * FROM donations", "id", "donations");
$dgDonations->set_col_hidden('id')->set_caption('Donations');
$dgDonations->enable_edit();
$dgDonations->set_dimension('1000px');
$dgDonations->set_col_edittype('CampaignId', 'select', 'select id, CampaignName from campaigns');
$dgDonations->set_col_edittype('DonorId', 'select', "select id, concat(FirstName, ' ', LastName) from Donors");
$dgDonations->set_col_currency("Amount", "$");

$dgDonors -> set_masterdetail($dgDonations, 'DonorId', 'id');
$dgDonors -> display();
?>

<?php
include_once('inc/footer.php');
?>