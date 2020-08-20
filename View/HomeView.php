<html>
<head>
</head>
<body>
<?php 
    if(isset($reg_msg)){
    	echo $reg_msg;
    }
?>
<form method="post" action="index.php?target=Home&action=register">
username:<input type="text" id="username" name="username"><br>
password:<input type="password" id="password" name="password"><br>
<input type="submit" value="Register"><br>
</form>
<?php 
    if(isset($log_msg)){
    	echo $log_msg;
    }
?>
<form method="post" action="index.php?target=Home&action=login">
username:<input type="text" id="username" name="username"><br>
password:<input type="password" id="password" name="password"><br>
<input type="submit" value="Login"><br>
</form>
</body>
</html>