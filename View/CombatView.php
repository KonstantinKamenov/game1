<html>
<head>
<link rel="stylesheet" type="text/css" href="View/test_style.css">
<script src="jquery-3.5.1.js"></script>
<script type="text/javascript">
	var characters,enemies;
	$(document).ready(function(){
			$.get("index.php/?target=Combat&action=getState",function(data){
				var state=JSON.parse(data);
				console.log(state);
				characters=JSON.parse(state.characters);
				console.log(characters);
				enemies=JSON.parse(state.enemies);
				console.log(enemies);
				displayCharacters();
				displayEnemies();
			});
		});
	function displayCharacters(){
		var fields=document.getElementsByClassName("friendly_field");
		for(var i=0;i<fields.length;i++){
			fields[i].innerHTML="";
		}
		for(var i=0;i<characters.length;i++){
			fields[characters[i].y*4+characters[i].x].innerHTML=characters[i].name+"<br/>"+"("+characters[i].class+")"+"<br\>"+characters[i].health;
		}
	}
	function displayEnemies(){
		var fields=document.getElementsByClassName("enemy_field");
		for(var i=0;i<fields.length;i++){
			fields[i].innerHTML="";
		}
		for(var i=0;i<enemies.length;i++){
			fields[enemies[i].y*4+enemies[i].x].innerHTML=enemies[i].name+"<br\>"+enemies[i].health;
		}
	}
    </script>
</head>
<body>
	<table>
		<tr>
			<td class='field friendly_field'></td>
			<td class='field friendly_field'></td>
			<td class='field friendly_field'></td>
			<td class='field friendly_field'></td>
		</tr>
		<tr>
			<td class='field friendly_field'></td>
			<td class='field friendly_field'></td>
			<td class='field friendly_field'></td>
			<td class='field friendly_field'></td>
		</tr>
		<tr>
			<td class='field friendly_field'></td>
			<td class='field friendly_field'></td>
			<td class='field friendly_field'></td>
			<td class='field friendly_field'></td>
		</tr>
		<tr>
			<td class='field friendly_field'></td>
			<td class='field friendly_field'></td>
			<td class='field friendly_field'></td>
			<td class='field friendly_field'></td>
		</tr>
	</table>
	<br />
	<table>
		<tr>
			<td class='field enemy_field'></td>
			<td class='field enemy_field'></td>
			<td class='field enemy_field'></td>
			<td class='field enemy_field'></td>
		</tr>
		<tr>
			<td class='field enemy_field'></td>
			<td class='field enemy_field'></td>
			<td class='field enemy_field'></td>
			<td class='field enemy_field'></td>
		</tr>
		<tr>
			<td class='field enemy_field'></td>
			<td class='field enemy_field'></td>
			<td class='field enemy_field'></td>
			<td class='field enemy_field'></td>
		</tr>
		<tr>
			<td class='field enemy_field'></td>
			<td class='field enemy_field'></td>
			<td class='field enemy_field'></td>
			<td class='field enemy_field'></td>
		</tr>
	</table>
</body>
</html>