<!DOCTYPE html>
<html>
<head>
<title>BTP II</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<style type="text/css">
body{
	margin: 10px;
	padding: 10px;
	font-family: 'Open Sans', sans-serif;
}
.mainContainer{
	width: 2700px;
	height: 270px;
	margin: 0 auto;
}
.dataContainer{
	width: 2700px;
	margin: 0 auto;
}
.divs{
	outline: 1px solid;
	float: left;
	width: 27px;
	height: 27px;
}
.leftBound{
	background:blue;
}
.rightBound{
	background:#000;
}
.dataContainer div{
	float: left;
	padding: 10px;
	margin-top: 20px;
	margin-left: 10px;
	border: 1px #000 dashed;
}
.headContainer{
	margin-bottom: 5px;
	width: 2700px;
	margin: 0 auto;
	text-align: center;
	font-size: 24px;
}
.clear{
	clear: both;
	border: 0px;
}
#pauseSim{
	border: 1px #000 dashed;
	padding: 20px;
	float: right;
	background: red;
	color: #FFF;
	box-shadow: 10px 10px 5px #888888;
	margin-left: 20px;
}
#startSim{
	border: 1px #000 dashed;
	padding: 20px;
	float: right;
	background: green;
	color: #FFF;
	margin-left: 20px;
	margin-right: 50px;
}
</style>
</head>
<body>
	<div class="headContainer">
		<div style="background:#034596; color:#FFF;">
			<b>Pedestrian movement analysis on bi-directional walkways using cellular automata microsimulation</b>
		</div>
	</div>
	<div class="mainContainer">
	<?php
	for($i=0;$i<10;$i++){
		for($j=0;$j<100;$j++){
			$velocities = array(2,3,4);
			echo "<div class='divs' data-velocity='".$velocities[array_rand($velocities)]."' data-row='".$i."' data-column='".$j."' id='".$i."-".$j."'></div>";
		}
	}
	?>
	</div>
	<div class="dataContainer">
		<div style="background:green; color:#FFF;" class="subContainer" id="subc1">
			<b>Total Pedestrians:</b> <input size="2" id="totalPed" value="0" type="number" readonly>
		</div>
		<div style="background:blue; color:#FFF;" class="subContainer" id="subc2">
			<b>Total Left-Bound:</b> <input size="2" id="totalLeftBound" value="0" type="number" readonly>
		</div>
		<div style="background:black; color:#FFF;" class="subContainer" id="subc3">
			<b>Total Right-Bound:</b> <input size="2" id="totalRightBound" value="0" type="number" readonly>
		</div>
		<div class="subContainer" id="pauseSim">
			Pause Simulation
		</div>
		<div class="subContainer" id="startSim">
			Start Simulation
		</div>
	</div>
	<div class="clear">
	</div>

