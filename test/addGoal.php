<?
define('TRO_BUCKETLIST',true);
include('../init.php');
include(TEMPLATE_DIR . '/header.php');

$goal = $_GET['goal'];
$goalDone = isset($_GET['goalDone'])? $_GET['goalDone']: 'N';
?>
<br>
<br>
<br>
<div class='container'>
<form action="insertGoal.php" method="post" enctype="multipart/form-data">
	<div>
    <input type='text' name='goal' placeholder='add your goal' value="<?echo $goal; ?>">
    </div>
    
    <div>
    <input type='text' name='category' placeholder='select the category'>
    </div>
    
    <div>
    <input type='text' name='location' placeholder='enter the location'>
    </div>
    
    <div>
    <input type='text' name='targetDate' placeholder='target date'>
    </div>

    <div>
    <input type="file" name="fileToUpload" id="fileToUpload">
    </div>
    
    <div>
    <textarea name='describe' rows="4" cols="50" placeholder="describe your goal"></textarea>
    </div>

	<input name='goalDone' value="<?echo $goalDone;?>" hidden>
    
    <input type="submit" value="Upload" name="submit">
</form>
</div>

<?
include(TEMPLATE_DIR . '/footer.php');
?>