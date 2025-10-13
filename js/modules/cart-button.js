export function cartButton() {
    (function ($) {
        $(document).ready(function () {
            // Change add to cart button text after click
            $(
                '.et_pb_shop .ajax_add_to_cart, #related .products .ajax_add_to_cart, .single-product .single_add_to_cart_button'
            ).on('click', function (event) {
                $(this).text('Added to Cart');
                var addToCart = $(this);
                window.setTimeout(function () {
                    $(addToCart).text('Add to Cart');
                }, 5000);
            });
            $(
                '#related .products .outofstock .button, .et_pb_shop .products .outofstock .button'
            ).text('Out of stock');
        });
    })(jQuery);
}
