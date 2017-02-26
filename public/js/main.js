$('.input-form').submit(function(e) {
    e.preventDefault();

    $.ajax({
        url: '',
        type: 'POST',
        traditional: true,
        timeout: 3000,
        data: $(this).serializeArray(),
        success: function(data) {
            i = data.data;
            $('#messages').html('New item added!')
            .addClass('text-success').removeClass('text-danger').show().delay(1000).fadeOut();

            var itemHtml = $('.listing-format').html();
            var matches = itemHtml.match(/#[^#]*#/g);
            matches = $.map(matches, function(i) { return i.substr(1, i.length - 2) });

            $.each(matches, function(key, item) {
                itemHtml = itemHtml.replace('#' + item + '#', i[item]);
            });

            $('.list-group.items a').first().before(itemHtml);
        },
        error: function(e) {
            $('#messages').html('There was an error addding the item!')
            .addClass('text-danger').removeClass('text-success').show().delay(3000).fadeOut();
        }
    });
});

$('.delete-button').bind('click', function(e) {
    $.ajax({
        url: '',
        type: 'DELETE',
        timeout: 1000,
        success: function(result) {
            $('.delete-button').attr('disabled', true);
            $('#messages').html('Item deleted!').addClass('text-warning');
        },
        error: function(e) {
            $('#messages').html('There was an error deleting the item!').addClass('text-danger');
        }
    })
});
