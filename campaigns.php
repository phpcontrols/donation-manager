<?php
use phpGrid\C_DataGrid;

include_once("phpGrid/conf.php");
include_once('inc/head.php');
?>

<h1>My Donation Manager</h1>

<?php
$_GET['currentPage'] = 'campaigns';
include_once('inc/menu.php');
?>

<?php
$dgCamp = new C_DataGrid(
	"SELECT c.id, dn.CampaignId, c.CampaignName, c.Description, c.StartDate,
	COUNT(*) As 'DonationCount',
	SUM(dn.Amount) As 'TotalDonation' 
	FROM campaigns c 
	INNER JOIN donations dn on c.id = dn.CampaignId
	GROUP BY dn.CampaignId, c.CampaignName, c.Description, c.StartDate", 
	"id", "campaigns");
$dgCamp->set_col_hidden('id')->set_col_hidden('CampaignId');
$dgCamp->enable_edit();
$dgCamp->set_dimension('1000px');
//$dgCamp->enable_autowidth(true);
$dgCamp->enable_global_search(true);
//$dgCamp->set_col_edittype('OrgId', 'select', "select id, Name from org");
$dgCamp->set_col_currency('TotalDonation', '$');
//$dgCamp->set_grid_property(array("footerrow"=>true));
$loadComplete = <<<LOADCOMPLETE
function ()
{
var colSum = $('#campaigns').jqGrid('getCol', 'TotalDonation', false, 'sum'); // other options are: avg, count
$('#campaigns').jqGrid('footerData', 'set', { OrgId: 'Total:', 'TotalDonation': colSum });
}
LOADCOMPLETE;
//$dgCamp->add_event("jqGridLoadComplete", $loadComplete);

// Donations detail grid
$dgDonations = new C_DataGrid("SELECT * FROM donations", "id", "donations");
$dgDonations->set_col_hidden('id')->set_caption('Donations');
$dgDonations->enable_edit();
$dgDonations->set_dimension('1000px');
$dgDonations->set_col_edittype('CampaignId', 'select', 'select id, CampaignName from campaigns');
$dgDonations->set_col_edittype('DonorId', 'select', "select id, concat(FirstName, ' ', LastName) from Donors");
$dgDonations->set_col_currency("Amount", "$");

$dgCamp -> set_masterdetail($dgDonations, 'CampaignId', 'id');
$dgCamp -> display();
?>

<?php
include_once('inc/footer.php');
?>