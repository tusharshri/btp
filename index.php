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
setInterval(function() {
      $(".leftBound").each(function(index){
      	moveSteps(this, 1, -1, 'leftBound');
      });
      $(".rightBound").each(function(index){
      	moveSteps(this, 1, 1, 'rightBound');
      });
}, 1000);

</script>
</body>
</html>
