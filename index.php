<?php

if (!isset($_SERVER['HTTP_REFERER'])){

   header('Location:login.php'); }

else {

session_start();
$_SESSION['mails'];
$_SESSION['check'] = 0;
function validEmail($email){
// Check the formatting is correct
if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
return FALSE;
}
// Next check the domain is real.
$domain = explode("@", $email, 2);
return checkdnsrr($domain[1]); // returns TRUE/FALSE;
}
error_reporting(E_ERROR | E_PARSE);
if(isset($_REQUEST['delete'])){
    $dir = "upload/";
    $a = scandir($dir);
    foreach($a as $i){
        if(unlink($dir.$i) == 1){
            echo "Successful";
        }else{
            //echo "unable to delete";
        }
    }
    
}    

if(isset($_REQUEST['submit'])){
    $string = $_REQUEST['mails'];
    $_SESSION['subject'] = $_REQUEST['subject'];
    
    $_SESSION['body'] = $_REQUEST['body'];
    
    $pattern = '/[a-z0-9_\.\-\+]+@[a-z0-9\-]+\.([a-z]{2,3})(?:\.[a-z]{2})?/i';
    preg_match_all($pattern, $string, $matches);
    $mails = $matches[0];
    $_SESSION['mails'] = $mails;
    
    
    header('Location:index1.php');
    //header('Location:setmail.php');
}
//$string = 'Ruchika < ruchika@example.com >';

$serialized_array = serialize($mails); 
$unserialized_array = unserialize($serialized_array); 

//var_dump($serialized_array);

//validEmail('real@hotmail.com'); // Returns TRUE
//validEmail('fake@fakedomain.com'); // Returns FALSE

// Count # of uploaded files in array


// Loop through each file




?>
<html>
    <head>
        
        
    </head>
    <body>
        <h2>Delete old files: </h2>
        <?php 
            echo "attachments: <br>";
            $dir = "upload/";
            $a = scandir($dir);
            foreach($a as $i){
                echo ">".$i."<br>";
            }
        ?>
        <br>
        <form action="#" method="post">
            <input type="submit" value="Delete" name="delete" />
            
        </form>
        <br><br>
        <form action="upload.php" method="post" enctype="multipart/form-data" id="install" onsubmit='return validateUpload()'>
				 
				<label for="file"><h2>Select files to upload as attachments:</h2></label>
				<input type="file" name="fileToUpload" id="fileToUpload" class='btn btn-large btn-inverse' multiple>
			    
					<input type="submit" id="submit-button" value="upload" name="submit" class='btn btn-danger btn-large span3' style="text-transform: uppercase;" >
				
		</form>
        <br><br>
        
        <br><br>
        <form action="#" method="post">
            <h2>E-Mails:</h2><textarea name="mails" style="margin: 0px; width: 1345px; height: 257px;" ></textarea>
            <br><br><h2>Subject:</h2><textarea name="subject" style="margin: 0px; width: 1348px; height: 48px;" required></textarea>
            <h4>Open this link in new tab and paste the mail body, then copy output text and paste it here</h4>
            <a href="https://wordtohtml.net/">https://wordtohtml.net/</a>
            <br><br><h2>Body:</h2><br><textarea name="body" style="margin: 0px; width: 1340px; height: 459px;" required></textarea>
            <input type="submit" name="submit">
        </form>
    </body>
</html>
<?php 
    
}
?>