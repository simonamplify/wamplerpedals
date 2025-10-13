import { menu } from './modules/menu.min.js';
import { menuSearch } from './modules/menu-search.min.js';
import { productFilters } from './modules/product-filters.min.js';
import { cartButton } from './modules/cart-button.min.js';
import { dropDownMenu } from './modules/dropdown-menu.min.js';
import { artistsFilter } from './modules/artists-filter.min.js';

document.addEventListener('DOMContentLoaded', () => {
    /* Mobile menu */
    menu();
    /* Menu search */
    menuSearch();
    /* Product filters */
    productFilters();
    /* Cart button */
    cartButton();
    /* Dropdown menu */
    dropDownMenu();
    /* Artists filter */
    artistsFilter();
});
