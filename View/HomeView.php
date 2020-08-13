<html>
<head>
</head>
<body>
<?php 
    if(isset($_POST['reg_msg'])){
    	echo $_POST['reg_msg'];
    }
?>
<form method="post" action="?target=Home&action=register">
username:<input type="text" id="username" name="username"><br>
password:<input type="password" id="password" name="password"><br>
<input type="submit" value="Register"><br>
</form>
<?php 
    if(isset($_POST['log_msg'])){
    	echo $_POST['log_msg'];
    }
?>
<form method="post" action="?target=Home&action=login">
username:<input type="text" id="username" name="username"><br>
password:<input type="password" id="password" name="password"><br>
<input type="submit" value="Login"><br>
</form>
</body>
</html>