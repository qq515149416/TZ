<!DOCTYPE html>
<html>
<head>
	<title>form</title>
	<script src="/js/jquery.min.js"></script>
</head>
<body>

	<form method="post" action="delWhiteBatch">
		<div id="box">
			<input type="hidden" name="_token" value="{{csrf_token()}}">
			<p>
			机房/site:
				<select name="site">
					<option value="50">西安</option>
					<option value="41">衡阳</option>
					<option value="45">惠州</option>
				</select>
			</p>
			<br/>
			<!-- <p id="first">
				编号:<input type="text" name="cpu[0]['num']">
				参数:<input type="text" name="cpu[0]['par']">
				<button id="button" type="button">+</button>
			</p> -->

			<p id="first">
				域名:<input type="text" name="del_list[]">
				<button id="button" type="button">+</button>
			</p>

			<p><input type="submit" name="提交" value="提交"></p>
		</div>
	</form>
</body>
<script type="text/javascript">
	// var index = 0;
	// $("#button").click(function(){
	// 	index++;
	// 	$("#first").after("<p>编号:<input type='text' name='cpu["+index+"]['num']''> 参数:<input type='text' name='cpu["+index+"]['par']'></p>");
	// })

	$("#button").click(function(){

		$("#first").after("<p>域名:<input type='text' name='del_list[]'>");
	})
</script>
</html>