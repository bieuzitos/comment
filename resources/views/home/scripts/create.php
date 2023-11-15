<script>
    const form_create = 'form[data-function="create"]'

    const button_create_submit_1 = 'form[data-function="create"] .comment-button.submit'
    const button_create_submit_2 = 'form[data-function="create"] .comment-button.submit button'

    const button_create_cancel_1 = 'form[data-function="create"] .comment-button.cancel'
    const button_create_cancel_2 = 'form[data-function="create"] .comment-button.cancel button'

    $(document).ready(function() {
        $(button_create_submit_2).on('click', function(event) {
            event.preventDefault()

            $(form_create).submit()
        })

        $(button_create_cancel_2).on('click', function(event) {
            event.preventDefault()

            formCreateReset()
        })

        $(form_create + ' textarea').focusin(function() {
            let interval_create = setInterval(function() {
                validation('create', button_create_submit_1, button_create_submit_2)
            }, 200)

            $(this).focusout(function() {
                clearInterval(interval_create)
            })
        })

        $(form_create + ' textarea').on('input', function() {
            validation('create', button_create_submit_1, button_create_submit_2)

            if ($(button_create_cancel_1).hasClass('hidden')) {
                $(button_create_cancel_1).removeClass('hidden')
            }
        })

        let commentCreate = $(form_create).validate({
            errorElement: 'span',
            rules: {
                message: {
                    required: true,
                    minlength: 1,
                    maxlength: attributes.comment.max
                }
            },
            messages: {
                message: {
                    required: 'O comentário é um campo obrigatório.',
                    minlength: jQuery.validator.format('O comentário deve conter no mínimo {0} caracteres.'),
                    maxlength: jQuery.validator.format('O comentário deve conter no máximo {0} caracteres.')
                }
            },
            submitHandler: function(form) {
                if (validation('create', button_create_submit_1, button_create_submit_2)) {
                    return
                }

                $.ajax({
                    url: attributes.comment.api.create,
                    type: 'POST',
                    data: getToken() + $(form).serialize(),
                    dataType: 'JSON',
                    beforeSend: function() {
                        submitButton('start', button_create_submit_1, button_create_submit_2)
                    },
                    success: function(action) {
                        submitButton('close', button_create_submit_1, button_create_submit_2)

                        if (action.status) {
                            $.showNotification({
                                type: 'success',
                                message: action.status_message
                            })

                            addToken(action.token)
                            addMessage(action.comment)

                            formCreateReset()
                            return
                        }

                        if (action.status_textarea) {
                            const errors = {
                                message: action.status_message
                            }
                            commentCreate.showErrors(errors)
                            return
                        }

                        $.showNotification({
                            type: action.status_type,
                            message: action.status_message
                        })
                    },
                    error: function() {
                        submitButton('close', button_create_submit_1, button_create_submit_2)

                        $.showNotification({
                            type: 'error',
                            message: 'Não foi possível processar a sua solicitação!'
                        })
                    }
                })
            }
        })

        function formCreateReset() {
            commentCreate.resetForm()

            submitButton('close', button_create_submit_1, button_create_submit_2)

            $(form_create)[0].reset()
            $(form_create + ' .icon.down').text(attributes.comment.max)
            $(button_create_cancel_1).addClass('hidden')
        }
    })

    function addMessage(comment) {
        updateDate()

        const count = parseInt($('.message .message-header .count').text())

        const content = `<div id="message-${comment.id}" class="message-box animated" data-message="${comment.id}">
            <div class="box-user">
                <div class="box-avatar">
                    <img src="${attributes.account.avatar}" />
                </div>
            </div>

            <div class="box-content">
                <div class="box-header">
                    <div class="box-info">
                        <span class="box-name">${attributes.account.username}</span>
                        <div class="box-date">
                            <i class="fa-regular fa-calendar-check"></i>
                            <span data-updated="${comment.created_at}">agora</span>
                        </div>
                    </div>

                    <div class="box-button">
                        <button>
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>

                        <div class="dropdown" style="display: none;">
                            <div class="dropdown-content">
                                <div class="dropdown-middle">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-body">
                    <span>${comment.message}</span>
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
        </div>`

        let newCount = count + 1

        if ($('.message-content .message-empty').length > 0) {
            $('.message-content .message-empty').addClass('hidden')
        }

        $('.message .message-header .count').text(newCount)
        $('.message .message-header .text').text((newCount === 1) ? 'Comentário' : 'Comentários')

        $('.message .message-content').prepend(content)
    }

    function updateDate() {
        $('.box-date span').filter('[data-updated]').each(function() {
            $(this).text(diffForHumans($(this).data('updated')))
        })
    }
</script>