<script type="text/javascript">
var count = 0;
$('#startSim').on('click', function(){
	$("#startSim").remove();
	count++;
	$('#pauseSim').hover(function(ev){
	    clearInterval(timer);
	}, function(ev){
	    timer = setInterval( simulate, 2000);
	});
	function moveSteps(element, steps, direction, cls){
		$(element).removeClass(cls);
	  	var colNewR = parseInt($(element).data('column'))+parseInt(direction)*parseInt(steps);
	  	var rowR = $(element).data('row');
	  	var newElement = $('[data-row='+rowR+'][data-column="'+colNewR+'"]');
	  	var velocity = $(element).data('velocity');
	  	newElement.attr("data-velocity" , '');
	  	newElement.attr("data-velocity" , velocity);
	  	newElement.addClass(cls);
	}
	function stepUp(element, cls){
		$(element).removeClass(cls);
	  	var rowR = parseInt($(element).data('row'))-1;
	  	var colNewR = $(element).data('column');
	  	var newElement = $('[data-row="'+rowR+'"][data-column="'+colNewR+'"]');
	  	var velocity = $(element).data('velocity');
	  	newElement.attr("data-velocity" , '');
	  	newElement.attr("data-velocity" , velocity);
	  	newElement.addClass(cls);
	}
	function stepDown(element, cls){
		$(element).removeClass(cls);
	  	var rowR = parseInt($(element).data('row'))+1;
	  	var colNewR = $(element).data('column');
	  	var newElement = $('[data-row="'+rowR+'"][data-column="'+colNewR+'"]');
	  	var velocity = $(element).data('velocity');
	  	newElement.attr("data-velocity" , '');
	  	newElement.attr("data-velocity" , velocity);
	  	newElement.addClass(cls);
	}
	function get_ocls(cls){
		if(cls=="leftBound"){
			return "rightBound";
		}else if(cls=="rightBound"){
			return "leftBound";
		}
	}
	function checkDown(element, cls){
		var ocls = get_ocls(cls);
		var rowR = parseInt($(element).data('row'))+1;
		if(rowR>9){
			return true;
		}
	  	var colNewR = $(element).data('column');
		if($('.'+cls+'[data-row="'+rowR+'"][data-column="'+colNewR+'"]').length>0||$('.'+ocls+'[data-row="'+rowR+'"][data-column="'+colNewR+'"]').length>0){
	  		return true
	  	}else{
	  		return false;
	  	}
	}
	function checkTop(element, cls){
		var ocls = get_ocls(cls);
		var rowR = parseInt($(element).data('row'))-1;
		if(rowR<0){
			return true;
		}
	  	var colNewR = $(element).data('column');
	  	if($('.'+cls+'[data-row="'+rowR+'"][data-column="'+colNewR+'"]').length>0||$('.'+ocls+'[data-row="'+rowR+'"][data-column="'+colNewR+'"]').length>0){
	  		return true
	  	}else{
	  		return false;
	  	}
		// return .hasClass(cls);
	}
	function checkAllowedMovement(element, cls, sdtl, odtl, sdbl, odbl){
		var ocls = get_ocls(cls);
		if(odtl=='Infinity'||parseInt(sdtl)<parseInt(odtl)){
			return "top";
		}else if(odbl=='Infinity'||parseInt(sdbl)<parseInt(odbl)){
			return "bottom";
		}else{
			return "any";
		}
	}
	function same_dir_same_lane_dist(element, cls){
		var row = $(element).data('row');
		var column = $(element).data('column');
		var same_dir_walkers = [];
		var dist = [];
		$('.'+cls+'[data-row='+row+']').each(function(){
			var col = $(this).data('column');
			same_dir_walkers.push(col);
		});
		// console.log(same_dir_walkers);
		$.each(same_dir_walkers, function(index, value){
			var val = parseInt(value) - parseInt(column);
			if(cls=='leftBound'&&parseInt(val)<0){
				dist.push(Math.abs(val));	
			}else if(cls=='rightBound'&&parseInt(val)>0){
				dist.push(val);	
			}
		});
		return Math.min.apply(Math, dist);
	}
	function opp_dir_same_lane_dist(element, cls, ocls){
		var row = $(element).data('row');
		var column = $(element).data('column');
		var opp_dir_walkers = [];
		var dist = [];
		$('.'+ocls+'[data-row='+row+']').each(function(){
			var col = $(this).data('column');
			opp_dir_walkers.push(col);
		});
		$.each(opp_dir_walkers, function(index, value){
			var val = parseInt(value) - parseInt(column);
			if(cls=='leftBound'&&parseInt(val)<0){
				dist.push(Math.abs(val));	
			}else if(cls=='rightBound'&&parseInt(val)>0){
				dist.push(val);	
			}
		});
		return Math.min.apply(Math, dist);
		// console.log("ODSL: "+dist);
	}
	function same_dir_top_lane_dist(element, cls){
		var row = parseInt($(element).data('row'))-1;
		var column = $(element).data('column');
		var same_dir_walkers = [];
		var dist = [];
		$('.'+cls+'[data-row='+row+']').each(function(){
			var col = $(this).data('column');
			same_dir_walkers.push(col);
		});
		// console.log(same_dir_walkers);
		$.each(same_dir_walkers, function(index, value){
			var val = parseInt(value) - parseInt(column);
			if(cls=='leftBound'&&parseInt(val)<0){
				dist.push(Math.abs(val));	
			}else if(cls=='rightBound'&&parseInt(val)>0){
				dist.push(val);	
			}
		});
		return Math.min.apply(Math, dist);
		// console.log("SDTL: "+dist);
	}
	function opp_dir_top_lane_dist(element, cls, ocls){
		var row = parseInt($(element).data('row'))-1;
		var column = $(element).data('column');
		var opp_dir_walkers = [];
		var dist = [];
		$('.'+ocls+'[data-row='+row+']').each(function(){
			var col = $(this).data('column');
			opp_dir_walkers.push(col);
		});
		// console.log(opp_dir_walkers);
		$.each(opp_dir_walkers, function(index, value){
			var val = parseInt(value) - parseInt(column);
			if(cls=='leftBound'&&parseInt(val)<0){
				dist.push(Math.abs(val));	
			}else if(cls=='rightBound'&&parseInt(val)>0){
				dist.push(val);	
			}
		});
		return Math.min.apply(Math, dist);
		// console.log("ODTL: "+dist);
	}
	function same_dir_bottom_lane_dist(element, cls){
		var row = parseInt($(element).data('row'))+1;
		var column = $(element).data('column');
		var same_dir_walkers = [];
		var dist = [];
		$('.'+cls+'[data-row='+row+']').each(function(){
			var col = $(this).data('column');
			same_dir_walkers.push(col);
		});
		// console.log(same_dir_walkers);
		$.each(same_dir_walkers, function(index, value){
			var val = parseInt(value) - parseInt(column);
			if(cls=='leftBound'&&parseInt(val)<0){
				dist.push(Math.abs(val));	
			}else if(cls=='rightBound'&&parseInt(val)>0){
				dist.push(val);	
			}
		});
		return Math.min.apply(Math, dist);
		// console.log("SDBL: "+dist);
	}
	function opp_dir_bottom_lane_dist(element, cls, ocls){
		var row = parseInt($(element).data('row'))+1;
		var column = $(element).data('column');
		var opp_dir_walkers = [];
		var dist = [];
		$('.'+ocls+'[data-row='+row+']').each(function(){
			var col = $(this).data('column');
			opp_dir_walkers.push(col);
		});
		// console.log(opp_dir_walkers);
		$.each(opp_dir_walkers, function(index, value){
			var val = parseInt(value) - parseInt(column);
			if(cls=='leftBound'&&parseInt(val)<0){
				dist.push(Math.abs(val));	
			}else if(cls=='rightBound'&&parseInt(val)>0){
				dist.push(val);	
			}
		});
		return Math.min.apply(Math, dist);
		// console.log("ODBL: "+dist);
	}
	// gap computation subprocedure starts
	function computeGap(sdsl, odsl, v_max, cls){
		var gap_same = 0;
		var gap_opp = 0;
		if(sdsl<=8){
			gap_same = sdsl-1;
		}else{
			gap_same = 8
		}
		if(odsl<=8){
			gap_opp = parseInt(0.5*odsl);
		}else{
			gap_opp = 4;
		}
		var gap = Math.min(gap_same, gap_opp, v_max);
		return gap;
	}
	// gap computation subprocedure ends
	var lbArray = [];
	var rbArray = [];
	for(var i=0;i<3;i++){
		lbArray.push(Math.floor(Math.random()*10));
	}
	console.log(lbArray);
	for(var i=0;i<3;i++){
		rbArray.push(Math.floor(Math.random()*10));
	}
	console.log(rbArray);
	$.each(lbArray, function(index, value){
		$('[data-row='+value+'][data-column="99"]').addClass('leftBound');
	});
	$.each(rbArray, function(index, value){
		$('[data-row='+value+'][data-column="0"]').addClass('rightBound');
	});
	function findSameDirLane(row, sdsl, odsl, sdtl, odtl, sdbl, odbl){
		if(odtl=='Infinity'&&row!=0){
			return "top";
		}else if(odbl=='Infinity'&&row!=9){
			return "bottom";
		}else if(odbl>=8&&odtl>=8){
			if(sdtl>sdbl&&row!=0){
				return "top";
			}else if(sdbl>sdtl&&row!=9){
				return "bottom";
			}else if(odbl>odtl&&row!=9){
				return "bottom";
			}else if(odtl>odbl&&row!=0){
				return "top";
			}else{
				return "any";
			}
		}else if(odtl>=8&&odbl<8&&row!=0){
			return "top";
		}else if(odbl>=8&&odtl<8&&row!=9){
			return "bottom";
		}else{
			return "any";
		}
	}
	function checkFirstODinRow(ocls, k){
		var row = parseInt(k);
		var column = 0;
		var cls="";
		if(ocls=='rightBound'){
			column = 99;
			cls="leftBound";
		}else if(ocls=='leftBound'){
			column = 0;
			cls="rightBound";
		}
		var opp_dir_walkers = [];
		var dist = [];
		$('.'+ocls+'[data-row='+row+']').each(function(){
			var col = $(this).data('column');
			opp_dir_walkers.push(col);
		});
		$.each(opp_dir_walkers, function(index, value){
			var val = parseInt(value) - parseInt(column);
			if(cls=='leftBound'&&parseInt(val)<0){
				dist.push(Math.abs(val));	
			}else if(cls=='rightBound'&&parseInt(val)>0){
				dist.push(val);	
			}
		});
		return Math.min.apply(Math, dist);
	}
	function checkAvailableLanes(cls){
		var ocls = get_ocls(cls);
		var allowedLanes = [];
		for(var k=0;k<10;k++){
  			if(checkFirstODinRow(ocls, k)<10){
  				continue;
  			}else{
  				allowedLanes.push(k);
  			}	
		}
		return allowedLanes;
	}
	function shuffle(o){
	    for(var j, x, i = o.length; i; j = Math.floor(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
	    return o;
	};
	var simulationStep = 0;
	function simulate(){
		var speed = 0;
		var sidestepVal = 0;
		simulationStep++;
		$(".leftBound").each(function(index){
	      	var sdsl = same_dir_same_lane_dist(this, 'leftBound');
	      	var odsl = opp_dir_same_lane_dist(this, 'leftBound', 'rightBound');
	      	var sdtl = same_dir_top_lane_dist(this, 'leftBound');
	      	var odtl = opp_dir_top_lane_dist(this, 'leftBound', 'rightBound');
	      	var sdbl = same_dir_bottom_lane_dist(this, 'leftBound');
	      	var odbl = opp_dir_bottom_lane_dist(this, 'leftBound', 'rightBound');
	      	var v_max = $(this).data('velocity');
	      	var elRow = parseInt($(this).data('row'));
	      	var gap = parseInt(computeGap(sdsl, odsl, v_max, 'leftBound'));
	      	if(gap>0){
	      		if(odsl<8){
	      			var sameDirectionLane = findSameDirLane(elRow, sdsl, odsl, sdtl, odtl, sdbl, odbl);
	      			if(sameDirectionLane=="bottom"){
	      				if(checkDown(this, 'leftBound')==false){
	      					stepDown(this, 'leftBound');
	      					sidestepVal++;
	      				}else{
			      			moveSteps(this, gap, -1, 'leftBound');
			      			speed = speed + parseInt(gap);
			      		}
	      			}else if(sameDirectionLane=="top"){
	      				if(checkTop(this, 'leftBound')==false){
	      					stepUp(this, 'leftBound');
	      					sidestepVal++;
	      				}else{
			      			moveSteps(this, gap, -1, 'leftBound');
			      			speed = speed + parseInt(gap);
			      		}
	      			}else{
	      				if(odtl>odsl&&elRow!=0){
	      					if(checkTop(this, 'leftBound')==false){
		      					stepUp(this, 'leftBound');
		      					sidestepVal++;
		      				}else{
		      					moveSteps(this, gap, -1, 'leftBound');
		      					speed = speed + parseInt(gap);
		      				}
	      				}else if(odbl>odsl&&elRow!=9){
	      					if(checkDown(this, 'leftBound')==false){
		      					stepDown(this, 'leftBound');
		      					sidestepVal++;
		      				}else{
		      					moveSteps(this, gap, -1, 'leftBound');
		      					speed = speed + parseInt(gap);
		      				}
	      				}else{
	      					moveSteps(this, gap, -1, 'leftBound');
	      					speed = speed + parseInt(gap);
	      				}
		      		}
	      		}else{
	      			moveSteps(this, gap, -1, 'leftBound');
	      			speed = speed + parseInt(gap);
	      		}
	      	}else{
	      		if($(this).data('row')=="0"){
	      			if(checkDown(this, 'leftBound')==false){
			      		stepDown(this, 'leftBound');
			      		sidestepVal++;	
			      	}
	      		}else if($(this).data('row')=="9"){
	      			if(checkTop(this, 'leftBound')==false){
			      		stepUp(this, 'leftBound');
			      		sidestepVal++;
			      	}
	      		}else{
	      			if(checkDown(this, 'leftBound')==false&&checkTop(this,'leftBound')==false){
	      				var movementFavoured = checkAllowedMovement(this, 'leftBound', sdtl, odtl, sdbl, odbl);
	      				if(movementFavoured=='bottom'){
	      					stepDown(this, 'leftBound');
	      					sidestepVal++;
	      				}else if(movementFavoured=='top'){
	      					stepUp(this, 'leftBound');
	      					sidestepVal++;
	      				}else if(movementFavoured=='any'){
	      					stepDown(this, 'leftBound');
	      					sidestepVal++;
	      				}
	      			}else{
	      				if(checkDown(this, 'leftBound')==false){
				      		stepDown(this, 'leftBound');
				      		sidestepVal++;	
				      	}else{
			      			if(checkTop(this, 'leftBound')==false){
					      		stepUp(this, 'leftBound');
					      		sidestepVal++;
					      	}
			      		}
	      			}      			
	      		}
	      		
	      	}
	      });
	      $(".rightBound").each(function(index){
	      	var sdsl = same_dir_same_lane_dist(this, 'rightBound');
	      	var odsl = opp_dir_same_lane_dist(this, 'rightBound', 'leftBound');
	      	var sdtl = same_dir_top_lane_dist(this, 'rightBound');
	      	var odtl = opp_dir_top_lane_dist(this, 'rightBound', 'leftBound');
	      	var sdbl = same_dir_bottom_lane_dist(this, 'rightBound');
	      	var odbl = opp_dir_bottom_lane_dist(this, 'rightBound', 'leftBound');
	      	var v_max = $(this).data('velocity');
	      	var gap = parseInt(computeGap(sdsl, odsl, v_max, 'rightBound'));
	      	var elRow = parseInt($(this).data('row'));
	      	if(gap>0){
	      		if(odsl<8){
	      			var sameDirectionLane = findSameDirLane(elRow, sdsl, odsl, sdtl, odtl, sdbl, odbl);
	      			if(sameDirectionLane=="top"){
	      				if(checkTop(this, 'rightBound')==false){
	      					stepUp(this, 'rightBound');
	      					sidestepVal++;
	      				}else{
			      			moveSteps(this, gap, 1, 'rightBound');
			      			speed = speed + parseInt(gap);
			      		}
	      			}else if(sameDirectionLane=="bottom"){
	      				if(checkDown(this, 'rightBound')==false){
	      					stepDown(this, 'rightBound');
	      					sidestepVal++;
	      				}else{
			      			moveSteps(this, gap, 1, 'rightBound');
			      			speed = speed + parseInt(gap);
			      		}
	      			}else{
		      			if(odtl>odsl&&elRow!=0){
	      					if(checkTop(this, 'rightBound')==false){
		      					stepUp(this, 'rightBound');
		      					sidestepVal++;
		      				}else{
		      					moveSteps(this, gap, 1, 'rightBound');
		      					speed = speed + parseInt(gap);
		      				}
	      				}else if(odbl>odsl&&elRow!=9){
	      					if(checkDown(this, 'rightBound')==false){
		      					stepDown(this, 'rightBound');
		      					sidestepVal++;
		      				}else{
		      					moveSteps(this, gap, 1, 'rightBound');
		      					speed = speed + parseInt(gap);
		      				}
	      				}else{
	      					moveSteps(this, gap, 1, 'rightBound');
	      					speed = speed + parseInt(gap);
	      				}
		      		}
	      		}else{
	      			moveSteps(this, gap, 1, 'rightBound');
	      			speed = speed + parseInt(gap);
	      		}
	      	}else{
	      		if($(this).data('row')=="0"){
	      			if(checkDown(this, 'rightBound')==false){
			      		stepDown(this, 'rightBound');
			      		sidestepVal++;
			      	}
	      		}else if($(this).data('row')=="9"){
	      			if(checkTop(this, 'rightBound')==false){
			      		stepUp(this, 'rightBound');
			      		sidestepVal++;
			      	}
	      		}else{
	      			if(checkDown(this, 'rightBound')==false&&checkTop(this,'rightBound')==false){
	      				var movementFavoured = checkAllowedMovement(this, 'rightBound', sdtl, odtl, sdbl, odbl);
	      				if(movementFavoured=='top'){
	      					stepUp(this, 'rightBound');
	      					sidestepVal++;
	      				}else if(movementFavoured=='bottom'){
	      					stepDown(this, 'rightBound');
	      					sidestepVal++;
	      				}else if(movementFavoured=='any'){
	      					stepUp(this, 'rightBound');
	      					sidestepVal++;
	      				}
	      			}else{
	      				if(checkTop(this, 'rightBound')==false){
				      		stepUp(this, 'rightBound');
				      		sidestepVal++;	
				      	}else{
			      			if(checkDown(this, 'rightBound')==false){
					      		stepDown(this, 'rightBound');
					      		sidestepVal++;
					      	}
			      		}
	      			}      			
	      		}
	      		
	      	}

	      });
			var lanesAvailableLB = checkAvailableLanes('leftBound');
			var lanesAvailableRB = checkAvailableLanes('rightBound');
			lanesAvailableLBS = shuffle(lanesAvailableLB);
			lanesAvailableRBS = shuffle(lanesAvailableRB);
			var countL = 0;
			var countR = 0;
			var lbArray = [];
			var rbArray = [];
			var pedCount = parseInt(parseInt(simulationStep)/50)+1;
			var pedPiv = [pedCount];
			$.each(lanesAvailableLBS, function(index, value){
				var pedPivL = pedPiv[Math.floor(Math.random() * pedPiv.length)];
				if(countL>=pedPivL){
					return false;
				}else{
					lbArray.push(value);
					countL++;
				}
			});
			$.each(lanesAvailableRBS, function(index, value){
				var pedPivR = pedPiv[Math.floor(Math.random() * pedPiv.length)];
				if(countR>=pedPivR){
					return false;
				}else{
					rbArray.push(value);
					countR++;
				}
			});
			$.each(lbArray, function(index, value){
				$('[data-row='+value+'][data-column="99"]').addClass('leftBound');
			});
			$.each(rbArray, function(index, value){
				$('[data-row='+value+'][data-column="0"]').addClass('rightBound');
			});
			var totalLeftBound = $('.leftBound').length;
			var totalRightBound = $('.rightBound').length;
			var totalPed = parseInt(totalLeftBound) + parseInt(totalRightBound);
			$('#totalLeftBound').val(totalLeftBound);
			$('#totalRightBound').val(totalRightBound);
			$('#totalPed').val(totalPed);
			var density = parseInt(totalPed);
			var sidestep = sidestepVal;
			var totalPed = parseInt(totalPed);
			var speed = speed;
			if(simulationStep>30){
				$.ajax({
					type: "POST",
					url: "enterInDB.php",
					dataType: "html",
					data: {density: density, sidestep: sidestep, speed:speed, totalPed: totalPed, simulationStep: simulationStep},
					success: function(data){
						console.log('data entered in db');
					}

				});
			}
			
	}
	var timer = setInterval(simulate, 2000);
});
$('body').keyup(function(e){
	if(count==0){
		if(e.keyCode == 32){
	       $("#startSim").trigger("click");
	       count++
	   	}
	}
});
</script>
</body>
</html>