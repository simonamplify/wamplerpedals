<?php
// Disaply message if a product is in stock and quantity is less than 10
if (is_product()) {
    global $product;
    if ($product->is_in_stock() && $product->managing_stock() && $product->get_stock_quantity() < 3) {
        echo '<p class="stock-warning">🔥<span>Selling out FAST</span>🔥 Grab yours before they\'re gone!</p>';
    }
}
return '';
?>