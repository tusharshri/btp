<!DOCTYPE html>
<html>
<head>
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
function generateLeftBound{
	
}
function generateRightBound{
	
}
</script>
</body>
</html>
