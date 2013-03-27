<?php echo  $this->load->view("layouts/main.php");?>
<style>
body{

}
.main{
	margin:0px 0;
	background:url(/images/main.jpg) ;
	color: white;
	height: 420px;
	/*text-shadow: 0 4px 0 #141414;*/

}
</style>

<div class="main" style="">
	<div style="background:rgba(255, 255, 255, 0.85) ;height: 380px;">
	<div style="font-size:40px;color:#000;">
		<div style="float:left;width:300px">
			<div style="margin:30px">实现梦想从写下它开始。</div>
		</div>

		<div style="float:right;">
			<div style="margin:40px 10px 0 0"><img src="http://www.sinaimg.cn/blog/developer/wiki/48.png" /></div>
			<div style="margin:20px 10px 0 0"><img src="http://qzonestyle.gtimg.cn/qzone/vas/opensns/res/img/Connect_logo_5.png" /></div>
		</div>
	</div>

	</div>
</div>
<div style="font-size: 20px;background: transparent;color: #fff;position: relative;margin:-30px 0 0 20px">一个月不迟到00001212<img style="margin-left:10px" src="http://www.plan.com/images/Check-icon.png" /></div>
<script>
function get_playlist() {
    $.ajax({
        url: 'http://douban.fm/j/mine/playlist?type=s&sid=1028208&channel=1&from=radio&r=863bbc1183',
        dataType: 'json',
        success: function(data) {
            console.log(data);
        }
      });
}

</script>
<?php echo  $this->load->view("layouts/footer");?>