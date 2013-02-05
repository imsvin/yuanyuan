<?php  /* ?>
<ul id="dreamslistul">
<?php

	foreach ($plans as $key=> $plan ) {


		echo '<li class="show_li list_title">';
		echo '<table><tr>
		<td class="list_count">'.($key+1).',</td>
		<td class="list_info">';
		if ($plan->has_child) {
			echo '<a href="/u/'.$userinfo['username'].'/'.$plan->planlist_id.'">'.$plan->content.'</a>';
		} else {
			echo $plan['content'];
		}
		//echo ($dream->image_id?'<img rel="#dream_pic'.$dream->image_id.'" src="'.Yii::app()->theme->baseUrl.'/images/pic_btn_icon.png" class="dream_img_icon"  /><div class="tooltip4imgs"><img rel="#dream_pic'.$dream->image_id.'" src="'.Yii::app()->request->hostInfo.'/uploads/_thumbs/'.$dream->images->filename.'" /></div>':'');
		echo '</td>';
		echo '<td style="vertical-align:top;">'.($plan['ischecked']==1 ? '<img width="20px" alt="已完成" title="已完成" src="'.Yii::app()->theme->baseUrl.'/images/Check-icon.png">':'' );
		if ($plan->kid['total']>0 && $plan['ischecked']!=1) {
			echo '<div class="progressbar" style="float:left">
			<strong class="bar" style="width: '.($dream->kid['complete']/$dream->kid['total']*100).'%;" title="'.$dream->kid['complete'].'/'.$dream->kid['total'].'"></strong>
			</div>';
		}

		echo '</td>
		</tr>';
	//	echo '<tr><td></td><td><img class="imgicon" dynamic-src="http://ww4.sinaimg.cn/thumbnail/620668e0jw6dfecg8iccaj.jpg" vimg="1" src="http://ww4.sinaimg.cn/thumbnail/620668e0jw6dfecg8iccaj.jpg"></td></tr>';
		echo '</table>';

		echo '</li>';
	}
?>
</ul>
*/  ?>

<div class="planlist_main">
<table>
<?php foreach ($plans as $key=> $plan ):?>
	<tr>
		<td class="list_count"><?php echo ($key+1);?>,</td>
		<td class="list_info" <?php if ($plan['ischecked'] == -1): ?> style="text-decoration: line-through;color: #666;"<?php endif;?>>
			<?php
			if ($plan['isprivate'] == 1 && $plan['uid'] != Yii::app()->user->id) {
				$plan['content'] = '<span title="密">* * * * * * * * * * * * * *</span>';
			}


			?>


			<?php if ($plan['total']) :?>
			<a href="/u/<?php echo $userinfo['username']?>/<?php echo $plan['plan_id'];?>"><?php echo $plan['content']?></a>
			<?php else:?>
			<?php echo $plan['content']?>
			<?php endif;?>
		</td>
		<td class="list_icon">
			<span>
			<span class="status_ischecked">
			<?php if ($plan['ischecked'] == 1): ?>
				<img alt="已完成" title="已完成" src="/images/Check-icon.png" />
			<?php elseif ($plan['ischecked'] == -1): ?>
				<img alt="放弃" title="放弃" src="/images/fail-icon.png" />
			<?php endif;?>
			</span>
			<span class="status_isprivate">
			<?php if ($plan['isprivate'] == 1): ?>
			<img alt="密" title="密" src="/images/Lock-icon.png" />
			<?php endif;?>
			</span>

			<?php if ($plan['total']>0): ?>
				<div class="progressbar" title="<?php echo $plan['complete']?>/<?php echo $plan['total']?>">
				<strong class="bar" style="width: <?php echo $plan['complete']/$plan['total']*100;?>%;"></strong>
				</div>
			<?php endif;?>
			</span>
		</td>
	</tr>
<?php endforeach;?>
</table>
</div>