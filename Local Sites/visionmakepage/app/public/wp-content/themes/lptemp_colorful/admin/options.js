(function( $ ) {
    $('#tabs').tabs();

    var options = {
        defaultColor: false,
        change: function(event, ui){},
        clear: function() {},
        hide: true,
        palettes: true
    };
    $('.color-picker').wpColorPicker(options);

    $('.select-file').click(function(){
        var custom_uploader;
        var formid = $(this).data('input');
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        custom_uploader = wp.media({
            title: 'ファイルを選択',
            library: {
                type: 'image'
            },
            button: {
                text: 'ファイルを選択'
            },
            multiple: false
        });
        custom_uploader.on('select', function() {
            var images = custom_uploader.state().get('selection');
            images.each(function(file){
                $('#'+formid).val(file.toJSON().url);
            });
        });
        custom_uploader.open();
    });

    $('.shadow_enable').change(function(){
        if( $(this).val() == 'on' ) {
            $('#shadow_color').show();
        } else {
            $('#shadow_color').hide();
        }
    });
})( jQuery );