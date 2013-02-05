
	//用户操作面板悬浮窗
	$(".planlist_main tr").live('mouseover', show_edit_list_toolbar);
	//$(".planlist_main tr").live('mouseout', function(){$("#edit_list_toolbar").hide();});
	
	
	$("#wrapper").mouseout(function(){
		if ($('#edit_list_toolbar').css('display') == 'block') {
			return false;
		}
		$('.plan_list_table tr').removeClass('onhover');
	});
	
	
	$(".list_icon .drop_icon a").live('click', show_gropanel);
	
	$(".list_info").dblclick(edit_content);
	
	$("#main-title").dblclick(edit_content);
	
	
	function edit_content() {
		var planid = $(this).parent().attr('planid');
		if (planid == undefined) {
			return false;
		}
		if ($('a',this).length > 0) {
			var content = $.trim($('a',this).html());
		} else {
			var content = $.trim($(this).html());
		}
		
		var html = '<div class="iteminbox"><input type="text" id="plan_editer" class="pb-input-text" value="'+ content +'"></div><div class="iteminbox" id="error_content_msg"></div>';
		art.dialog({
		    title: '修改计划',content:html,ok:function(){edit_plan_content_submit(planid);return false},cancel:true,lock:true,id:'edit_plan_content'
		});
		//$(this).html('<input type="text" value="' + content + '" class="pb-input-text"> <input type="button" value="修改" class="g_button" onclick="plan_add()">');
		return false;
	}
	
	
	function edit_plan_content_submit(planid) {
		$('#error_content_msg').html('');
		var content = $('#plan_editer').val();
		$.ajax({type:'POST',url:'/planlist/edit_content',data:{'plan_id':planid,'content':content},
  			success:function(data){
  				var json = $.parseJSON(data);
  				if(json.result == 1) {
  					art.dialog({id:'edit_plan_content'}).close();
  					if (json.msg.content == undefined) {
  						return false;
  					}
  					
  					if (PLANLIST_ID == planid) {
  						$('#main-title').animate({opacity: 0}, 500, 'linear', function() {
  							$('#main-title').html(json.msg.content);
  							$('#main-title').animate({opacity: 1}, 500, 'linear', function() {$.jGrowl("标题更改。"); });
  						  });
  						return false;
  					}
  					
  					
  					var obj = $(".plan_list_table[planid='"+planid+"']");
  					
					obj.animate({opacity: 0}, 500, 'linear', function() {
						if ($('.list_info a',obj).length > 0) {
							$('.list_info a',obj).html(json.msg.content);
						} else {
							$('.list_info',obj).html(json.msg.content);
						}
						
						obj.animate({opacity: 1}, 500, 'linear', function() {$.jGrowl("计划更改。"); });
					  });
  				} else {
  					$('#error_content_msg').html(json.msg);
  				}
  			},
  			error: function(XMLHttpRequest, textStatus, errorThrown){

  			}
  		});
	}
	
	
	function show_gropanel(){
		var html = '';
		var obj = $(this).parent().parent();
		if ($('a .img_checked',obj).length > 0) {
			html = '<a href="#" class="bg_blue" onclick="plan_edit(\'unchecked\');return false;">未完成</a>';
		} else if ($('a .uncheck_icon',obj).length > 0 || $('.progressbar',obj).length > 0) {
			html += '<a href="#" class="bg_blue" onclick="plan_edit(\'checked\');return false;">完成</a>';
		}
		
		html += '<a href="#" class="bg_blue" onclick="create_kid();return false;">创建</a>';
		html += '<a href="#" class="bg_blue" onclick="plan_edit(\'fail\');return false;">放弃</a>';
		html += '<a href="#" class="bg_blue" onclick="plan_edit(\'private\');return false;">私密</a>';
		html += '<a href="#" class="bg_blue" onclick="plan_edit(\'delete\');return false;">删除</a>';
		$('#dropanel2').html(html);
		var left = $(this).offset().left;
		var top = $(this).offset().top;
		$("#edit_list_toolbar").css({
			display : "block",
			left : left - 40 ,
			top : top 
		});
		
		$('#dropanel2').show();
	}
	
	
	function show_edit_list_toolbar(){
		var planid = $(this).attr('planid');
		if (planid != undefined) {
			if (planid != THE_SELECT_ID) {
				$('#edit_list_toolbar').hide();
			}
			THE_SELECT_ID = planid;
		}
		
		$('.plan_list_table tr').removeClass('onhover');
		$(this).addClass('onhover');
		


	}
        function createUploader(){
            var uploader = new qq.FileUploader({
                element: document.getElementById('file-uploader-demo1'),
                allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
                action: '/planlist/ajax_upload',
                debug: true,
                onSubmit: function(id, fileName){
					$('.qq-upload-button').css('display','none');
					$('#upload_info_text').css('display','none');
                },
                onComplete: function(id, fileName, responseJSON){
                   	$('#upload_image')[0].innerHTML='<img src="'+Plan.Url.Site+'/uploads/_thumbs/'+responseJSON['filename']+'" /><input type="hidden" id="picid" value="'+responseJSON['filename']+'">';
                	if ($('#new_content').val() == '') {
                		$('#new_content').val(responseJSON['imagename']);
                	}
                   	uploadComplete();
                },
            });
        }

      	function uploadComplete(){
      	//	$('.qq-upload-list')[0].innerHTML = '';
        }


		function plan_edit(action){
			if (THE_SELECT_ID == undefined || !THE_SELECT_ID) {
				return false;
			}

			var data_obj = '';
      		$.ajax({type:'POST',url:'/planlist/edit_plan',data:{'action':action,'plan_id':THE_SELECT_ID,'content':data_obj},
      			success:function(json){
      				var obj = $(".plan_list_table[planid='"+THE_SELECT_ID+"']");
      				$('.progressbar', obj).hide();
					if (action == 'checked') {
						$('.status_ischecked', obj).html('<a href="#" onclick="plan_edit(\'unchecked\');return false;"><span class="check_icon img_checked" title="完成"></span></a>');
						$.jGrowl("计划完成。");  
					} else if (action == 'unchecked') {
						$('.status_ischecked', obj).html('<a href="#" onclick="plan_edit(\'checked\');return false;"><span class="uncheck_icon"></span></a>');
						$('.progressbar', obj).show();
						$.jGrowl("计划未完成。");
					} else if (action == 'fail') {
						$('.status_ischecked', obj).html('<a href="#" onclick="plan_edit(\'unchecked\');return false;"><span class="fail_icon" title="放弃"></span></a>');
						$.jGrowl("计划失败。");
					} else if (action == 'private') {
						$('.status_isprivate', obj).html('<a href="#" ><span class="lock_icon" title="密"></span></a>');
						$.jGrowl("设为隐私。"); 
						$('.progressbar', obj).show();
					} else if (action == 'delete') {
						obj.animate({opacity: 0,height:0}, 500, 'linear', function() {
							$('#edit_list_toolbar').hide();
							obj.remove();
							$.jGrowl("删除计划。"); 
						  });
					}

					$('#edit_list_toolbar').hide();

      			},
      			error: function(XMLHttpRequest, textStatus, errorThrown){

      			}
      		});

		}


		function create_kid(){
			if (THE_SELECT_ID == undefined || !THE_SELECT_ID) {
				return false;
			}

			location.href = '/u/'+ Plan.uid +'/' + THE_SELECT_ID + '/?edit';
		}






      	function show_toolbar(id){
      		$("#edit_list_toolbar_"+id).css("display","block");
      	}
      	function hidden_toolbar(id){
      		$('#edit_list_toolbar_'+id).css("display","none");
      	}




		function add_plan(){
			var content= $('#new_content').val();
			var sort = $('.planlist_main .plan_list_table').length ;
      		$.ajax({type:'POST',url:'/planlist/add_plan',data:{'content':content,'plan_id':THE_SELECT_ID,'sort':sort},
      			success:function(json){
      				var obj = $(".planlist_main tr[planid='"+THE_SELECT_ID+"']");

					if (action == 'checked') {
						$('.list_icon', obj).html('<img width="20px" alt="已完成" title="已完成" class="img_checked" src="/images/Check-icon.png" />');
					} else if (action == 'unchecked') {
						$('.img_checked', obj).remove();
					}

					show_edit_list_toolbar();
      			},
      			error: function(XMLHttpRequest, textStatus, errorThrown){

      			}
      		});

		}



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

function show_add_plan_div() {
	$('#add_new_plan_div').show();
}