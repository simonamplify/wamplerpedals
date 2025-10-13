export function menuSearch() {
    (function ($) {
        $(document).ready(function () {
            // Menu Search
            function searchBar() {
                event.preventDefault();
                $('.menuSearch').toggleClass('focus');
                const srchInpt = document.querySelector(
                    '.menuSearch.focus .dgwt-wcas-search-input'
                );
                if ($('.menuSearch').hasClass('focus')) {
                    srchInpt.focus({ preventScroll: true });
                }
                //document.querySelector('.menuSearch.focus .dgwt-wcas-search-input').focus({preventScroll: true});
                var ms = document.querySelectorAll(
                    '.menuSearchBtn .material-icons'
                );
                for (var i = 0; i < ms.length; i++) {
                    if (ms[i].innerHTML == 'search') {
                        ms[i].innerHTML = 'search_off';
                    } else {
                        ms[i].innerHTML = 'search';
                    }
                }
            }
            function closeSearchBar() {
                event.preventDefault();
                $('.menuSearch').removeClass('focus');
                var ms = document.querySelectorAll(
                    '.menuSearchBtn .material-icons'
                );
                for (var i = 0; i < ms.length; i++) {
                    ms[i].innerHTML = 'search';
                }
                return false;
            }
            $('.menuSearchBtn').click(function (event) {
                searchBar();
            });
            $('.et_divi_100_custom_hamburger_menu__icon').click(function (
                event
            ) {
                closeSearchBar();
            });
        });
    })(jQuery);
}
