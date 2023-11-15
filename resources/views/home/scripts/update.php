<script>
    const form_update = 'form[data-function="update"]'

    const button_update_submit_1 = 'form[data-function="update"] .comment-button.submit'
    const button_update_submit_2 = 'form[data-function="update"] .comment-button.submit button'

    const button_update_cancel_1 = 'form[data-function="update"] .comment-button.cancel'
    const button_update_cancel_2 = 'form[data-function="update"] .comment-button.cancel button'

    $(document).on('click', '.dropdown button[data-action="update"]', function(event) {
        event.preventDefault()

        const comment = $(this).closest('.message-box').data('message')
        const message = $('#message-' + comment + ' .box-body')

        formUpdateReset()

        const content = `<div id="comment-${comment}" class="comment">
            <form data-function="update">
                <input name="comment" value="${comment}" hidden />
                <div class="textarea">
                    <textarea name="message" type="text" placeholder=" " data-text="${message.text().trim()}">${message.text().trim()}</textarea>
                    <label>Atualizar o seu comentário...</label>
                    <div class="icon top">
                        <i class="fa-solid fa-comment"></i>
                    </div>
                    <div class="icon down">${attributes.comment.max}</div>
                </div>

                <div class="comment-footer">
                    <div class="comment-action">
                        <div class="comment-button cancel">
                            <button>Cancelar</button>
                        </div>

                        <div class="comment-button submit disabled">
                            <button class="disabled" disabled>Atualizar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>`

        message.html(content)
    })

    $(document).on('click', button_update_submit_2, function(event) {
        event.preventDefault()

        $.validator.addMethod('notEqual', function(value, element, param) {
            return value !== $(element).data('text')
        })

        let commentUpdate = $(form_update).validate({
            errorElement: 'span',
            rules: {
                message: {
                    required: true,
                    minlength: 1,
                    maxlength: attributes.comment.max,
                    notEqual: true
                }
            },
            messages: {
                message: {
                    required: 'O comentário é um campo obrigatório.',
                    minlength: jQuery.validator.format('O comentário deve conter no mínimo {0} caracteres.'),
                    maxlength: jQuery.validator.format('O comentário deve conter no máximo {0} caracteres.'),
                    notEqual: 'O comentário deve ser diferente do original.'
                }
            }
        })

        if ($(form_update).valid()) {
            if (validation('update', button_update_submit_1, button_update_submit_2)) {
                return
            }

            $.ajax({
                url: attributes.comment.api.update,
                type: 'POST',
                data: getToken() + $(form_update).serialize(),
                dataType: 'JSON',
                beforeSend: function() {
                    submitButton('start', button_update_submit_1, button_update_submit_2)
                },
                success: function(action) {
                    submitButton('close', button_update_submit_1, button_update_submit_2)

                    if (action.status) {
                        $.showNotification({
                            type: 'success',
                            message: action.status_message
                        })

                        addToken(action.token)
                        addUpdatedMessage(action.comment)
                        return
                    }

                    if (action.status_textarea) {
                        const errors = {
                            message: action.status_message
                        }
                        commentUpdate.showErrors(errors)
                        return
                    }

                    $.showNotification({
                        type: action.status_type,
                        message: action.status_message
                    })
                },
                error: function() {
                    submitButton('close', button_update_submit_1, button_update_submit_2)

                    $.showNotification({
                        type: 'error',
                        message: 'Não foi possível processar a sua solicitação!'
                    })
                }
            })
        }
    })

    $(document).on('click', button_update_cancel_2, function(event) {
        event.preventDefault()

        formUpdateReset($(this).closest('.message-box').data('message'))
    })

    $(document).on('focusin', form_update + ' textarea', function() {
        let interval_update = setInterval(function() {
            validation('update', button_update_submit_1, button_update_submit_2)
        }, 200)

        $(this).focusout(function() {
            clearInterval(interval_update)
        })
    })

    function addUpdatedMessage(comment) {
        updateDate()

        $('#comment-' + comment.id).parent().empty().html('<span>' + comment.message + '</span>')

        const content = $('#message-' + comment.id + ' .box-info .box-date')

        if (comment.updated_at) {
            content.find('span').filter('[data-updated]').attr('data-updated', comment.updated_at).text('agora')

            if (!content.find('span:contains("(Editado)")').length) {
                content.append('<span>(Editado)</span>')
            }
        }
    }

    function formUpdateReset() {
        $('[id^="comment-"]').each(function() {
            $(this).parent().empty().html('<span>' + $(this).find('textarea').data('text') + '</span>')
        })
    }
</script>