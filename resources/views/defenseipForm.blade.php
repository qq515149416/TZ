<!DOCTYPE html>
<html>
<head>
	<title>form</title>
	<script src="/js/jquery.min.js"></script>
</head>
<body>

	<form method="post" action="http://localhost/tz_admin/defenseip/insert">
		<p>
		机房/site:
			<select name="site">
				<option value="1">西安</option>
			</select>
		</p>
		<p>防护值/protection_value:<input type="text" name="protection_value"></p>
		<br/>
		<p id="first">
			ip:<input type="text" name="ip[]">
			<button id="button" type="button">+</button>
		</p>
		<p><input type="submit" name="提交" value="提交"></p>
	</form>
</body>
<script type="text/javascript">
	$("#button").click(function(){
		$("#first").after("<p>ip:<input type='text' name='ip[]'></p>");
	})
</script>
</html>