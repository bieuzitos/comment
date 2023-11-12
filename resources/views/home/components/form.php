<div class="comment">
    <form data-function="create">
        <div class="textarea">
            <textarea name="message" type="text" placeholder=" "></textarea>
            <label>Adicionar um comentário público...</label>
            <div class="icon top">
                <i class="fa-solid fa-comment"></i>
            </div>
            <div class="icon down"><?= COMMENT_MAX; ?></div>
        </div>

        <div class="comment-footer">
            <div class="comment-avatar">
                <img src="<?= getAccountAvatar(); ?>" />
            </div>

            <div class="comment-action">
                <div class="comment-button cancel hidden">
                    <button>Cancelar</button>
                </div>

                <div class="comment-button submit disabled">
                    <button class="disabled" disabled>Comentar</button>
                </div>
            </div>
        </div>
    </form>
</div>