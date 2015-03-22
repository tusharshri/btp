<!DOCTYPE html>
<html>
<head>
<title>BTP II</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
	$(document).ready(function(){
	    $("p").click(function(){
	        $(this).hide();
	    });
	});
</script>
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
			echo "<div class='divs' data-row='".$i."' data-column='".$j."' id='".$i."-".$j."'></div>";
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
function same_dir_same_lane_dist(element, cls){
	var row = $(element).data('row');
	var column = $(element).data('column');
	var same_dir_walkers = [];
	var dist = [];
	$('.'+cls+'[data-row='+row+']').each(function(){
		var col = $(this).data('column');
		same_dir_walkers.push(col);
	});
	console.log(same_dir_walkers);
	$.each(same_dir_walkers, function(index, value){
		var val = parseInt(value) - 29;
		dist.push(val);
	});
	console.log(dist);
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
	console.log(opp_dir_walkers);
	$.each(opp_dir_walkers, function(index, value){
		var val = parseInt(value) - 29;
		dist.push(val);
	});
	console.log(dist);
}
function same_dir_top_lane_dist(element, cls){
	console.log("3 success");
}
function opp_dir_top_lane_dist(element, cls, ocls){
	console.log("4 success");
}
function same_dir_bottom_lane_dist(element, cls){
	console.log("5 success");
}
function opp_dir_bottom_lane_dist(element, cls, ocls){
	console.log("6 success");
}
var lbArray = [];
var rbArray = [];
for(var i=0;i<20;i++){
	lbArray.push(Math.floor(Math.random()*30));
}
for(var i=0;i<20;i++){
	rbArray.push(Math.floor(Math.random()*30));
}
$.each(lbArray, function(index, value){
	$('[data-row='+value+'][data-column="29"]').addClass('leftBound');
});
$.each(rbArray, function(index, value){
	$('[data-row='+value+'][data-column="0"]').addClass('rightBound');
});
setTimeout(function() {
      $(".leftBound").each(function(index){
      	var sdsl = same_dir_same_lane_dist(this, 'leftBound');
      	var odsl = opp_dir_same_lane_dist(this, 'leftBound', 'rightBound');
      	// var sdtl = same_dir_top_lane_dist(this, 'leftBound');
      	// var odtl = opp_dir_top_lane_dist(this, 'leftBound', 'rightBound');
      	// var sdbl = same_dir_bottom_lane_dist(this, 'leftBound');
      	// var odbl = opp_dir_bottom_lane_dist(this, 'leftBound', 'rightBound');
      	moveSteps(this, 1, -1, 'leftBound');
      });
      $(".rightBound").each(function(index){
      	// var sdsl = same_dir_same_lane_dist(this, 'rightBound');
      	// var odsl = opp_dir_same_lane_dist(this, 'rightBound', 'leftBound');
      	// var sdtl = same_dir_top_lane_dist(this, 'rightBound');
      	// var odtl = opp_dir_top_lane_dist(this, 'rightBound', 'leftBound');
      	// var sdbl = same_dir_bottom_lane_dist(this, 'rightBound');
      	// var odbl = opp_dir_bottom_lane_dist(this, 'rightBound', 'leftBound');
      	// moveSteps(this, 1, 1, 'rightBound');
      });
}, 1000);

</script>
</body>
</html>
