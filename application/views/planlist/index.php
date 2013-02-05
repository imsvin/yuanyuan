<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-CN" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $listinfo['content'].' - '.$userinfo['username']; ?></title>
<link type="text/css" rel="stylesheet" media="all"  href="/css/list.css" />
<link type="text/css" rel="stylesheet" media="all"  href="/css/jquery.jgrowl.css" />
<link type="text/css" rel="stylesheet" media="all"  href="/css/fileuploader.css" />
<link type="text/css" rel="stylesheet" media="all"  href="/css/skins/twitter.css" />
<style type="text/css">
jquery.jgrowl_minimized.js
	div.jGrowl-notification {
		float: 			right;
		margin-left: 	6px;
	}
</style>
<script type="text/javascript" src="/js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="/js/jquery.tools.min.js"></script>
<script type="text/javascript" src="/js/jquery.jgrowl_minimized.js"></script>
<script type="text/javascript" src="/js/json2.js"></script>
<script type="text/javascript" src="/js/jquery.artDialog.js?skin=twitter"></script>

		<script type="text/javascript">
		(function($){
			$(document).ready(function(){
				$.jGrowl.defaults.closer = false;
				if ( !$.browser.safari ) {
					$.jGrowl.defaults.animateOpen = {
						width: 'show'
					};
					$.jGrowl.defaults.animateClose = {
						width: 'hide'
					};
				}
				//$.jGrowl('', { sticky: true });
			});
		})(jQuery);

		var Plan = {
			    'uid' : <?php echo $listinfo['uid']; ?>
			};

		var THE_SELECT_ID = 0;
	    var PLANLIST_ID = <?php echo $listinfo['plan_id'];?>;


		</script>
		<script type="">
function share2sina(){
	window.open('http://v.t.sina.com.cn/share/share.php?url='+encodeURIComponent(location.href)+'&title=<?php echo $userinfo['username'].' - '.urlencode($listinfo['content']); ?>&source=&sourceUrl=&content=utf-8');
}
	</script>
</head>
<body>
	<div id="header_content">
		<div id="header_div">
		<div id="header">
		<div class="header_left">
		<?php if ($this->uid){?>
		<a href="/user/"><?php echo $this->username?>的账号</a>  |
		<a href="/site/logout/">退出</a>
		<?php }else {?>
		<a href="/site/login/">登录</a>
		  | <a href="/site/register/">注册</a>
		<?php }?> <span id="tosina"></span>
		</div>
		<div class="header_right" style="display:none">
			<a href="#" title="分享到新浪微博" onclick="share2sina();">
				<img align="absmiddle" src="/images/share_hover.png" alt="分享到新浪微博" >
			</a>
		</div>
		</div>
		</div>
	</div>

<div id="wrapper">
	<div id="content" class="content_box featurettes">
	<?php if ($listinfo['planlist_id']) { ?>
		<div id="back_to_parent" style="margin:10px 0 0 10px"><a href="<?php echo '/'.$userinfo['uid'].'/';?>">&lt;&lt; <?php echo $daddy_listinfo['content']?></a></div>
	<?php }?>
		<div class="list_content">
			<div class="title" >
				<h2 id="main-title-h2" planid="<?php echo $listinfo['plan_id']?>">
					<span id="main-title"><?php echo $listinfo['content'];?></span>
				</h2>

				<div class="clear"></div>
			    <div id="trigger" style="float: right;display:none;"><span style="display: block;font-size:14px;text-align: right;margin:10px 100px 10px 0px;">来自<a href="#" id="showuserinfo"><?php echo $userinfo['username']?></a></span>
					<div class="tooltip">
						<table id="dpop" style="font-size:12px">
		                <tr>
			                <td>
				                <div class="avatar48">
					                <a href="#">
					                <img src="/avatar/avatar_small/<?php echo $userinfo['avatar']?$userinfo['avatar']:'noavatar'; ?>_small.jpg" ></a>
				                </div>
			                </td>
		                	<td>
							    <div class="name clearFix" style="margin-left:10px">
							        <div class="name_card_con0" style="width:170px">
							        	<?php if ($userinfo['sina']){?>
							        	<a href="<?php echo $userinfo['sina'];?>"  target="_blank" /><?php echo $userinfo['username']?> </a>
							        	<p style="margin:5px 0">
							        		<img src="http://open.sinaimg.cn/wikipic/logo/LOGO_16x16.png" />
							        		<a href="http://<?php echo str_replace('http://', '', $userinfo['sina']); ?>" target="_blank"><?php echo str_replace('http://', '', $userinfo['sina']); ?></a>
							        	</p>
							        	<?php }else{
							        		echo $userinfo['username'];
							        	}?>
							        </div>
							    </div>
							</td>
		                </tr>
		                <tr>
							<td colspan='2'><div class="info clear"></div>
								<p class="gray6"><?php echo $userinfo['introduction']?></p>
						    </td>
		                </tr>
		        		</table>
					</div>

			    </div>

					<div class="clear"></div>

			</div>
			<?php
					if($listinfo['type'] != 1){
						echo $this->load->view("planlist/folder/images.php",array('plans'=>$plans,'listinfo'=>$listinfo, 'userinfo'=>$userinfo));
					}else{
						echo $this->load->view("planlist/folder/edit_new.php",array('plans'=>$plans,'listinfo'=>$listinfo, 'userinfo'=>$userinfo, 'canupdate' => $canupdate));
					}

				?>



		</div>


	</div>
<div class="clear"></div>


</div>



<div id="uploadpic" >

</div>


<?php

// 	foreach ($plans as $key=> $plan ) {
// 			echo '<div class="apple_overlay" id="dream_pic'.$plan['plan_id'].'">
// 			<img src="/uploads/_middle/'. $plan['images'] .'" />
// 			</div> ';
// 	}
?>


	<div id="footer">

	</div>





<script type="text/javascript" charset="utf-8">

$("#showuserinfo").tooltip({
	   // tweak the position
	   offset: [10, 2],
	   // use the "slide" effect
	   effect: 'slide',
		position: 'bottom center'
	// add dynamic plugin with optional configuration for bottom edge
	}).dynamic({ bottom: { direction: 'down', bounce: true } });
$("#dreamslistul .dream_img_icon").tooltip({ position: "bottom center",effect: 'slide'});

$(function() {
	if($.browser.msie) {
		alert("亲爱的，换个浏览器吧，别用IE了。");
		window.close();
	}
	///$("#dreamslistul img[rel]").overlay({effect: 'apple'});
});
</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-22614857-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>