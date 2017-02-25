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

                var itemHtml = '<a href="/vinils/details/' + i.id + '" class="list-group-item">' +
                    '<i>' + i.title + '</i> - ' + i.artist + ' - [' + i.genre + ']' +
                    '</a>';

                $('.list-group.vinils a').first().before(itemHtml);
            },
            error: function(e) {
                $('#messages').html('There was an error addding the item!')
                .addClass('text-danger').removeClass('text-success').show().delay(3000).fadeOut();
            }
        });
    });