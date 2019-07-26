<!DOCTYPE html>
<html>
<head>
	<title>form</title>
	<script src="/js/jquery.min.js"></script>
	<script src="/js/qrcode.min.js"></script>
</head>
<body>
	<div id="qrcode"></div>
</body>

<script type="text/javascript">
	new QRCode(document.getElementById("qrcode"), "{{$url}}");  // 设置要生成二维码的链接
</script>

</html>