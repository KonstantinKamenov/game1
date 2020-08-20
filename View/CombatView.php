<html>
<head>
<link rel="stylesheet" type="text/css" href="View/test_style.css">
<script src="jquery-3.5.1.js"></script>
<script type="text/javascript">
    function sleep(ms) {
     	return new Promise(resolve => setTimeout(resolve, ms));
    }
	var characters,enemies,turn;
	var selectedSpell=0;
	var spells;
	$(document).ready(function(){
			loadField();
		});
	function loadField(){
		$.get("index.php/?target=Combat&action=getState",function(data){
				var state=JSON.parse(data);
				//console.log(state);
				characters=JSON.parse(state.characters);
				//console.log(characters);
				enemies=JSON.parse(state.enemies);
				//console.log(enemies);
				displayCharacters();
				displayEnemies();
				loadTurn();
			});
	}
	function displayCharacters(){
		var fields=document.getElementsByClassName("friendly_field");
		for(var i=0;i<fields.length;i++){
			fields[i].innerHTML="";
		}
		for(var i=0;i<characters.length;i++){
			console.log(characters[i].y*5+characters[i].x);
			if(characters[i].health>0){
				fields[characters[i].y*5+characters[i].x].innerHTML=characters[i].name+"<br/>"+"("+characters[i].class+")"+"<br\>"+characters[i].health;
			}
		}
	}
	function displayEnemies(){
		var fields=document.getElementsByClassName("enemy_field");
		for(var i=0;i<fields.length;i++){
			fields[i].innerHTML="";
		}
		for(var i=0;i<enemies.length;i++){
			if(enemies[i].health>0){
				fields[enemies[i].y*5+enemies[i].x].innerHTML=enemies[i].name+"<br\>"+enemies[i].health;
			}
		}
	}
	function loadTurn(){
		$.get("index.php/?target=Combat&action=getTurn",function(data){
    		//console.log(data);
    		selectedSpell=0;
    		turn=JSON.parse(data);
    		console.log(turn);
    		if(turn.outcome!="ongoing"){
    			endBattle();
    		}
    		spells=turn.spells;
    		$("#turn").html("");
    		if(turn.side=="friendly"){
        		for(var i=0;i<spells.length;i++){
    				//console.log(enemies[i].enemy_id);
    				$("#turn").append("<tr><td onclick='changeSelectedSpell("+(i+1)+")'class='selector spell_selector'>"+spells[i].name+"</td></tr>");
    			}
			}else{
				//enemyTurn();
				$("#turn").append("<tr><td class='selector spell_selector'></td></tr>");
				sleep(1000).then(() => { enemyTurn(); });
			}
    		//console.log(turn);
		});
	}
	function changeSelectedSpell(ind){
		var spellSelectors=document.getElementsByClassName("spell_selector")
    	if(selectedSpell!=0){
    		spellSelectors[selectedSpell-1].className="selector spell_selector"
    	}
    	selectedSpell=ind
    	spellSelectors[ind-1].className="selector_selected spell_selector"
	}
	function enemyTurn(){
		$.post("index.php?target=Combat&action=enemyTurn",function(data){
			console.log(data);
			loadField();
		});
	}
	function cast(x,y,field){
		if(turn.side!="friendly"){
			return;
		}
		var spell=spells[selectedSpell-1].spell_id;
		//console.log(spell);
		$.post("index.php?target=Combat&action=castSpell",{x: x, y: y, field: field, side: 0, spell: spell},function(data){
			console.log(data);
			loadField();
		});
	}
	function endBattle(){
		window.location.replace("index.php?target=Combat&action=endCombat");
	}
    </script>
