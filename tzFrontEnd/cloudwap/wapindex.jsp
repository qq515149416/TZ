<%@ page language="java" import="java.util.*" pageEncoding="utf-8"%>
<%
String path = request.getContextPath();
String basePath = request.getScheme()+"://"+request.getServerName()+":"+request.getServerPort()+path+"/";
%>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <base href="<%=basePath%>">
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>云手机端</title>
    
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">    
	<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
	<meta http-equiv="description" content="This is my page">
	<!--
	<link rel="stylesheet" type="text/css" href="styles.css">
	-->
	<script type="text/javascript" src="tz/js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="tz/js/bgjs/zynavigation.js"></script> 
 <style>
        body{
            margin: 0;
            padding: 0;
        }
        .bgimg{
	            width: 100%;
	            height: 100%;
	     }
	     .bgimg img{
	     	display: block;
	     }
        @media (min-width:200px){
	        .bgbtn{
	        	width: 46%;
	        	margin: 0 auto;
	        	margin-top: -70%;
	        	cursor:pointer;
	        }
        }
        @media (min-width:480px){
	        .bgbtn{
	        	width: 45%;
	        	margin: 0 auto;
	        	margin-top: -70%;
	        	cursor:pointer;
	        }
        }
        @media (min-width:720px){
	        .bgbtn{
	        	width: 45%;
	        	margin: 0 auto;
	        	margin-top: -70%;
	        	cursor:pointer;
	        }
        }
        @media (min-width:1080px){
	        .bgbtn{
	        	width: 45%;
	        	margin: 0 auto;
	        	margin-top: -70%;
	        	cursor:pointer;
	        }
        }
        @media (min-width:1400px){
	        .bgbtn{
	        	width: 45%;
	        	margin: 0 auto;
	        	margin-top: -70%;
	        	cursor:pointer;
	        }
        }
        @media (min-width:2000px){
	        .bgbtn{
	        	width: 45%;
	        	margin: 0 auto;
	        	margin-top: -70%;
	        	cursor:pointer;
	        }
        }
        .wapnav{
        	width: 100%;
        	height: 20%;
        	position: absolute;
        	font-size: 40px;
        }
        .wapnav ul{
        	list-style: none;
        	padding-left: 0;
        }
        .wapnav ul li{
        	float: left;
        	width: 25%;
        	text-align: center;
        	height: 10%;
        }
        .wapnav ul li a{
        	color: #fff;
        	text-decoration: none;
        	font-weight: 700;
        }
        
         .wapnav ul li a:HOVER {
			border-bottom: 4px red solid;
		}
    </style>
  </head>
  
  <body>
        <div class="bgimg">
        	<div class="wapnav">
        		<ul>
        			<li><a href="/">首页</a></li>
        			<li><a href="/tz/zygfzy.jsp">服务器租用</a></li>
        			<li><a href="/tz/zytg.jsp">服务器托管</a></li>
        			<li><a href="/tz/fcdun.jsp">防C盾</a></li>
        		</ul>
        	</div>
            <img src="tz/cloudwap/wbgimg.png" width="100%" heght="100%">
            <img class="bgbtn" src="tz/cloudwap/lijigoumai.png" onclick="randomqq()">
        </div>
    </body>
</html>
