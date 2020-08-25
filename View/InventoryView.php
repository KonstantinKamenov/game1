<html>
<head>
<link rel="stylesheet" type="text/css" href="View/test_style.css">
<script src="jquery-3.5.1.js"></script>
<script type="text/javascript">
	var items, characters;
	var selectedItem = 0, selectedCharacter = 0;
	$(document).ready(function(){
			loadCharacters();
			loadInventory();
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
	function loadInventory(){
		$.get("index.php/?target=Inventory&action=getItems",function(data){
				console.log(data);
				var state=JSON.parse(data);
				//console.log(state);
				$("#inventory").html("");
				items=state.items;
				$("#inventory").append("<tr>");
				for(var i=0;i<items.length;i++){
        			$("#inventory").append("<td onclick='changeSelectedItem("+(i+1)+")' class='inv inventory'>"+items[i].name+"</br>"+items[i].quantity+"</td>");
        			if(i%5==4){
        				$("#inventory").append("</tr><tr>");
        			}
        		}
        		$("#inventory").append("</tr>");
			});
	}
	function changeSelectedItem(ind){
		var itemSelectors=document.getElementsByClassName("inventory");
		console.log(selectedItem);
		if(selectedItem!=0){
    		itemSelectors[selectedItem-1].className="inv inventory";
    	}
    	selectedItem=ind;
    	itemSelectors[ind-1].className="inventory inv_selected";
	}
	function changeCurrentlySelectedCharacter(ind){
    	var friendlySelectors=document.getElementsByClassName("friendly_selector")
    	if(selectedCharacter!=0){
    		friendlySelectors[selectedCharacter-1].className="selector friendly_selector"
    	}
    	selectedCharacter=ind
    	friendlySelectors[ind-1].className="selector_selected friendly_selector"
    	loadCharacterInventory();
    }
    function loadCharacterInventory(){
    	$.post("index.php?target=Inventory&action=getCharactersInventory",{character_id: characters[selectedCharacter-1].character_id},function(data){
			console.log(data);
			$("#character_inventory").html("");
			var armor = JSON.parse(data);
			console.log(armor);
			var helm="", chest="", weapon="";
			if(armor.helm){
				helm = armor.helm.name;
			}
			if(armor.chest){
				chest = armor.chest.name;
			}
			if(armor.weapon){
				weapon = armor.weapon.name;
			}
			$("#character_inventory").append("<td onclick = 'changeEquippment(\"helm\")' class='inv'>"+helm+"</td>");
			$("#character_inventory").append("<td onclick = 'changeEquippment(\"chest\")' class='inv'>"+chest+"</td>");
			$("#character_inventory").append("<td onclick = 'changeEquippment(\"weapon\")' class='inv'>"+weapon+"</td>");
		});
    }
    function changeEquippment(slot){
    	var itemSelectors=document.getElementsByClassName("inventory");
    	if(selectedItem!=0){
    		itemSelectors[selectedItem-1].className="inv inventory";
    	}
    	
    	$.post("index.php?target=Inventory&action=unequipItem",{character_id: characters[selectedCharacter-1].character_id, slot: slot},function(data){
			console.log(data);
		});
		$.post("index.php?target=Inventory&action=unequipItem",{character_id: characters[selectedCharacter-1].character_id, slot: slot},function(data){
			console.log(data);
		});
		if(selectedItem!=0){
    		$.post("index.php?target=Inventory&action=equipItem",{character_id: characters[selectedCharacter-1].character_id, slot: slot, item_id: items[selectedItem-1].item_id},function(data){
    			console.log(data);
    		});
		}
		selectedItem=0;
		loadInventory();
		loadCharacterInventory();
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
			<td class='selector selector_selected'><a
				href="index.php?target=Inventory&action=load">Inventory</a></td>
			<td class='selector'><a href="index.php?target=Shop&action=load">Shop</a></td>
			<td class='selector'><a href="index.php?target=Crafting&action=load">Crafting</a></td>
		</tr>
	</table>
	<table id='character_list'>
	</table>
	<table id='character_inventory'>
	</table>
	<table id='inventory'>
	</table>
</body>
</html>