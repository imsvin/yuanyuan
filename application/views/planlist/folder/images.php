<style>
#image_ul li{height:110px;overflow: hidden;background-color: white;}
.show_big_pic{position: absolute;display:none;font-size:24px;max-height:350px;max-width:350px;

}

 .pink_li li{
	background-color: pink!important;
}

.show_big_pic span{
	background-color: white;
}

.img_content{font-size:24px;
height: 110px;
width: 110px;
overflow: hidden;

}

.big_pic_count{
	filter:alpha(opacity=80);       /* IE */
	-moz-opacity:0.8;              /* Moz + FF */
	opacity: 0.8;           /* 支持CSS3的浏览器（FF 1.5也支持）*/
	font-size:50px;
	position: absolute;
	top: 315px;
	margin-left: 190px;
	color:#fff;
}

#image_ul .change{
	height: 59px;
	width: 59px;
}

#image_ul .change img{
	height: 59px;
	width: 59px;
}

</style>
<div class="widget-photo-list" id="dreamslistul">
<ul class="list-s" id="image_ul">
<?php
shuffle($plans);
$plans += $plans;
$plans += $plans;
?>
<?php foreach ($plans as $key=> $plan):?>
<?php if (!$plan['images']):?>

<li><span onclick="asdasd(this);" id="<?php echo $plan['plan_id'] ?>" ref="<?php echo $plan['images']?>" class="img_content"><img class="pretend_image_link" src="http://img3.douban.com/mpic/s11097378.jpg" /></span></li>
<?php else: ?>
<li><span onclick="asdasd2(this);" id="<?php echo $plan['plan_id'] ?>" ref="<?php echo $plan['content']?>" class="img_content"><?php echo $plan['content']?></span></li>
<?php endif;?>
<?php endforeach;?>
</ul>
</div>

<div id="show_big_pic" class="show_big_pic" onclick="closed_big_pic();">
</div>

<div class="big_pic_count"><span id="totalpic"><?php echo count($plans)?></span> / 100</div>



<div class="clear"></div>
<?php if($this->uid == $listinfo['uid']):?>
<div style="text-align: center;margin-top:30px;"><a href="#" onclick="show_add_plan_div();return false">添加一行</a></div>



	<div id="add_new_plan_div" style="height:300px">
		<div class="list_info">
			<input type="text"  value="" id="new_content" class="pb-input-text"/><input type="button" value="添加" class="g_button" onclick="plan_add()" />
		</div>
		<span class="publisher_image">
	      		<div style="float:left;">
	      		<span onclick="showTooltipContainer();"><img src="/images/pic_btn_icon.png" class="small_icon picnormal" title="图片" />图片</span>
	      		<div class="TooltipContainer" id="TooltipContainer" style="display:none">
	      		<div class="TooltipContent">
	      		<div style="text-align:center;margin-top:30px" id="upload_img_toolbar">
	      		<div id="file-uploader-demo1">
	      		</div>
	      		</div>
	      		</div>;
		      		<Tooltip_s>
			      		<Tooltip_i>
			      		</Tooltip_i>
		      		</Tooltip_s>
	      		</div>
	      		</div>
	     </span>
	</div>

<?php endif;?>
    <script src="/js/fileuploader.js" type="text/javascript"></script>
     <script src="/js/editlist.js" type="text/javascript"></script>

<script>


function start_my_show_1(){
	var ul = $('#image_ul li span');

	for(var i = 0;i<ul.length;i++){
		var id = ul[i].id;
		var maths = Math.floor(Math.random()*3000)
		setTimeout("start_hidden("+ id +")",maths);
	}

	setTimeout("start_my_show_2()",4000);
}


function start_my_show_2(){
	//$("#image_ul").addClass('pink_li');
	$('#image_ul li').addClass('change');

	var ul = $('#image_ul li span');

	for(var i = 0;i<ul.length;i++){
		var id = ul[i].id;
		var maths = Math.floor(Math.random()*3000)
		setTimeout("start_hidden("+ id +")",maths);
	}


	setTimeout("show_i()",5000);
	setTimeout("show_love()",8000);
	setTimeout("show_you()",11000);


}



function show_end(){

}



function showo(){
	var asdasd = [0,1,2,3,4];
	show_word(asdasd,10)
}

function show_i(){
	var asdasd = [3,4,5,13,22,31,39,40,41];
	show_word(asdasd,0,54);
}

function show_love(){
	var asdasd = [55,56,60,61,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,91,92,93,94,95,96,97,101,102,103,104,105,111,112,113,121];
	show_word(asdasd,54,135);
}


