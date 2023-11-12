<?php use Carbon\Carbon; ?>

<div class="message">
    <div class="message-header">
        <div class="message-title">
            <span class="count"><?php echo number_format($comments_count, 0, ',', '.'); ?></span>
            <span class="text"><?= ($comments_count === 1 ? 'Comentário' : 'Comentários'); ?></span>
        </div>

        <div class="message-action">
            <button>
                <i class="fa-solid fa-sort"></i>
                <span>Ordernar por</span>
            </button>

            <div class="dropdown" style="display: none;">
                <div class="dropdown-content list">
                    <div class="dropdown-middle">
                        <button>
                            <div class="icon">
                                <i class="fa-solid fa-arrow-up-wide-short"></i>
                            </div>
                            <span>Principais comentários</span>
                        </button>
                        <button>
                            <div class="icon">
                                <i class="fa-solid fa-arrow-up-9-1"></i>
                            </div>
                            <span>Mais recentes primeiro</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="message-content animated">
        <?php if ($comments) : ?>
            <?php foreach ($comments as $comment) : ?>
                <div id="message-<?= $comment->id; ?>" class="message-box" data-message="<?= $comment->id; ?>">
                    <div class="box-user">
                        <div class="box-avatar">
                            <img src="<?= getAccountAvatar($comment->username); ?>" />
                        </div>
                    </div>

                    <div class="box-content">
                        <div class="box-header">
                            <div class="box-info">
                                <span class="box-name"><?= $comment->username; ?></span>
                                <div class="box-date">
                                    <i class="fa-regular fa-calendar-check"></i>
                                    <?php $date = ($comment->updated_at ? $comment->updated_at : $comment->created_at); ?>
                                    <span data-updated="<?= $date; ?>"><?= Carbon::parse($date)->locale('pt_BR')->diffForHumans(['syntax' => Carbon::DIFF_RELATIVE_TO_NOW]); ?></span>
                                    <?= ($comment->updated_at ? '<span>(Editado)</span>' : ''); ?>
                                </div>
                            </div>

                            <div class="box-button">
                                <button>
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>

                                <div class="dropdown" style="display: none;">
                                    <div class="dropdown-content">
                                        <div class="dropdown-middle">
                                            <?php if (session()->USER_ACCOUNT === $comment->account_id) : ?>
                                                <button data-action="update">
                                                    <div class="icon">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </div>
                                                    <span>Editar</span>
                                                </button>
                                                <button data-action="delete">
                                                    <div class="icon">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </div>
                                                    <span>Apagar</span>
                                                </button>
                                            <?php else : ?>
                                                <button data-action="report">
                                                    <div class="icon">
                                                        <i class="fa-solid fa-flag"></i>
                                                    </div>
                                                    <span>Denunciar</span>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-body">
                            <span><?= $comment->message; ?></span>
                        </div>

                        <div class="box-footer">
                            <div class="box-button">
                                <button>
                                    <i class="fa-regular fa-heart"></i>
                                </button>
                            </div>
                            <div class="box-button">
                                <button>
                                    <i class="fa-solid fa-reply"></i>
                                    <span>Responder</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="<?= ($comments ? 'message-empty hidden' : 'message-empty'); ?>">
            <div class="icon">
                <i class="fa-solid fa-comment"></i>
            </div>
            <span class="text">Não há comentários no momento!</span>
        </div>
    </div>
</div>