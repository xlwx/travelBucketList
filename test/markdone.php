<?
define('TRO_BUCKETLIST',true);
include('../init.php');
include(TEMPLATE_DIR . '/header.php');
$goalID = $_GET['goalID'];

$db = new pdo_Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$sql="select * from Goal where ID = :goalID";
$db->query($sql);
$db->bind(":goalID",$goalID, PDO::PARAM_STR);
$db->execute();
$row=$db->single();

$ID = $row['ID'];
$goalContent = $row['GoalContent'];
$category = $row['Category'];
$location = $row['Location'];
$describe = $row['GoalDescribe'];
$photo = $row['Photo'];
$targetDate = $row['TargetDate'];

echo $goalContent;
?>




<br>
<br>
<br>
<div class='container'>
<form action="updateGoal.php" method="post" enctype="multipart/form-data">
	<h2>Goal Complete</h2>
	<h3><?echo $goalContent;?></h3>
	
	<div>
    <textarea name='describe' rows="4" cols="50" placeholder="describe your experience"><?echo $describe;?></textarea>
    </div>
	
    <div>
    <input type='text' name='category' placeholder='select the category' value='<?echo $category;?>'>
    </div>
    
    <div>
    <input type='text' name='location' placeholder='enter the location' value='<?echo $location;?>'>
    </div>
    
    <div>
    <input type='text' name='targetDate' placeholder='target date' value='<?echo $targetDate;?>'>
    </div>
    
    <div>
	<img src='<?echo $photo;?>' alt="picture" style="width:100px;height:100px;">
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="text" name="img" value="<?echo $photo;?>" hidden>
    </div>
    
    <input name='goalDone' value='Y' hidden>
	<input type='text' name='goal' value='<?echo $goalContent;?>' hidden>
    <input type='text' name='ID' value='<?echo $ID;?>' hidden>
    
    <input type="submit" value="Save" name="submit">
</form>
</div>
<?
include(TEMPLATE_DIR . '/footer.php');
?>