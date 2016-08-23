<?
define('TRO_BUCKETLIST',true);
include('../init.php');
include(TEMPLATE_DIR . '/header.php');
$db = new pdo_Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$sql="select * from User where UserName = :username";
$db->query($sql);
$db->bind(":username",$username, PDO::PARAM_STR);
$db->execute();
$row=$db->single();

$ID = $row['ID'];
$firstname = $row['FirstName'];
$lastname = $row['LastName'];
$email = $row['Email'];
$username = $row['UserName'];
$picture = $row['Picture'];

$interests = $row['Interests'];
$about = $row['About'];
?>




<br>
<br>
<br>
<div class='container'>
<form action="upload.php" method="post" enctype="multipart/form-data">
	<div>
    FirstName
    <input type='text' name='firstname' value='<?echo $firstname;?>'>
    </div>
    
    <div>
    LastName
    <input type='text' name='lastname' value='<?echo $lastname;?>'>
    </div>
    
    <div>
    Email
    <input type='text' name='email' value='<?echo $email;?>'>
    </div>
    
    <div>
    UserName
    <input type='text' name='username' value='<?echo $username;?>'>
    </div>
    
    <div>
	Picture
	<img src='<?echo $picture;?>' alt="picture" style="width:100px;height:100px;">
    <input type="file" name="fileToUpload" id="fileToUpload">
    </div>
    
    <div>
    Interests
    <input type='text' name='interests' value='<?echo $interests;?>'>
    </div>
    
    <div>
    About
    <textarea name='about' rows="4" cols="50"><?echo $about;?></textarea>
    </div>
    
    <input type="submit" value="Upload" name="submit">
</form>
</div>
<?
include(TEMPLATE_DIR . '/footer.php');
?>