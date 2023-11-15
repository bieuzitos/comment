
/*
|--------------------------------------------------------------------------
| Dropdown
|--------------------------------------------------------------------------
*/

$(document).on('click', '.box-button button, .message-action button', function (event) {
    event.preventDefault();

    ($(this).hasClass('active')) ? $(this).removeClass('active') : $(this).addClass('active')

    $button = $('button', $(this).parent())
    $dropdown = $('.dropdown', $(this).parent()).toggle()

    $('.box-button button, .message-action button').not($button).removeClass('active')
    $('.box-button .dropdown, .message-action .dropdown').not($dropdown).hide()

    return false
})

$(document).on('click', '.box-button .dropdown, .message-action .dropdown', function (event) {
    event.stopPropagation();
})

$(document).on('click', function () {
    $('.box-button button, .message-action button').removeClass('active')
    $('.box-button .dropdown, .message-action .dropdown').hide()
})

/*
|--------------------------------------------------------------------------
| Button Submit
|--------------------------------------------------------------------------
*/

$('form').on('keypress', function (event) {
    let press = event.keyCode || event.which
    if (press === 13) {
        event.preventDefault()
        return false
    }
})

/*
|--------------------------------------------------------------------------
| CSRF
|--------------------------------------------------------------------------
*/

function getToken() {
    let content = $('meta[name="csrf_token"]').attr('content')
    if (content !== undefined && content !== '') {
        return 'csrf_token=' + encodeURIComponent(content) + '&'
    }

    return ''
}

function addToken(content) {
    $('meta[name="csrf_token"]').attr('content', content)
}

/*
|--------------------------------------------------------------------------
| Submit Button
|--------------------------------------------------------------------------
*/

function submitButton(action, div, button) {
    if (action === 'start') {
        if ($(button).prop('loading') === true) {
            return false
        }

        $(div).removeClass('disabled').addClass('inactive')
        $(button).prop('loading', true).removeClass('disabled').addClass('inactive')
        $(button).prop('data-text', $(button).text())
        $(button).css('width', $(button).outerWidth()).html('<i class="fa-solid fa-spinner fa-spin"></i>')
    }

    if (action === 'close') {
        $(div).addClass('disabled').removeClass('inactive')
        $(button).prop('loading', false).addClass('disabled').removeClass('inactive')
        $(button).prop('disabled', true)
        $(button).css('width', '').html($(button).prop('data-text'))
    }

    if (action === 'active') {
        $(parent).removeClass('disabled').removeClass('inactive')
        $(button).prop('loading', false).removeClass('disabled').removeClass('inactive')
        $(button).prop('disabled', false)
        $(button).css('width', '').html($(button).prop('data-text'))
    }
}

/*
|--------------------------------------------------------------------------
| Textarea Count
|--------------------------------------------------------------------------
*/

$(document).on('input', '.textarea textarea', function () {
    $(this).parent().find('.icon.down').text(attributes.comment.max - $(this).val().length)
})

/*
|--------------------------------------------------------------------------
| Date Format
|--------------------------------------------------------------------------
*/

function diffForHumans(date) {
    const current_at = new Date()
    const updated_at = new Date(date)

    const diffInMilliseconds = updated_at - current_at;
    const diffInSeconds = Math.floor(Math.abs(diffInMilliseconds) / 1000);

    if (diffInSeconds < 60) {
        return `há ${diffInSeconds} segundo${diffInSeconds !== 1 ? 's' : ''}`;
    } else if (diffInSeconds < 3600) {
        const minutes = Math.floor(diffInSeconds / 60);
        return `há ${minutes} minuto${minutes !== 1 ? 's' : ''}`;
    } else if (diffInSeconds < 86400) {
        const hours = Math.floor(diffInSeconds / 3600);
        return `há ${hours} hora${hours !== 1 ? 's' : ''}`;
    } else if (diffInSeconds < 2592000) {
        const days = Math.floor(diffInSeconds / 86400);
        return `há ${days} dia${days !== 1 ? 's' : ''}`;
    } else if (diffInSeconds < 31536000) {
        const months = Math.floor(diffInSeconds / 2592000);
        return `há ${months} mês${months !== 1 ? 'es' : ''}`;
    } else {
        const years = Math.floor(diffInSeconds / 31536000);
        return `há ${years} ano${years !== 1 ? 's' : ''}`;
    }
}