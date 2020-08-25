<html>
<head>
<link rel="stylesheet" type="text/css" href="View/test_style.css">
<script src="jquery-3.5.1.js"></script>
<script type="text/javascript">
	var recipes;
	var selectedRecipe = 0;
	$(document).ready(function(){
			loadRecipes();
			loadInventory();
		});
	function loadInventory(){
		$.get("index.php/?target=Inventory&action=getItems",function(data){
				console.log(data);
				var state=JSON.parse(data);
				//console.log(state);
				$("#inventory").html("");
				items=state.items;
				$("#inventory").append("<tr>");
				for(var i=0;i<items.length;i++){
        			$("#inventory").append("<td class='inv inventory'>"+items[i].name+"</br>"+items[i].quantity+"</td>");
        			if(i%5==4){
        				$("#inventory").append("</tr><tr>");
        			}
        		}
        		$("#inventory").append("</tr>");
			});
	}
	function loadRecipes(){
		$.get("index.php/?target=Crafting&action=getRecipes",function(data){
				console.log(data);
				recipes = JSON.parse(data);
				$("#recipes").html("");
				for(var i=0;i<recipes.length;i++){
					$("#recipes").append("<tr>");
					$("#recipes").append("<td onclick='changeSelectedRecipe("+(i+1)+")' class='recipes inv'>"+recipes[i].name+"</td>");
					$("#recipes").append("<td style='width: 32px;'></td>");
					for(var j=0;j<recipes[i].ingredients.length;j++){
						$("#recipes").append("<td class='inv'>"+recipes[i].ingredients[j].name+"</br>"+recipes[i].ingredients[j].quantity+"</td>");
					}
					$("#recipes").append("</tr>");
				}
			});
	}
	function changeSelectedRecipe(ind){
		var recipeSelectors=document.getElementsByClassName("recipes");
		if(selectedRecipe!=0){
    		recipeSelectors[selectedRecipe-1].className="inv recipes";
    	}
    	selectedRecipe=ind;
    	recipeSelectors[ind-1].className="recipes inv_selected";
	}
	function craftItem(){
		if(selectedRecipe==0)return;
		$.post("index.php?target=Crafting&action=craftItem",{recipe_id: recipes[selectedRecipe-1].recipe_id},function(data){
			console.log(data);
			loadInventory();
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
			<td class='selector'><a href="index.php?target=Inventory&action=load">Inventory</a></td>
			<td class='selector'><a href="index.php?target=Shop&action=load">Shop</a></td>
			<td class='selector  selector_selected'><a
				href="index.php?target=Crafting&action=load">Crafting</a></td>
		</tr>
	</table>
	<table id='recipes'>
	</table>
	<button onclick='craftItem()'>craft</button>
	<br/>
	<table id='inventory'>
	</table>
</body>
</html>