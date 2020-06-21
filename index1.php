<?php
//index.php

if (!isset($_SERVER['HTTP_REFERER'])){

   header('Location:login.php'); }

else {


session_start();
$mails = $_SESSION['mails'];
$c = $_SESSION['check'];
$subject = $_SESSION['subject'];
$body = $_SESSION['body'];

$connect = new PDO("mysql:host=localhost;dbname=hebnicin_mail", "hebnicin_plag", "wp75VT37oz");
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if($c == 0){
    
    try {
            $sql = /*INSERT INTO body (body, subject) VALUES('".$body."', '".$subject."')";*/ "Update body SET body = '".$body."', subject = '".$subject."' WHERE id = 1";    
            $connect->exec($sql);
            
        }
        catch (PDOException $e) {
            die("ERROR: Could not able to execute $sql. "
            .$e->getMessage());
        }
    foreach($mails as $m){
        
        try {
            $sql = "INSERT INTO customer (customer_name, customer_email) 
            VALUES('".$m."', '".$m."') ";    
            $connect->exec($sql);
            
        }
        catch (PDOException $e) {
            die("ERROR: Could not able to execute $sql. "
            .$e->getMessage());
        }
        echo "Records inserted successfully.<br>";
    }
    $_SESSION['check'] = 1;
   
}

$sql = "Update count SET count = 1 WHERE id = 1"; 
           //"INSERT INTO count (count) 
            //VALUES(1)";    
            $connect->exec($sql);

$query = "SELECT * FROM customer ORDER BY customer_id";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

$query1 = "SELECT * FROM body ORDER BY id";
$statement1 = $connect->prepare($query1);
$statement1->execute();
$result1 = $statement1->fetchAll();


if(isset($_REQUEST['delete'])){
$sql1 = 'TRUNCATE TABLE customer';
$connect->exec($sql1);
//$statement = $connect->prepare($sql1);
//$statement->execute();
header('Location:index1.php');

}
//var_dump($mails);

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Send Bulk Email </title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
		<br />
		<div class="container">
			<h3 align="center">Send Bulk Email</h3>
			<br />
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<tr>
						<th>Customer Name</th>
						<th>Email</th>
						<th><input type="checkbox" id="selectall" onClick="selectAll(this)" />Select All</th>
						<th>Action</th>
					</tr>
				<?php
				$count = 0;
				foreach($result as $row)
				{
					$count = $count + 1;
					echo '
					<tr>
						<td>'.$row["customer_name"].'</td>
						<td>'.$row["customer_email"].'</td>
						<td>
							<input type="checkbox" name="single_select[]" class="single_select" data-email="'.$row["customer_email"].'" data-name="'.$row["customer_name"].'" />
						</td>
						<td>
						<button type="button" name="email_button" class="btn btn-info btn-xs email_button" id="'.$count.'" data-email="'.$row["customer_email"].'" data-name="'.$row["customer_name"].'" data-action="single">Send Single</button>
						</td>
					</tr>
					';
				}
				?>
					<tr>
						<td colspan="3"><form action="#" method="post"><input type="submit" name="delete" value="delete all" /></form></td>
						<td><button type="button" name="bulk_email" class="btn btn-info email_button" id="bulk_email" data-action="bulk">Send Bulk</button></td></td>
					</tr>
				</table>
			</div>
		</div>
		<script language="JavaScript">
	        function selectAll(source) {
		    checkboxes = document.getElementsByName('single_select[]');
		    for(var i in checkboxes)
			checkboxes[i].checked = source.checked;
	        }
        </script>
        <?php 
        
            foreach($result1 as $row1)
			{
			
                echo "<br><br><h2>subject:</h2><br>".$row1["subject"]."<br>";
                echo "<h2>body:</h2><br>".$row1["body"]."<br>";
			}
            echo "<h2>attachments: </h2><br>";
            $dir = "upload/";
            $a = scandir($dir);
            foreach($a as $i){
                echo ">".$i."<br>";
            }
        ?>
	</body>
</html>

<script>
$(document).ready(function(){
	$('.email_button').click(function(){
		$(this).attr('disabled', 'disabled');
		var id  = $(this).attr("id");
		var action = $(this).data("action");
		var email_data = [];
		if(action == 'single')
		{
			email_data.push({
				email: $(this).data("email"),
				name: $(this).data("name")
			});
		}
		else
		{
			$('.single_select').each(function(){
				if($(this).prop("checked") == true)
				{
					email_data.push({
						email: $(this).data("email"),
						name: $(this).data('name')
					});
				} 
			});
		}

		$.ajax({
			url:"send_mail.php",
			method:"POST",
			data:{email_data:email_data},
			beforeSend:function(){
				$('#'+id).html('Sending...');
				$('#'+id).addClass('btn-danger');
			},
			success:function(data){
				if(data == 'ok')
				{
					$('#'+id).text('Success');
					$('#'+id).removeClass('btn-danger');
					$('#'+id).removeClass('btn-info');
					$('#'+id).addClass('btn-success');
				}
				else
				{
					$('#'+id).text(data);
				}
				$('#'+id).attr('disabled', false);
			}
		})

	});
});
</script>
<?php
}
?>




