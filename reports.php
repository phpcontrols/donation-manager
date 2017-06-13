<?php
use phpGrid\C_DataGrid;

include_once("phpGrid/conf.php");
require_once("phpChart/conf.php");
include_once('inc/head.php');
?>

<h1>My Donation Manager</h1>

<?php
$_GET['currentPage'] = 'reports';
include_once('inc/menu.php');
?>

<h2>Campaign Totals</h2>

<?php
$pc = new C_PhpChartX(array(array(null)),'BarChart');
$pc->add_plugins(array('canvasTextRenderer','canvasAxisTickRenderer', 'pointLabels'),true);
$pc->set_animate(true);
$pc->set_series_default(array(
		'renderer'=>'plugin::BarRenderer',
		'rendererOptions' => array('barWidth'=>60),
		'pointLabels'=> array('show'=>true)
		));
$pc->set_axes(array(
     'xaxis'=>array(
     	'label'=>'Campaign',
		'renderer'=>'plugin::CategoryAxisRenderer',
		'rendererOptions'=>array('tickRenderer'=>'plugin::CanvasAxisTickRenderer'),
		'ticks'=>array(null),
		'tickOptions'=>array(
                'angle'=>-35, 
                'fontStretch'=>1)),
	'yaxis'=>array('label'=>'Total Donations')
));
$pc->draw(600,400);


// pie series data must be 2D array e.g. array('Verwerkende industrie', 9)
$pc2 = new C_PhpChartX(array(array(null)),'PieChart');
$pc2->set_series_default(array( 'shadow'=> false, 
    'renderer'=> 'plugin::PieRenderer', 
    'rendererOptions'=> array( 
      'sliceMargin'=> 3,
      'showDataLabels'=> true ) 
  ));
$pc2->set_legend(array('show'=>true,'location'=> 'w'));
$pc2->draw(600,400);   
?>

<br /><br /><br /><br /><br /><br /><br /><br />
<div style="clear:both"></div>
<h2 style="margin-top:100px">Campaign Summary</h2>

<?php
$dgCampReport = new C_DataGrid(
	"SELECT c.id, dn.CampaignId, c.CampaignName, c.Description, c.StartDate,
	COUNT(*) As 'DonationCount',
	SUM(dn.Amount) As 'TotalDonation' 
	FROM campaigns c 
	INNER JOIN donations dn on c.id = dn.CampaignId
	GROUP BY dn.CampaignId, c.CampaignName, c.Description, c.StartDate", 
	"id", "campaigns");
$dgCampReport->set_col_hidden('id')->set_col_hidden('CampaignId');
$dgCampReport->set_col_currency('TotalDonation', '$');
$dgCampReport->set_dimension('1000px');
$onGridLoadComplete = <<<ONGRIDLOADCOMPLETE
function(status, rowid)
{
	var barData1 = [];
	var barData2 = [];

	d1 = $('#campaigns').jqGrid('getCol', 'TotalDonation', false);
	d2 = $('#campaigns').jqGrid('getCol', 'CampaignName', false);
	
	npoints = d1.length;
	for(var i=0; i < npoints; i++){
		barData1[i] = [i+1, parseInt(d1[i])];
		barData2[i] = [i+1, d2[i]];
	}
    _BarChart.series[0].data = barData1;
    _BarChart.axes.xaxis.ticks = barData2;
    _BarChart.replot({resetAxes:true});

    var pieData = [];
    for(var j=0; j < barData1.length; j++)
    {
        pieData.push([barData2[j][1],barData1[j][1]]);
    }
    // console.log(pieData);
    _PieChart.series[0].data = pieData;
    _PieChart.replot({resetAxes:true});
}
ONGRIDLOADCOMPLETE;
$dgCampReport->add_event("jqGridLoadComplete", $onGridLoadComplete);
$dgCampReport->enable_search(true)->enable_autowidth(true);
$dgCampReport->display();
?>

<style>
div#resizable{
	float: left;
}

<?php
include_once('inc/footer.php');
?>