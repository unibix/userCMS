<tr class="children_<?php echo $parent_id; ?>">
	<td colspan="5" style="padding: 0;">
		<div id="children_<?php echo $parent_id; ?>" style="display: none;">
		<table>
		<?php foreach($pages_list as $page) { ?>
			<tr class="row_<?php echo $page['id']; ?> child">
				<td class="page_name">
					<?php if($page['children_count']) { ?>
					<span class="parent-page" parent_id="<?php echo $page['id']; ?>">
					</span>
					<?php } ?>
          <?php echo $page['name']; ?>
				</td>
				<td><a href="<?php echo SITE_URL . $page['full_url']; ?>" target="_blank"><?php echo $page['url']; ?></a></td>
				<td class="td_140"><?php echo date('d.m.Y H:i', $page['date_add']); ?></td>
				<td class="actions td_190">
					<a href="<?php echo SITE_URL;?>/admin/pages/edit/<?php echo $page['id'] ?>" >Изменить</a>
					<a href="<?php echo SITE_URL;?>/admin/pages/delete/<?php echo $page['id'] ?>" >Удалить</a>
				</td>
			</tr>
		<?php } ?>
		</table>
		</div>
	</td>
</tr>