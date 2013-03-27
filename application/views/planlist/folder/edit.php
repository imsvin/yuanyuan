

<ul id="dreamslistul">
<?php
foreach ($plans as $key=> $dream ) {

	echo '<li class="show_li list_title" onmouseover="show_toolbar('.$dream['plan_id'].');" onmouseout="hidden_toolbar('.$dream['plan_id'].');" >';
	echo '<table>';
	echo '<tr>';
	echo '<td class="list_count" width="5%">'.($key+1).',</td><td class="list_info" width="65%">'.$dream['content'].($dream['image_id']?'<img style="margin-left:5px" src="/images/pic_btn_icon.png" class="small_icon picnormal"  />':'').' </td>';
	echo '<td style="vertical-align:top;" width="5%"><span id="checkedimg_'.$dream['plan_id'].'" style="'.($dream['ischecked']==1?'':'display:none').'"><img width="18px" alt="已完成" title="已完成" src="/images/Check-icon.png"></span></td>';
	echo '<td width="20%"><div class="edit_toolbar" id="edit_list_toolbar_'.$dream['plan_id'].'">';
	?>

	<div class="sitenav">
    <ul>
     <li>
     <?php echo '<a href="#" onclick="unchecked_dream('.$dream['plan_id'].');return false;" style="'.($dream['ischecked'] == 1?'':'display:none').'" id="unchecked_id_'.$dream['plan_id'].'">未完成</a>
		<a href="#" onclick="checked_dream('.$dream['plan_id'].');return false;" style="'.($dream['ischecked'] == 1?'display:none':'').'" id="checked_id_'.$dream['plan_id'].'">完成</a>';?>
     </li>
     <li>&nbsp;|&nbsp;</li>
     <li class="dropdownlist"><a href="#">More</a>
         <div class="panel dropanel2">
         	<?php echo '<a href="#" onclick="create_kid('.$dream['plan_id'].');return false;">创建</a>'; ?>
         	<?php echo '<a href="#" onclick="delete_dream('.$dream['plan_id'].');return false;">失败</a>'; ?>
         	<?php echo '<a href="#" onclick="delete_dream('.$dream['plan_id'].');return false;">放弃</a>'; ?>
         	<?php echo '<a href="#" onclick="delete_dream('.$dream['plan_id'].');return false;">隐藏</a>'; ?>
         	<?php echo '<a href="#" onclick="delete_dream('.$dream['plan_id'].');return false;">删除</a>'; ?>
         </div>
     </li>
    </ul>
   </div>
	<?php
	echo '</div></td>';
	echo '</tr>';
	echo '</table>';
	echo '</li>';

}
		/*
					foreach ($mydreams as $key=> $dream ) {
				echo '<li id="dream_list_li_'.$dream->id.'" onmouseover="show_toolbar('.$dream->id.');" onmouseout="hidden_toolbar('.$dream->id.');">
						<div >
							<div class="list_count"><input type="text" name="sort_'.$dream->id.'" value="'.($key+1).'" class="texttext" size="2"/>,</div>
							<div class="list_info">
								<input type="text" name="dream_'.$dream->id.'"  value="'.$dream->content.'"  class="texttext"/>
								<span id="checkedimg_'.$dream->id.'" style="'.($dream->ischecked==1?'':'display:none').'"><img width="18px" alt="已完成" title="已完成" src="'.Yii::app()->theme->baseUrl.'/images/Check-icon.png"></span>
								<div class="edit_toolbar" id="edit_list_toolbar_'.$dream->id.'">
								<a href="#" onclick="unchecked_dream('.$dream->id.');return false;" style="'.($dream->ischecked==1?'':'display:none').'" id="unchecked_id_'.$dream->id.'">未完成</a>
								<a href="#" onclick="checked_dream('.$dream->id.');return false;" style="'.($dream->ischecked==1?'display:none':'').'" id="checked_id_'.$dream->id.'">完成</a>&nbsp;|&nbsp;
								<a href="#" onclick="delete_dream('.$dream->id.');return false;">删除</a></div>
							</div>
						</div>
							</li>';
				echo '<li id="dream_list_li_'.$dream->id.'" onmouseover="show_toolbar('.$dream->id.');" onmouseout="hidden_toolbar('.$dream->id.');">
						<div>
							<div class="list_count">'.($key+1).',</div>
							<div class="list_info">
								'.$dream->content.'
								<span id="checkedimg_'.$dream->id.'" style="'.($dream->ischecked==1?'':'display:none').'"><img width="18px" alt="已完成" title="已完成" src="'.Yii::app()->theme->baseUrl.'/images/Check-icon.png"></span>
								<div class="edit_toolbar" id="edit_list_toolbar_'.$dream->id.'">
								<a href="#" onclick="unchecked_dream('.$dream->id.');return false;" style="'.($dream->ischecked==1?'':'display:none').'" id="unchecked_id_'.$dream->id.'">未完成</a>
								<a href="#" onclick="checked_dream('.$dream->id.');return false;" style="'.($dream->ischecked==1?'display:none':'').'" id="checked_id_'.$dream->id.'">完成</a>&nbsp;|&nbsp;
								<a href="#" onclick="delete_dream('.$dream->id.');return false;">删除</a></div>
							</div>
						</div>
							</li>';
					}*/
