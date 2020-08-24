<html>
<head>
<link rel="stylesheet" type="text/css" href="View/test_style.css">
<script src="jquery-3.5.1.js"></script>
<script type="text/javascript">
	var items;
	var selectedItem = 0;
	$(document).ready(function(){
			loadInventory();
		});
	function loadInventory(){
		$.get("index.php/?target=Inventory&action=getItems",function(data){
				console.log(data);
				var state=JSON.parse(data);
				//console.log(state);
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
		if(selectedItem!=0){
    		itemSelectors[selectedItem-1].className="inv inventory";
    	}
    	selectedItem=ind;
    	itemSelectors[ind-1].className="inv inventory_selected";
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
			<td class='selector'><a
				href="index.php?target=Shop&action=load">Shop</a></td>
		</tr>
	</table>
	<table id='inventory'>
	</table>
</body>
</html>