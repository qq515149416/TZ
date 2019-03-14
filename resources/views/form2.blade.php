<!DOCTYPE html>
<html>
<head>
	<title>form</title>
</head>
<body>
	<!-- <form  method="POST" action="http://localhost/tz_admin/news/putImages" enctype='multipart/form-data'>
		<p>images : <input type="file" name="images[]"></p>
	
		<p>images : <input type="file" name="images[]"></p>
		<p><input type="submit" name="提交" value="提交"></p>
	</form> -->

<form method="POST" action="http://localhost/tz_admin/news/putImages" enctype="multipart/form-data">
<input type="hidden" name="_token" value="{{csrf_token()}}">
<input type="file" name="images" />
<input type="submit" name="submit" value="Submit" />
</form>

</body>
</html>