?>
</ul>
    		<div class="clear"></div>
			<div style="text-align: center;margin-top:30px"><a href="#" onclick="show_add_plan_div();return false">添加一行</a></div>

    <script src="/js/fileuploader.js" type="text/javascript"></script>

    <script>






    var PLANLIST_ID = <?php echo $listinfo->plan_id;?>;
        function createUploader(){
            var uploader = new qq.FileUploader({
                element: document.getElementById('file-uploader-demo1'),
                allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
                action: Plan.Url.Site+'/dreamlist/ajax_upload',
                debug: true,
                onSubmit: function(id, fileName){
					$('.qq-upload-button').css('display','none');
					$('#upload_info_text').css('display','none');
                },
                onComplete: function(id, fileName, responseJSON){
                   	$('#upload_image')[0].innerHTML='<img src="'+Plan.Url.Site+'/uploads/_thumbs/'+responseJSON['filename']+'" /><input type="hidden" id="picid" value="'+responseJSON['image_id']+'">';
                	uploadComplete();

                },
            });
        }

      	function uploadComplete(){
      	//	$('.qq-upload-list')[0].innerHTML = '';
        }


      	function show_toolbar(id){
      		$("#edit_list_toolbar_"+id).css("display","block");
      	}
      	function hidden_toolbar(id){
      		$('#edit_list_toolbar_'+id).css("display","none");
      	}
      	function delete_dream(id){
      		if(!id || id==''){
      			return false;
      		}
      		ajaxUpdateValue('delete',id);
      		$('#checkedimg_'+id).remove();
      		$('#edit_list_toolbar_'+id).remove();
      		$('#dream_list_li_'+id).hide('slow',function () { });
      	}
      	function hidden_dream(id){
      		if(!id || id==''){
      			return false;
      		}
      		ajaxUpdateValue('hidden',id);
      	}
      	function checked_dream(id){
      		if(!id || id==''){
      			return false;
      		}
      		$('#checkedimg_'+id).css("display","");
      		ajaxUpdateValue('checked',id);
      		$('#checked_id_'+id).css("display","none");
      		$('#unchecked_id_'+id).css("display","");
      	}
      	function unchecked_dream(id){
      		if(!id || id==''){
      			return false;
      		}
      		$('#checkedimg_'+id).css("display","none");
      		ajaxUpdateValue('unchecked',id);
      		$('#checked_id_'+id).css("display","");
      		$('#unchecked_id_'+id).css("display","none");
      	}

      	function unchecked_dream(id){
      		if(!id || id==''){
      			return false;
      		}
      		ajaxUpdateValue('unchecked',id);
      	}

      	function ajaxUpdateValue(type,value,obj,addli_id){
      		if(!type || type == ''){
      			return false;
      		} else if (type == 'newplan') {
      			obj = {"content":obj['content'],"planlist_id":PLANLIST_ID};
      			//,"image_id":obj['image_id']
      		}
      		$.post(Plan.Url.Site+'/planlist/ajax_edittitle/',{'type':type,'id':value,'content':obj},function(data) {
      			if(type == 'newdream'){
      				var redata = JSON.parse(data);
      				writer_dream_html(redata,addli_id);
      			} else if (type == 'create_a_kid') {
      					var redata = JSON.parse(data);
      					if (redata['code']=='1') {
      						window.location.href=Plan.Url.Site+'/u/<?php echo $userinfo['username'];?>/'+redata['msg']+'/?edit';
              			} else {
							alert('创建失败');
                  		}
          			}
      			});
      	}

      	function add_a_new(){
      		var dreamdata=new Array()
      	//	dreamdata['sort']= $('#sort_'+id)[0].value;
      		dreamdata['content']= $('#new_content').val();
      		//dreamdata['image_id']= $('#picid')[0] ? $('#picid')[0].value : '' ;
      		//dreamdata['list_id']= <?php  echo $listinfo['planlist_id'];?>;
      		ajaxUpdateValue('newplan','0',dreamdata);
      	}

      	function writer_dream_html(redata,id){
//      		var licontent = '<li id="newd'+id+'" style="display:none;"><div class="list_count"><input type="text" name="sort_'+(redate['id'])+'" value="'+(redata['sort'])+'" class="texttext" size="2"/>,</div>';
//      		licontent += '<div class="list_info"><input type="text" name="dream_'+(redate['id'])+'"  value="'+(redate['content'])+'"  class="texttext"/></div></li>';

      		var licontent = '<li style="display:none" class="show_li list_title" id="dream_list_li_'+redata['id']+'" onmouseover="show_toolbar('+redata['id']+');" onmouseout="hidden_toolbar('+redata['id']+');" >';
      		licontent += '<table>';
      		licontent += '<tr>';
      		licontent += '<td class="list_count" width="5%">'+redata['sort']+',</td><td class="list_info" width="70%">'+redata['content']+(redata['image_id'] ? '<img style="margin-left:5px" src="<?php echo Yii::app()->theme->baseUrl;?>/images/pic_btn_icon.png" class="small_icon picnormal" title="图片" />' : '' )+'</td>';
      		licontent += '<td style="vertical-align:top;" width="5%"><span id="checkedimg_'+(redata['id'])+'" style="display:none"><img width="18px" alt="已完成" title="已完成" src="<?php echo Yii::app()->theme->baseUrl;?>/images/Check-icon.png"></span></td>';
      		licontent += '<td width="20%"><div class="edit_toolbar" id="edit_list_toolbar_'+redata['id']+'">';
      		licontent += '<a href="#" onclick="unchecked_dream('+redata['id']+');return false;" style="display:none" id="unchecked_id_'+redata['id']+'">未完成</a>';
      		licontent += '<a href="#" onclick="checked_dream('+redata['id']+');return false;" style="" id="checked_id_'+redata['id']+'">完成</a>&nbsp;|&nbsp;';
      		licontent += '<a href="#" onclick="delete_dream('+redata['id']+');return false;">删除</a></div></td>';
      		licontent += '</tr>';
      		licontent += '</table>';
      		licontent += '</li>';
      		$('#dreamslistul').append(licontent);
      		$('#newdream_li_'+id).hide('slow',function () { $('#dream_list_li_'+redata['id']).show('slow');$('#newdream_li_'+id).remove(); });

      	}



      	$('#more_add_dreams').click(function(){
      		var countli = $('.list_count').length;
      		var licontent = '<li id="newdream_li_'+(countli+1)+'" class="show_li list_title"><div class="list_count"><input type="text" id="sort_'+(countli+1)+'" value="'+(countli+1)+'" class="newsort" size="2"/>,</div>';
      			licontent += '<div class="list_info"><input type="text" id="content_'+(countli+1)+'"  value=""  class="newcontent"/><input type="button" value="添加" class="g_button" id="newbtn_'+(countli+1)+'" onclick="add_a_new(\''+(countli+1)+'\')">';
      			licontent += '<br/><span class="publisher_image">';
      			licontent += '<div style="float:left;margin-left:10px">';
      			licontent += '<span onclick="showTooltipContainer();"><img src="'+Plan.Url.Site+'/images/pic_btn_icon.png" class="small_icon picnormal" title="图片" />图片</span>';
      			licontent += '<div class="TooltipContainer" id="TooltipContainer" style="display:none">';
      			licontent += '<div class="TooltipContent">';
      			licontent += '<div style="text-align:center;margin-top:30px" id="upload_img_toolbar">';
      			licontent += '<div id="file-uploader-demo1">';
      			licontent += '</div>';
      			licontent += '</div>';
      			licontent += '</div>';
      			licontent += '<Tooltip_s>';
      			licontent += '<Tooltip_i></Tooltip_i>';
      			licontent += '</Tooltip_s>';
      			licontent += '</div>';
      			licontent += '</div>';
      			licontent += '</span>';
      			licontent += '</div></li>';
      	    $('#dreamslistul').append(licontent);
      	})

      	function showTooltipContainer(){
      		createUploader();
      		$('#TooltipContainer').css('display','');
      	}
      	function hiddenTooltipContainer(){
      		$('#TooltipContainer').css('display','none');
      		$('#file-uploader-demo1').innerHTML='';
      	}


      	$('.texttext').live('focus',function(){
      		$(this).css("border","1px solid #000000");
      	})
      	$('.texttext').live('blur',function(){
      		$(this).css("border","1px solid #FFFFFF");
      		var str=this.name;
      		var arr=str.split("_");
      		if(this.value == ''){
      			return false;
      		}
      		ajaxUpdateValue(arr[0],arr[1],this.value);
      	})



    </script>


