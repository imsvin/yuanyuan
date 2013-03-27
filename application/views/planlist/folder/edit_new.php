<style>
.planlist_main .list_info {
	width: 420px;
}
.planlist_main .list_icon{
	width: 110px;
}


.list_icon_icon{
	padding-right: 25px;
}
.planlist_main .list_icon span{
	float:right;
	width:20px;

}
.drop_icon{float:right;margin-top:7px}
.placeHolder{ background-color:white !important; border:dashed 1px gray !important; }

</style>

<div class="planlist_main edit">

<?php foreach ($plans as $key=> $plan ):?>
<div class="plan_list_table" planid="<?php echo $plan['plan_id'] ?>">
<table>
	<tr planid="<?php echo $plan['plan_id'] ?>">
		<td class="list_count"><?php echo ($key+1);?>,</td>
		<td class="list_info">
			<?php if ($plan['total']) :?>
			<a class="bg_blue" href="/<?php echo $userinfo['uid']?>/<?php echo $plan['plan_id'];?>"><?php echo $plan['content']?></a>
			<?php else:?>
			<?php echo $plan['content']?>
			<?php endif;?>
		</td>
		<td class="list_icon">
			<div class="drop_icon"><a href="#" onclick="return false;"><span class="dropdownlist_icon"></span></a></div>

			<div class="list_icon_icon">
				<span class="status_isprivate">
				<?php if ($plan['isprivate'] == 1): ?>
				<a href="#" onclick="return false;"><span class="lock_icon" title="密"></span></a>
				<?php endif;?>
				</span>

				<span class="status_ischecked">
				<?php if ($plan['ischecked'] == 1): ?>
					<a href="#" onclick="plan_edit('unchecked');return false;"><span class="check_icon img_checked" title="完成"></span></a>
				<?php elseif ($plan['ischecked'] == -1): ?>
					<a href="#" onclick="plan_edit('unchecked');return false;"><span class="fail_icon" title="放弃"></span></a>
				<?php elseif ($plan['total'] > 0 ):?>
					<span class="progressbar">
						<strong class="bar" style="width: <?php echo $plan['complete']/$plan['total']*100;?>%;" title="<?php echo $plan['complete']?>/<?php echo $plan['total']?>"></strong>
					</span>
				<?php else:?>
					<a href="#" onclick="plan_edit('checked');return false;"><span class="uncheck_icon"></span></a>
				<?php endif;?>
				</span>
			</div>
		</td>
	</tr>
	</table>
</div>
<?php endforeach;?>


<div class="edit_toolbar" id="edit_list_toolbar" style="display:none;position: absolute;">
	<div class="sitenav">
    <ul>
     <li class="dropdownlist">
         <div class="panel dropanel2" id="dropanel2">
         </div>
     </li>
    </ul>
   </div>
</div>

</div>

	<div id="add_new_plan_div">
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
	<div class="clear"></div>
	<input name="list1SortOrder" type="hidden" />


	 <?php if ($userinfo['uid'] == $this->uid) :?>
	<div style="text-align: center;margin-top:30px"><a href="#" onclick="show_add_plan_div();return false">添加一行</a></div>
    <script src="/js/fileuploader.js" type="text/javascript"></script>
    <script src="/js/jquery.dragsort-0.5.1.js?v=<?php echo time()?>" type="text/javascript"></script>
     <script src="/js/editlist.js?v=<?php echo time()?>" type="text/javascript"></script>

     <script>

$(".planlist_main").dragsort({ dragSelector: ".plan_list_table", dragBetween: true, dragEnd: saveOrder, placeHolderTemplate: '<div class="plan_list_table placeHolder"></div>' });

function saveOrder() {
	var plan_id = $(this).attr('planid');
	var i = 0;

	var data = $(".planlist_main .plan_list_table").map(function() {i++;  if ($(this).attr('planid') == plan_id) {return i; } }).get();
	$("input[name=list1SortOrder]").val(data.join("|"));
	var order = data.join("|");
	$.post('/planlist/change_sort',
			{planlist_id : PLANLIST_ID, plan_id : plan_id, order : order},function(data) {
				json = $.parseJSON(data);
				if(json.result == 1) {
				} else {
					art.dialog({title: '提示',content:json.msg});
				}
		});

};


function plan_add(){
	var content = $('#new_content').val();
	var images = '';
	if ($('#picid').val() != undefined) {
		images = $('#picid').val();
	}
	$.post('/planlist/add_plan',
			{planlist : PLANLIST_ID, content : content, images : images},function(data) {
				json = $.parseJSON(data);
				if(json.result == 1) {
					var html = writer_a_plan(json.msg);
					$('.planlist_main').append(html);
					$('#add_new_plan_div').animate({height: ['toggle', 'swing'],opacity: 'toggle'}, 500, 'linear', function() {
						$('#new_content').val('');
						hiddenTooltipContainer();
						$(".plan_list_table[planid='"+json.msg.plan_id+"']").animate({height: ['toggle'],opacity: 'toggle'}, 500, 'linear');
					  });
				} else {

				}
		});
}

function writer_a_plan(data){
	var list_count = $('.planlist_main table tr');
	var html = '<div class="plan_list_table" planid="'+ data.plan_id  +'" style="display:none"> <table><tr planid="'+ data.plan_id  +'" >';
		html += '<td class="list_count">'  + (list_count.length + 1) + ',</td>';
		html += '<td class="list_info">';
		html += data.content  +'</td>';
		html += '<td class="list_icon">';
		html += '</td></tr></table></div>';
		return html;
}
</script>
	<?php endif;?>



