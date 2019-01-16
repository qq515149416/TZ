<!DOCTYPE html>
<html>
<head>
	<title>form</title>
	<script src="/js/jquery.min.js"></script>
</head>
<body>

	<form method="post" action="http://localhost/tz_admin/defenseip/insert">
		<div id="box">
			<p>
			机房/site:
				<select name="site">
					<option value="1">西安</option>
				</select>
			</p>
			<br/>
			<p id="first">
				编号:<input type="text" name="cpu[0]['num']">
				参数:<input type="text" name="cpu[0]['par']">
				<button id="button" type="button">+</button>
			</p>
			<p><input type="submit" name="提交" value="提交"></p>
		</div>
	</form>
</body>
<script type="text/javascript">
	var index = 0;
	$("#button").click(function(){
		index++;
		$("#first").after("<p>编号:<input type='text' name='cpu["+index+"]['num']''> 参数:<input type='text' name='cpu["+index+"]['par']'></p>");
	})
</script>
</html>