</head>
<body>
	<table id='turn' style="float: left; padding: 5px;">
	</table>
	<table style="float: left; padding: 5px;">
		<tr>
			<td onclick='cast(0,0,0)' class='field friendly_field'></td>
			<td onclick='cast(1,0,0)' class='field friendly_field'></td>
			<td onclick='cast(2,0,0)' class='field friendly_field'></td>
			<td onclick='cast(3,0,0)' class='field friendly_field'></td>
			<td onclick='cast(4,0,0)' class='field friendly_field'></td>
		</tr>
		<tr>
			<td onclick='cast(0,1,0)' class='field friendly_field'></td>
			<td onclick='cast(1,1,0)' class='field friendly_field'></td>
			<td onclick='cast(2,1,0)' class='field friendly_field'></td>
			<td onclick='cast(3,1,0)' class='field friendly_field'></td>
			<td onclick='cast(4,1,0)' class='field friendly_field'></td>
		</tr>
		<tr>
			<td onclick='cast(0,2,0)' class='field friendly_field'></td>
			<td onclick='cast(1,2,0)' class='field friendly_field'></td>
			<td onclick='cast(2,2,0)' class='field friendly_field'></td>
			<td onclick='cast(3,2,0)' class='field friendly_field'></td>
			<td onclick='cast(4,2,0)' class='field friendly_field'></td>
		</tr>
		<tr>
			<td onclick='cast(0,3,0)' class='field friendly_field'></td>
			<td onclick='cast(1,3,0)' class='field friendly_field'></td>
			<td onclick='cast(2,3,0)' class='field friendly_field'></td>
			<td onclick='cast(3,3,0)' class='field friendly_field'></td>
			<td onclick='cast(4,3,0)' class='field friendly_field'></td>
		</tr>
		<tr>
			<td onclick='cast(0,4,0)' class='field friendly_field'></td>
			<td onclick='cast(1,4,0)' class='field friendly_field'></td>
			<td onclick='cast(2,4,0)' class='field friendly_field'></td>
			<td onclick='cast(3,4,0)' class='field friendly_field'></td>
			<td onclick='cast(4,4,0)' class='field friendly_field'></td>
		</tr>
	</table>
	<table style="float: left; padding: 5px;">
		<tr>
			<td onclick='cast(0,0,1)' class='field enemy_field'></td>
			<td onclick='cast(1,0,1)' class='field enemy_field'></td>
			<td onclick='cast(2,0,1)' class='field enemy_field'></td>
			<td onclick='cast(3,0,1)' class='field enemy_field'></td>
			<td onclick='cast(4,0,1)' class='field enemy_field'></td>
		</tr>
		<tr>
			<td onclick='cast(0,1,1)' class='field enemy_field'></td>
			<td onclick='cast(1,1,1)' class='field enemy_field'></td>
			<td onclick='cast(2,1,1)' class='field enemy_field'></td>
			<td onclick='cast(3,1,1)' class='field enemy_field'></td>
			<td onclick='cast(4,1,1)' class='field enemy_field'></td>
		</tr>
		<tr>
			<td onclick='cast(0,2,1)' class='field enemy_field'></td>
			<td onclick='cast(1,2,1)' class='field enemy_field'></td>
			<td onclick='cast(2,2,1)' class='field enemy_field'></td>
			<td onclick='cast(3,2,1)' class='field enemy_field'></td>
			<td onclick='cast(4,2,1)' class='field enemy_field'></td>
		</tr>
		<tr>
			<td onclick='cast(0,3,1)' class='field enemy_field'></td>
			<td onclick='cast(1,3,1)' class='field enemy_field'></td>
			<td onclick='cast(2,3,1)' class='field enemy_field'></td>
			<td onclick='cast(3,3,1)' class='field enemy_field'></td>
			<td onclick='cast(4,3,1)' class='field enemy_field'></td>
		</tr>
		<tr>
			<td onclick='cast(0,4,1)' class='field enemy_field'></td>
			<td onclick='cast(1,4,1)' class='field enemy_field'></td>
			<td onclick='cast(2,4,1)' class='field enemy_field'></td>
			<td onclick='cast(3,4,1)' class='field enemy_field'></td>
			<td onclick='cast(4,4,1)' class='field enemy_field'></td>
		</tr>
	</table>
</body>
</html>