<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>
<div id="error-msg" class="p-2 box">
    <div id="content">
        <h1>Opps! File no found.</h1>
        <p>Sorry, your requested post is not found.</p>
        <p>You can click the 'back' button on your browser and try to navigate other post through our site, or click the following link to go to homepage.</p>
        <p class="text-center p-2">
            <a href="<?php $this->options->siteUrl(); ?>"><?php _e("回到首页") ?></a>
        </p>
    </div>
</div>
<style></style>
</style>
<?php $this->need('footer.php'); ?>