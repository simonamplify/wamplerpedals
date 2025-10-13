export function productFilters() {
    (function ($) {
        $(document).ready(function () {
            // Product Filters
            const smallDevice = window.matchMedia('(max-width: 980px)');
            smallDevice.addListener(handleDeviceChange);
            function handleDeviceChange(e) {
                if (e.matches) {
                    $('.prodFiltersBtn').click(function (event) {
                        event.preventDefault();
                        $('.prodFilters').toggleClass('open');
                        $('.prodFiltersBtn .bapf_colaps_smb').toggleClass(
                            'fa-chevron-up fa-chevron-down'
                        );
                        return false;
                    });
                }
            }
            handleDeviceChange(smallDevice);
        });
    })(jQuery);
}
