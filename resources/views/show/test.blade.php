<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>测试页面</title>
</head>
<body>
<!-- /resources/views/show/test.blade.php -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Create Post Form -->
<form action="/tz_admin/rules" method="post">
    <input type="text" id="post_test_title" placeholder="TITLE" />
    <button id="post_test">提交</button>
</form>
  
</body>
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
     <script type="text/javascript">
        // $(function() {
        //     $("#post_test").click(function() {
        //         $.post("/tz_admin/rules",{
        //             title: $("#post_test_title").val()
        //         },function(data) {
        //             console.log(data);
        //         })
        //     });
        // });
    </script>
</html>