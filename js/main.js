(function($){
    // Nested mobile menu
    $(window).load(function() {
        var collapseMenu = null;
        var collapseMenu = document.querySelector('.et_mobile_menu');
        if(collapseMenu !== null && collapseMenu !== '') {
            function setup_collapsible_submenus() {
                var $menu = $('.et_mobile_menu'),
                    top_level_link = '.et_mobile_menu .menu-item-has-children > a';
                $menu.find('a').each(function() {
                    $(this).off('click'); 
                    if ( $(this).is(top_level_link) ) {
                        $(this).attr('href', '#');
                    }
                    if ( ! $(this).siblings('.sub-menu').length ) {
                        $(this).on('click', function(event) {
                            $(this).parents('.mobile_nav').trigger('click');
                        });
                    } else {
                        $(this).on('click', function(event) {
                            event.preventDefault();
                            $(this).parent().toggleClass('visible');
                        });
                    }
                });
            }
        }
        if(collapseMenu !== null && collapseMenu !== '') {
            setTimeout(function() {
                setup_collapsible_submenus();
            }, 700);
        }
    });

    $(document).ready( function(){     

		// Menu Search
        function searchBar() {
            event.preventDefault();
            $('.menuSearch').toggleClass('focus');
            const srchInpt = document.querySelector('.menuSearch.focus .dgwt-wcas-search-input');
            if ($('.menuSearch').hasClass("focus")) {
                srchInpt.focus({preventScroll: true});
            }
            //document.querySelector('.menuSearch.focus .dgwt-wcas-search-input').focus({preventScroll: true});
            var ms = document.querySelectorAll('.menuSearchBtn .material-icons');
            for(var i = 0; i < ms.length; i++) {
                if (ms[i].innerHTML == "search") {
                    ms[i].innerHTML = "search_off";
                } else {
                    ms[i].innerHTML = "search";
                }
            }
        }
        function closeSearchBar() {
            event.preventDefault();
            $('.menuSearch').removeClass('focus');
            var ms = document.querySelectorAll('.menuSearchBtn .material-icons');
            for(var i = 0; i < ms.length; i++) {
                ms[i].innerHTML = "search";
            }
            return false;
        }
        $('.menuSearchBtn').click(function(event) {
            searchBar();
        });
        $('.et_divi_100_custom_hamburger_menu__icon').click(function(event) {
            closeSearchBar();
        });

        // Product Filters 
        const smallDevice = window.matchMedia("(max-width: 980px)");
        smallDevice.addListener(handleDeviceChange);
        function handleDeviceChange(e) {
            if (e.matches) {
                $('.prodFiltersBtn').click(function(event) {
                    event.preventDefault();
                    $('.prodFilters').toggleClass('open');
                    $('.prodFiltersBtn .bapf_colaps_smb').toggleClass('fa-chevron-up fa-chevron-down');
                    return false;
                });
            }
        }
        handleDeviceChange(smallDevice);

        // Change add to cart button text after click
        $('.et_pb_shop .ajax_add_to_cart, #related .products .ajax_add_to_cart, .single-product .single_add_to_cart_button').on('click', function(event) {
			$(this).text('Added to Cart');
            var addToCart = $(this);
            window.setTimeout(function () {
                $(addToCart).text('Add to Cart');
            }, 5000);
		});
		$('#related .products .outofstock .button, .et_pb_shop .products .outofstock .button').text('Out of stock');

        // Dropdown Menu
        let ddMenu = null;
        ddMenu = document.querySelectorAll('.dropDownMenu > a:first-of-type');
        if(ddMenu !== null && ddMenu !== '') {
            for(var i = 0; i < ddMenu.length; i++) { 
                ddMenu[i].onclick = function () {
                    event.preventDefault();
                    $(this).toggleClass('open');
                };
            }
        }

        // Artist list filter 
        var options = {
            valueNames: [ 'artistName' ]
        };
        var artistList = new List('artists', options);
        /* Artist Search Clear */
        $('#artists .search').on('keyup', function() {
            if (this.value.length > 0) {
                $('#artists .clear').show();
            } else {
                $('#artists .clear').hide();
            }
        });
        $('#artists .clear').on('click', function(event) {
            artistList.search();
            artistList.filter();
            artistList.update();
            $('#artists .search').val('');
            $('#artists .search').focus();
            $('#artists .clear').hide();
        });
        $('#artists .artistOverlay').hide();
        $('#artists .bioBtn').on('click', function(event) {
            var artistHash = $(this).attr('href').substring(1);
            $('.artistModal.'+artistHash).fadeIn(500);
            $('#artists .artistOverlay').fadeIn(500);
        });
        $('#artists .closeArtist').on('click', function(event) {
            var artistHash = $(this).attr('href').substring(1);
            $('.artistModal.'+artistHash).fadeOut(500);
            $('#artists .artistOverlay').fadeOut(500);
        });
        $('#artists .artist .artistDetails .artistContent a').attr('target', '_blank');

        // Validate Get Response Form
        /* American phone number */
        let poPhone = null;
        poPhone = document.querySelector('.grForm input[name="custom_phone"]');
        let grVal = 1;
        if(poPhone !== null && poPhone !== '') { // Check if phone field exists
            const valPhone = () => { // Validate phone number starts with +1
                if (poPhone.value !== "") { // If phone number field not empty
                    if (poPhone.value.indexOf('+1') == 0) { // Check if +1 is present and pass validation
                        grVal = 1;
                        poPhone.classList.remove("invalid");
                        return grVal;
                    } else { // Fail validation
                        grVal = 0;
                        poPhone.classList.add("invalid");
                        return grVal;
                    }
                } else { // If phone number field empty
                    poPhone.classList.remove("invalid");
                    grVal = 1;
                }
            }
            const grFormBtn = document.querySelector('.grForm input[type="submit"]');
            const valForm = (event) => { // If validation has failed prevent the form submitting
                if (grVal === 0) {
                    event.preventDefault();
                } else {
                    // Proceed with form submission
                }
            }
            poPhone.addEventListener("touchend", valPhone);
            poPhone.addEventListener("keyup", valPhone);
            grFormBtn.addEventListener("click", valForm);
        }
        

	});
})(jQuery)