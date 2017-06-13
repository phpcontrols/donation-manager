<div id="menu">
    <ul>
        <li><a href="donations.php" <?php if($_GET['currentPage'] == 'donations') echo 'class="active"'; ?>>Donations</a></li>
        <li><a href="donors.php" <?php if($_GET['currentPage'] == 'donors') echo 'class="active"'; ?>>Donors</a></li>
        <li><a href="campaigns.php" <?php if($_GET['currentPage'] == 'campaigns') echo 'class="active"'; ?>>Campaigns</a></li>
        <li><a href="reports.php" <?php if($_GET['currentPage'] == 'reports') echo 'class="active"'; ?>>Reports</a></li>
    </ul>
</div>
