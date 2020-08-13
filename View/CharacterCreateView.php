<html>
<head>
</head>
<body>
<?php 
    if(isset($_POST['create_msg'])){
    	echo $_POST['create_msg'];
    }
?>
<form method="post" action="?target=CharacterCreate&action=createCharacter">
Character name:<input type="text" id="name" name="name"><br>
<select id="class" name="class">
  <option value="Mage">Mage</option>
  <option value="Warrior">Warrior</option>
</select>
<input type="submit" value="Create"><br>
</form>
</body>
</html>