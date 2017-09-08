<div class="wrap">
    
<h3 class="title"><?php _e('OptimizePress Serialize Fix', 'op-serialize-fix'); ?></h3>
    <p class="install-help"><?php _e('Fixes corrupt OptimizePress settings that happen in rare cases after migrating OP site.<br><strong>IMPORTANT: Backup your database before doing this !!!</strong>', 'op-serialize-fix'); ?></p>
    <form method="POST">
        <input type="hidden" name="opfix" value="" />
        <?php wp_nonce_field('op_fix', 'op_fix_nonce', true, true); ?>
        <input type="submit" name="submit" value="Fix serialized settings" />
    </form>
    <?php if (isset($_POST['opfix'])) : ?>
        <p class="install-help">
            Serialized fields are now fixed.
        </p>
    <?php endif; ?>
</div>