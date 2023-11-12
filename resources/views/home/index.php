<?php $this->layout('_theme', ['seo' => $seo]); ?>

<?php $this->push('libraries_css'); ?>
    <?= (new \Source\Support\Csrf())->insertMetaToken(); ?>

    <script>
        const attributes = {
            comment: {
                max: <?= COMMENT_MAX; ?>,
                api: {
                    create: '<?= $router->route('comment.create'); ?>',
                    delete: '<?= $router->route('comment.delete'); ?>',
                    update: '<?= $router->route('comment.update'); ?>',
                }
            },
            account: {
                username: '<?= getAccountUsername(); ?>',
                avatar: '<?= getAccountAvatar(); ?>',
            }
        }
    </script>
<?php $this->end(); ?>

<?php $this->push('styles_css'); ?>
<link rel="stylesheet" href="<?= $this->asset('/assets/css/styles/comment.min.css'); ?>" />
<?php $this->end(); ?>

<div class="container">
    <?php $this->insert('home/components/form'); ?>
    <?php $this->insert('home/components/message', ['comments' => $comments, 'comments_count' => $comments_count]); ?>
    <?php $this->insert('home/components/modal'); ?>
</div>

<?php $this->push('libraries_js'); ?>
    <script src="<?= $this->asset('/assets/js/libraries/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= $this->asset('/assets/js/libraries/jquery.validate.min.js'); ?>"></script>
<?php $this->end(); ?>

<?php $this->push('scripts_js'); ?>
    <script src="<?= $this->asset('/assets/js/scripts/notification.min.js'); ?>"></script>

    <?php $this->insert('home/scripts/create'); ?>
    <?php $this->insert('home/scripts/delete'); ?>
    <?php $this->insert('home/scripts/update'); ?>
    <?php $this->insert('home/scripts/validation'); ?>
<?php $this->end(); ?>