function show_you(){
	var asdasd = [138,140,147,149,156,158,165,167,174,175,176];
	show_word(asdasd,135,189);

}


function show_word(words,s_start,length){
	var ul = $('#image_ul li span');
	var asdasd = words;
	var word_length = length;
	for(var i = s_start;i<word_length;i++){
		var id = ul[i].id;
		if ($.inArray(i,asdasd) == -1) {
			var maths = Math.floor(Math.random()*2000)
			setTimeout("hiden_pic("+ id +")",maths)
		}
	}

	/*if (ul.length < word_length) {
		for(var i = 0;i < (word_length - ul.length);i++){
			$('#image_ul').append('<li><span></span></li>');
		}
	}*/


}


function start_hidden(id){
	$('#'+id ).animate({opacity: 'toggle'}, 500, 'linear', function() {
	  });
}

function hiden_pic(id){
	$('#'+id ).animate({opacity: 'toggle'}, 500, 'linear', function() {
		$('#image_ul').append('<li class="change">' + $('#'+id).parent("li").html() + '</li>');
		$('#'+id).parent("li").html('<span></span>');
		 show_pic(id);
	  });
}

function show_pic(id){
	$('#'+id ).animate({opacity: 'toggle'}, 500, 'linear', function() {
	  });
}


/*$("#dreamslistul img[title]").tooltip({
   // tweak the position
	offset: [10, 2],
   // use the "slide" effect
	effect: 'slide',
	position: 'top center',
	tipClass: 'toptooltip'
// add dynamic plugin with optional configuration for bottom edge
	});*/



function closed_big_pic(){
	$('#show_big_pic').hide('fast');
	$('#show_big_pic').html('');
}

function asdasd(obj){
	if ($('#show_big_pic').css('display') != 'none') {
		$('#show_big_pic').hide();
		$('#show_big_pic').html('');
	}

	var id=obj.id
	var top = $('#'+id).parent("li").offset().top;
	var left = $('#'+id).parent("li").offset().left;
	var ref =  $('#'+id).attr('ref');
	var strArray=new   Array();
	strArray = ref.split( ".");
	if (strArray[1] == 'gif') {
		$('#show_big_pic').html('<img style="max-height:350px;max-width:350px" src="/uploads/'+ $('#'+id).attr('ref') +'" />');
	} else {
		$('#show_big_pic').html('<img style="max-height:350px;max-width:350px" src="/uploads/_middle/'+ $('#'+id).attr('ref') +'" />');
	}



	$('#show_big_pic').css({top:top,left:left});
	$('#show_big_pic').show('fast');
}


function asdasd2(obj){
	if ($('#show_big_pic').css('display') != 'none') {
		$('#show_big_pic').hide();
		$('#show_big_pic').html('');
	}

	var id=obj.id
	var top = $('#'+id).offset().top;
	var left = $('#'+id).offset().left;
	$('#show_big_pic').html('<span>'+ $('#'+id).attr('ref') + '</span>');

	$('#show_big_pic').css({top:top,left:left});
	$('#show_big_pic').show('fast');
}




function plan_add(){
	var content = $('#new_content').val();
	var images = '';
	if ($('#picid').val() != undefined) {
		images = $('#picid').val();
	}

	$.post('/planlist/add_plan',
			{planist : PLANLIST_ID, content : content, images : images},function(data) {
				json = $.parseJSON(data);
				if(json.result == 1) {
					var html = '';
					if (json.msg.images) {
						html += '<li><span style="display:none" onclick="asdasd(this);" id="'+ json.msg.plan_id +'" ref="'+ json.msg.images +'" class="img_content"><img class="pretend_image_link" src="/uploads/_thumbs/'+ json.msg.images +'" /></span></li>';
					} else {
						html += '<li><span style="display:none" onclick="asdasd(this);" id="'+ json.msg.plan_id +'" ref="'+ json.msg.content +'" class="img_content">'+ json.msg.content +'</span></li>';
					}

					$('#image_ul').append(html);
					hiddenTooltipContainer();
					$('#add_new_plan_div').animate({height: ['toggle', 'swing'],opacity: 'toggle'}, 500, 'linear', function() {
						$('#new_content').val('');
						$("#"+json.msg.plan_id).animate({opacity: 'toggle'}, 500, 'linear');
						$('#totalpic').html(parseInt($('#totalpic').html()) + 1);
					  });
				}
		});
}



$(document).ready(function(){
	if ($('#image_ul li span').length > 70) {
		setTimeout("start_my_show_1()",10000);
	}

	/********************************************************************************/
});


</script>