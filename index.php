<!DOCTYPE html>
<html>
<head>
<title>BTP II</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<style type="text/css">
body{
	margin: 10px;
	padding: 10px;
}
.mainContainer{
	width: 810px;
	height: 810px;
	margin: 0 auto;
}
.divs{
	outline: 1px solid;
	float: left;
	width: 27px;
	height: 27px;
}
.leftBound{
	background:#008080;
}
.rightBound{
	background:#ADEAEA;
}
</style>
</head>
<body>
	<div class="mainContainer">
	<?php
	for($i=0;$i<30;$i++){
		for($j=0;$j<30;$j++){
			$velocities = array(2,3,4);
			echo "<div class='divs' data-velocity='".$velocities[array_rand($velocities)]."' data-row='".$i."' data-column='".$j."' id='".$i."-".$j."'></div>";
		}
	}
	?>
	</div>

<script type="text/javascript">
function moveSteps(element, steps, direction, cls){
	$(element).removeClass(cls);
  	var colNewR = parseInt($(element).data('column'))+parseInt(direction)*parseInt(steps);
  	var rowR = $(element).data('row');
  	$('[data-row='+rowR+'][data-column="'+colNewR+'"]').addClass(cls);
}
function stepUp(element, cls){
	$(element).removeClass(cls);
  	var rowR = parseInt($(element).data('row'))-1;
  	var colNewR = $(element).data('column');
  	$('[data-row="'+rowR+'"][data-column="'+colNewR+'"]').addClass(cls);
}
function stepDown(element, cls){
	$(element).removeClass(cls);
  	var rowR = parseInt($(element).data('row'))+1;
  	var colNewR = $(element).data('column');
  	$('[data-row="'+rowR+'"][data-column="'+colNewR+'"]').addClass(cls);
}
function checkDown(element, cls){
	var rowR = parseInt($(element).data('row'))+1;
	if(rowR>29){
		return true;
	}
  	var colNewR = $(element).data('column');
	if($('.'+cls+'[data-row="'+rowR+'"][data-column="'+colNewR+'"]').length>0){
  		return true
  	}else{
  		return false;
  	}
}
function checkTop(element, cls){
	var rowR = parseInt($(element).data('row'))-1;
	if(rowR<0){
		return true;
	}
  	var colNewR = $(element).data('column');
  	if($('.'+cls+'[data-row="'+rowR+'"][data-column="'+colNewR+'"]').length>0){
  		return true
  	}else{
  		return false;
  	}
	// return .hasClass(cls);
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
		}else if(cls=='rightBound'&&parseInt(val>0)){
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
		}else if(cls=='rightBound'&&parseInt(val>0)){
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
		}else if(cls=='rightBound'&&parseInt(val>0)){
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
		gap_same = sdsl;
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
for(var i=0;i<10;i++){
	lbArray.push(Math.floor(Math.random()*30));
}
for(var i=0;i<10;i++){
	rbArray.push(Math.floor(Math.random()*30));
}
$.each(lbArray, function(index, value){
	$('[data-row='+value+'][data-column="29"]').addClass('leftBound');
});
$.each(rbArray, function(index, value){
	$('[data-row='+value+'][data-column="0"]').addClass('rightBound');
});
setInterval(function() {
      $(".leftBound").each(function(index){
      	var sdsl = same_dir_same_lane_dist(this, 'leftBound');
      	var odsl = opp_dir_same_lane_dist(this, 'leftBound', 'rightBound');
      	var sdtl = same_dir_top_lane_dist(this, 'leftBound');
      	var odtl = opp_dir_top_lane_dist(this, 'leftBound', 'rightBound');
      	var sdbl = same_dir_bottom_lane_dist(this, 'leftBound');
      	var odbl = opp_dir_bottom_lane_dist(this, 'leftBound', 'rightBound');
      	var v_max = $(this).data('velocity');
      	var gap = parseInt(computeGap(sdsl, odsl, v_max, 'leftBound'));
      	if(gap>0){
      		moveSteps(this, gap, -1, 'leftBound');	
      	}else{
      		if($(this).data('row')=="0"){
      			if(checkDown(this, 'leftBound')==false){
		      		stepDown(this, 'leftBound');	
		      	}
      		}else if($(this).data('row')=="29"){
      			if(checkTop(this, 'leftBound')==false){
		      		stepUp(this, 'leftBound');	
		      	}
      		}else{
      			if(checkDown(this, 'leftBound')==false){
		      		stepDown(this, 'leftBound');	
		      	}else{
	      			if(checkTop(this, 'leftBound')==false){
			      		stepUp(this, 'leftBound');	
			      	}
	      		}
      		}
      		
      	}
      	
      	// console.log(sdsl);
      	// console.log(odsl);
      	// console.log(sdtl);
      	// console.log(odtl);
      	// console.log(sdbl);
      	// console.log(odbl);
      	// moveSteps(this, 1, -1, 'leftBound');
      	// if(checkDown(this, 'leftBound')==false){
      	// 	stepDown(this, 'leftBound');	
      	// }
      	// if(checkTop(this, 'leftBound')==false){
      	// 	stepUp(this, 'leftBound');	
      	// }
      	// stepUp(this, 'leftBound');
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
      	if(gap>0){
      		moveSteps(this, gap, 1, 'rightBound');	
      	}else{
      		if($(this).data('row')=="0"){
      			if(checkDown(this, 'rightBound')==false){
		      		stepDown(this, 'rightBound');	
		      	}
      		}else if($(this).data('row')=="29"){
      			if(checkTop(this, 'rightBound')==false){
		      		stepUp(this, 'rightBound');	
		      	}
      		}else{
      			if(checkDown(this, 'rightBound')==false){
		      		stepDown(this, 'rightBound');	
		      	}else{
	      			if(checkTop(this, 'rightBound')==false){
			      		stepUp(this, 'rightBound');	
			      	}
	      		}
      		}
      		
      	}

      });
		var lbArray = [];
	  	for(var i=0;i<10;i++){
			lbArray.push(Math.floor(Math.random()*30));
		}
		$.each(lbArray, function(index, value){
			$('[data-row='+value+'][data-column="29"]').addClass('leftBound');
		});
		var rbArray = [];
		for(var i=0;i<10;i++){
			rbArray.push(Math.floor(Math.random()*30));
		}
		$.each(rbArray, function(index, value){
			$('[data-row='+value+'][data-column="0"]').addClass('rightBound');
		});
}, 1000);

</script>
</body>
</html>
