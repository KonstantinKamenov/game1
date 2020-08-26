<html>
<head>
<link rel="stylesheet" type="text/css" href="View/test_style.css">
<script src="jquery-3.5.1.js"></script>
<script type="text/javascript">
	var items, sellOffers, buyOffers;
	var selectedSellOffer = 0;
	var selectedBuyOffer = 0;
	$(document).ready(function(){
			loadBuyOffers();
			loadInventory();
			loadGold();
			loadSellOffers();
		});
	function loadInventory(){
		$.get("index.php/?target=Shop&action=getItems",function(data){
				console.log(data);
				var state=JSON.parse(data);
				//console.log(state);
				items=state.items;
				$("#inventory").html("<tr>");
				for(var i=0;i<items.length;i++){
        			$("#inventory").append("<td class='inv inventory'>"+items[i].name+"</br>"+items[i].quantity+"</td>");
        			if(i%5==4){
        				$("#inventory").append("</tr><tr>");
        			}
        		}
        		$("#inventory").append("</tr>");
			});
	}
	function loadGold(){
		$.get("index.php/?target=Shop&action=getGold",function(data){
				console.log(data);
				var state=JSON.parse(data);
				//console.log(state);
				gold=state.gold;
				$("#gold").text("gold: "+gold);
			});
	}
	function loadSellOffers(){
		$.get("index.php/?target=Shop&action=getSellOffers",function(data){
				console.log(data);
				var state=JSON.parse(data);
				//console.log(state);
				sellOffers=state.offers;
				$("#selling").append("<tr>");
				for(var i=0;i<sellOffers.length;i++){
        			$("#selling").append("<td onclick='changeSelectedSellOffer("+(i+1)+")' class='inv shop_sell'>"+sellOffers[i].name+"</br>"+sellOffers[i].cost+"</td>");
        			if(i%5==4){
        				$("#selling").append("</tr><tr>");
        			}
        		}
        		$("#selling").append("</tr>");
			});
	}
	function loadBuyOffers(){
		$.get("index.php/?target=Shop&action=getBuyOffers",function(data){
				console.log(data);
				var state=JSON.parse(data);
				//console.log(state);
				buyOffers=state.offers;
				$("#buying").append("<tr>");
				for(var i=0;i<buyOffers.length;i++){
        			$("#buying").append("<td onclick='changeSelectedBuyOffer("+(i+1)+")' class='inv shop_buy'>"+buyOffers[i].name+"</br>"+buyOffers[i].cost+"</td>");
        			if(i%5==4){
        				$("#buying").append("</tr><tr>");
        			}
        		}
        		$("#buying").append("</tr>");
			});
	}
	function changeSelectedSellOffer(ind){
		var offerSelectors=document.getElementsByClassName("shop_sell");
		if(selectedSellOffer!=0){
    		offerSelectors[selectedSellOffer-1].className="inv shop_sell";
    	}
    	selectedSellOffer=ind;
    	offerSelectors[ind-1].className="inv_selected shop_sell";
	}
	function changeSelectedBuyOffer(ind){
		var offerSelectors=document.getElementsByClassName("shop_buy");
		if(selectedBuyOffer!=0){
    		offerSelectors[selectedBuyOffer-1].className="inv shop_buy";
    	}
    	selectedBuyOffer=ind;
    	offerSelectors[ind-1].className="inv_selected shop_buy";
	}
	function sellItem(){
		if(selectedBuyOffer==0)return;
		$.post("index.php?target=Shop&action=sellItem",{item_id: buyOffers[selectedBuyOffer-1].item_id},function(data){
			console.log(data);
			loadGold();
			loadInventory();
		});
	}
	function buyItem(){
		if(selectedSellOffer==0)return;
		$.post("index.php?target=Shop&action=buyItem",{item_id: sellOffers[selectedSellOffer-1].item_id},function(data){
			console.log(data);
			loadGold();
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
			<td class='selector'><a href="index.php?target=Map&action=load">Map</a></td>
			<td class='selector'><a href="index.php?target=Inventory&action=load">Inventory</a></td>
			<td class='selector selector_selected'><a
				href="index.php?target=Shop&action=load">Shop</a></td>
			<td class='selector'><a href="index.php?target=Crafting&action=load">Crafting</a></td>
			<td class='selector'><a href="index.php?target=Talents&action=load">Talents</a></td>
		</tr>
	</table>
	<div id='gold'></div>
	<table id='selling'></table>
	<button onclick='buyItem()'>buy</button>
	<table id='buying'></table>
	<button onclick='sellItem()'>sell</button>
	<table id='inventory'>
	</table>
</body>
</html>