export function artistsFilter() {
    (function ($) {
        $(document).ready(function () {
            // Artist list filter
            var options = {
                valueNames: ['artistName'],
            };
            var artistList = new List('artists', options);
            /* Artist Search Clear */
            $('#artists .search').on('keyup', function () {
                if (this.value.length > 0) {
                    $('#artists .clear').show();
                } else {
                    $('#artists .clear').hide();
                }
            });
            $('#artists .clear').on('click', function (event) {
                artistList.search();
                artistList.filter();
                artistList.update();
                $('#artists .search').val('');
                $('#artists .search').focus();
                $('#artists .clear').hide();
            });
            $('#artists .artistOverlay').hide();
            $('#artists .bioBtn').on('click', function (event) {
                var artistHash = $(this).attr('href').substring(1);
                $('.artistModal.' + artistHash).fadeIn(500);
                $('#artists .artistOverlay').fadeIn(500);
            });
            $('#artists .closeArtist').on('click', function (event) {
                var artistHash = $(this).attr('href').substring(1);
                $('.artistModal.' + artistHash).fadeOut(500);
                $('#artists .artistOverlay').fadeOut(500);
            });
            $('#artists .artist .artistDetails .artistContent a').attr(
                'target',
                '_blank'
            );
        });
    })(jQuery);
}
