
$('#set-avatar').click(function() {
    $.ajax({
        url: $(this).attr('href'),
        type:'post',
        error: function(){alert('error');},
        success:function(html){
            $('#avatar-container').html(html);
            $('#avatarModal').modal('show');
        }
    });
});

/*联动查询js*/
/*$("#datingsearch-title").change(function () {
    var html = '';
    $.ajax({
        url: "/index.php/dating/dating/type-list",
        type: 'GET',
        dataType: 'json',
        data: {type: $(this).val()},
        success: function (msg) {
            $.each(msg, function (key, val) {
                html += '<option value="' + key + '">' + val + '</option>';
            });
            $("#datingsearch-number").html(html);
        }
    })
});*/
