<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="/css/css.css" />

	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="/css/ie.css" media="screen, projection" />
	<![endif]-->
<script type="text/javascript" src="/js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="/js/jquery.jgrowl_minimized.js"></script>
<script type="text/javascript" src="/js/global.js"></script>
<meta property="wb:webmaster" content="916ad22a19c63dd0" />
	<title></title>
</head>

<body>
<div class="header_div">
	<div id="header_content">

		<div id="head-logo">
			<a data-track="home" href="/"><img src="/images/logo.jpg" width="170" /></a>
		</div>
		<div id="head-status">
		<div class="header_left">
		<?php if ($this->uid){?>
		<a href="/user/"><?php echo $this->username;?>的账号</a>  |
		<a  href="/site/logout/">退出</a>
		<?php }else {?>
		<a href="/site/login/">登录</a>
		  | <a  href="/site/register/">注册</a>
		<?php }?>
		</div>

		</div>
	</div>


</div>
<div id="wrapper">


	<div id="content" class="content_box featurettes">
		<ul id="menu">

				<li><a href="/">首页</a></li>
				<?php //<li  class="active" ><a href="#">衣服</a></li>?>
				<li><a href="/<?php echo $this->uid ?>">我的主页</a></li>
				<li><a href="#">Jump!</a></li>
			</ul>


