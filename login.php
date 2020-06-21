<?php
$user="admin";
$pswd="admin123";
if(isset($_REQUEST['submit'])){
    if($_REQUEST['username'] == $user && $_REQUEST['password'] == $pswd){
        header('Location:index.php');
    }else{
        echo "input data is wrong";
    }
    
}  
?>
<html>
<head>
  <title>Login</title>
</head>


<form action="#" method = "post">
  <label for="username">Username:</label> <input type="username" name="username"><br /><br />
  <label for="password">Password:</label> <input type="password" name="password"><br /><br />
  <input type ="submit" value="Login" name="submit"/>
</form>
</html>