<script>
function create_kid(id){
	ajaxUpdateValue('create_a_kid',id);

	return false;
	$("#facebox").overlay({
		// custom top position
		top: 260,
		// some mask tweaks suitable for facebox-looking dialogs
		mask: {
			// you might also consider a "transparent" color for the mask
			color: '#fff',
			// load mask a little faster
			loadSpeed: 200,
			// very transparent
			opacity: 0.5
		},
		// disable this for modal dialog-type of overlays
		closeOnClick: false,
		// load it immediately after the construction
		load: true
	});

}


function show_add_plan_div() {
	$('#add_new_plan_div').show();
}
</script>
<!-- facebook dialog -->
<div id="facebox">

	<div>
		<h2>Facebox</h2>

		<p>
			This dialog is opened programmatically when the page loads. There is no need for a trigger element.
		</p>

		<form>
		<input type="file" />
		</form>

		<p style="color:#666">
			To close, click the Close button or hit the ESC key.
		</p>

		<!-- yes/no buttons -->
		<p>
			<button class="close"> Close </button>
		</p>
	</div>

</div>




<div id="add_new_plan_div">
	<table>
	<tr>
		<td class="list_count" width="20%"></td>
		<td class="list_info"><div class="list_info"><input type="text"  value="" id="new_content" class="newcontent"/><input type="button" value="添加" class="g_button" onclick="add_a_new()" ></td>
		<td style="vertical-align:top;">
		</td>
	</tr>
	</table>
	<span class="publisher_image">
      		<div style="float:left;margin-left:100px">
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



