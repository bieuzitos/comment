<script>
    function validation(type, div, button) {
        let empty = false

        $('form[data-function="' + type + '"] .textarea textarea').each(function() {
            if ($(this).val().length === 0 || $('.textarea').find('textarea.error')[0]) {
                empty = true
            }

            if ($(this).attr('name') === 'message') {
                let input = $(this).val()
                let regex_message = /^[\s\S]+$/
                if (input.length < 1 || input.length > attributes.comment.max || !regex_message.test(input) || input === $(this).data('text')) {
                    empty = true
                }
            }
        })

        if (empty) {
            $(div).addClass('disabled')
            $(button).addClass('disabled').prop('disabled', true)
            return true
        } else {
            $(div).removeClass('disabled')
            $(button).removeClass('disabled').prop('disabled', false)
        }

        return false
    }
</script>