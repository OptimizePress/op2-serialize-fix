<div style="border-bottom: 1px solid #dfdfdf; height: 10px;"></div>
<h3 class="title"><?php _e('Content layout settings & fields', Op_Tools::slug()); ?></h3>
<form method="POST">
	<?php foreach ($fields as $field) : ?>
	<p>
		<label><?php echo $field['name']; ?></label>
		<?php if ($field['type'] === 'textarea') : ?>
		<textarea rows="10" cols="50" class="large-text code" name="<?php echo $field['name']; ?>"><?php var_export($field['value']); ?></textarea>
		<?php else : ?>
		<input class="large-text" name="<?php echo $field['name']; ?>" value="<?php echo($field['value']); ?>" />
		<?php endif; ?>
	</p>
	<?php endforeach; ?>
	<input type="hidden" name="layout" value="<?php echo $layout; ?>" />
	<?php wp_nonce_field('content_layout_edit', 'cle_wpnonce', $referer = true, $echo = true); ?>
	<p class="submit"><input type="submit" name="layout_save" id="submit" class="button button-primary" value="<?php _e('Save Layout', Op_Tools::slug()); ?>"></p>
</form>