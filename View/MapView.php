<html>
<head>
<link rel="stylesheet" type="text/css" href="View/test_style.css">
<script src="jquery-3.5.1.js"></script>
<script type="text/javascript">
	var zones;
	var locationInd;
	$(document).ready(function(){
			loadLocations();
		});
	function loadLocations(){
		$.get("index.php/?target=Map&action=getLocations",function(data){
				console.log(data);
				var state=JSON.parse(data);
				//console.log(state);
				zones=state.zones;
				for(var i=0;i<zones.length;i++){
					var classname="'selector location_selector'";
					if(zones[i].zone_id==state.current){
						classname="'selector_selected location_selector'";
						locationInd=i;
					}
        			$("#locations").append("<td onclick='changeLocation("+i+")' class="+classname+">"+zones[i].name+"</td>");
        		}
			});
	}
	function changeLocation(ind){
		var locationSelectors=document.getElementsByClassName("location_selector")
    	locationSelectors[locationInd].className="selector location_selector";
    	locationInd=ind;
    	locationSelectors[ind].className="selector_selected location_selector";
    	$.post("index.php?target=Map&action=changeLocation",{zone_id: zones[ind].zone_id},function(data){
    	console.log(data);
		});
	}
    </script>
</head>
<body>
	<table>
		<tr>
			<td class='selector'><a
				href="index.php?target=CombatSetup&action=home">Battle</a></td>
			<td class='selector selector_selected'><a
				href="index.php?target=Map&action=load">Map</a></td>
		</tr>
	</table>
	<table>
	<tr id='locations'>
	</tr>
	</table>
</body>
</html>