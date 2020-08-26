<html>
<head>
<link rel="stylesheet" type="text/css" href="View/test_style.css">
<script src="jquery-3.5.1.js"></script>
<script type="text/javascript">
	var characters, talents;
	var selectedCharacter = 0;
	$(document).ready(function(){
			for(var y=0;y<6;y++){
				$("#talents").append("<tr>");
				for(var x=0;x<4;x++){
					$("#talents").append("<td class='talents inv'></td>");
				}
				$("#talents").append("</tr>");
			}
			loadCharacters();
		});
	function loadCharacters(){
		$.get("index.php/?target=CombatSetup&action=loadCharacters",function(data){
				characters=JSON.parse(data).characters;
				for(var i=0;i<characters.length;i++){
					//console.log(enemies[i].enemy_id);
					$("#character_list").append("<td onclick='changeCurrentlySelectedCharacter("+(i+1)+")' class='selector friendly_selector'>"+characters[i].name+"</td>");
				}
			});
	}
	function changeCurrentlySelectedCharacter(ind){
    	var friendlySelectors=document.getElementsByClassName("friendly_selector")
    	if(selectedCharacter!=0){
    		friendlySelectors[selectedCharacter-1].className="selector friendly_selector"
    	}
    	selectedCharacter=ind
    	friendlySelectors[ind-1].className="selector_selected friendly_selector"
    	loadTalents();
    }
    function levelTalent(ind){
    	console.log(ind);
    	$.post("index.php?target=Talents&action=levelTalent",{character_id: characters[selectedCharacter-1].character_id, talent: talents[ind].ind},function(data){
			console.log(data);
			loadTalents();
		});
    }
    function loadTalents(){
    	$.post("index.php?target=Talents&action=getTalents",{character_id: characters[selectedCharacter-1].character_id},function(data){
			console.log(data);
			talents=JSON.parse(data);
			var talentSpots=document.getElementsByClassName("talents");
			console.log(talents);
			for(var i=0;i<talents.length;i++){
				talentSpots[talents[i].disp_y*4+talents[i].disp_x*1].innerHTML=talents[i].name+"</br>"+talents[i].rank+"/"+talents[i].max_rank;
				talentSpots[talents[i].disp_y*4+talents[i].disp_x*1].setAttribute('onClick', 'levelTalent('+i+')');
			}
		});
    }
    function resetTalents(){
    	$.post("index.php?target=Talents&action=resetTalents",{character_id: characters[selectedCharacter-1].character_id},function(data){
			console.log(data);
			loadTalents();
		});
    }
    </script>
</head>
<body>
	<table>
		<tr>
			<td class='selector'><a
				href="index.php?target=CombatSetup&action=home">Battle</a></td>
			<td class='selector'><a href="index.php?target=Map&action=load">Map</a>
			</td>
			<td class='selector'><a
				href="index.php?target=Inventory&action=load">Inventory</a></td>
			<td class='selector'><a href="index.php?target=Shop&action=load">Shop</a></td>
			<td class='selector'><a href="index.php?target=Crafting&action=load">Crafting</a></td>
			<td class='selector selector_selected'><a
				href="index.php?target=Talents&action=load">Talents</a></td>
		</tr>
	</table>
	<table id='character_list'>
	</table>
	<table id='talents'>
	</table>
	<button onclick='resetTalents()'>reset</button>
</body>
</html>