<script>
    const modal_delete = '#CommentDelete_modal'

    const button_delete_submit_1 = '#CommentDelete_modal .modal-button:not(.transparent)'
    const button_delete_submit_2 = '#CommentDelete_modal .modal-button:not(.transparent) button'

    $(document).on('click', '.dropdown button[data-action="delete"]', function(event) {
        event.preventDefault()

        $(modal_delete).modal('show')
        $(button_delete_submit_2).data('comment', $(this).closest('.message-box').data('message'))
    })

    $(button_delete_submit_2).on('click', function(event) {
        event.preventDefault()

        const comment = $(this).data('comment')

        $.ajax({
            url: attributes.comment.api.delete,
            type: 'POST',
            data: getToken() + 'comment=' + encodeURIComponent(comment),
            dataType: 'JSON',
            beforeSend: function() {
                submitButton('start', button_delete_submit_1, button_delete_submit_2)
            },
            success: function(action) {
                submitButton('active', button_delete_submit_1, button_delete_submit_2)

                if (action.status) {
                    $.showNotification({
                        type: 'success',
                        message: action.status_message
                    })

                    addToken(action.token)
                    removeMessage(comment)
                    return
                }

                $.showNotification({
                    type: action.status_type,
                    message: action.status_message
                })
            },
            error: function() {
                submitButton('active', button_delete_submit_1, button_delete_submit_2)

                $.showNotification({
                    type: 'error',
                    message: 'Não foi possível processar a sua solicitação!'
                })
            },
            complete: function() {
                $(modal_delete).modal('hide')
            }
        })
    })

    function removeMessage(comment) {
        const count = parseInt($('.message .message-header .count').text())

        let newCount = count - 1

        $('.message .message-header .count').text(newCount)
        $('.message .message-header .text').text((newCount === 1) ? 'Comentário' : 'Comentários')

        $('#message-' + comment).remove()

        if (newCount <= 0) {
            $('.message-content .message-empty').removeClass('hidden')
        }

        updateDate()
    }
</script>