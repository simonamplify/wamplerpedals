(function ($) {
    // Nested mobile menu
    $(window).load(function () {
        var collapseMenu = null;
        var collapseMenu = document.querySelector(".et_mobile_menu");
        if (collapseMenu !== null && collapseMenu !== "") {
            function setup_collapsible_submenus() {
                var $menu = $(".et_mobile_menu"),
                    top_level_link =
                        ".et_mobile_menu .menu-item-has-children > a";
                $menu.find("a").each(function () {
                    $(this).off("click");
                    if ($(this).is(top_level_link)) {
                        $(this).attr("href", "#");
                    }
                    if (!$(this).siblings(".sub-menu").length) {
                        $(this).on("click", function (event) {
                            $(this).parents(".mobile_nav").trigger("click");
                        });
                    } else {
                        $(this).on("click", function (event) {
                            event.preventDefault();
                            $(this).parent().toggleClass("visible");
                        });
                    }
                });
            }
        }
        if (collapseMenu !== null && collapseMenu !== "") {
            setTimeout(function () {
                setup_collapsible_submenus();
            }, 700);
        }
    });

    $(document).ready(function () {
        // Menu Search
        function searchBar() {
            event.preventDefault();
            $(".menuSearch").toggleClass("focus");
            const srchInpt = document.querySelector(
                ".menuSearch.focus .dgwt-wcas-search-input"
            );
            if ($(".menuSearch").hasClass("focus")) {
                srchInpt.focus({ preventScroll: true });
            }
            //document.querySelector('.menuSearch.focus .dgwt-wcas-search-input').focus({preventScroll: true});
            var ms = document.querySelectorAll(
                ".menuSearchBtn .material-icons"
            );
            for (var i = 0; i < ms.length; i++) {
                if (ms[i].innerHTML == "search") {
                    ms[i].innerHTML = "search_off";
                } else {
                    ms[i].innerHTML = "search";
                }
            }
        }
        function closeSearchBar() {
            event.preventDefault();
            $(".menuSearch").removeClass("focus");
            var ms = document.querySelectorAll(
                ".menuSearchBtn .material-icons"
            );
            for (var i = 0; i < ms.length; i++) {
                ms[i].innerHTML = "search";
            }
            return false;
        }
        $(".menuSearchBtn").click(function (event) {
            searchBar();
        });
        $(".et_divi_100_custom_hamburger_menu__icon").click(function (event) {
            closeSearchBar();
        });

        // Product Filters
        const smallDevice = window.matchMedia("(max-width: 980px)");
        smallDevice.addListener(handleDeviceChange);
        function handleDeviceChange(e) {
            if (e.matches) {
                $(".prodFiltersBtn").click(function (event) {
                    event.preventDefault();
                    $(".prodFilters").toggleClass("open");
                    $(".prodFiltersBtn .bapf_colaps_smb").toggleClass(
                        "fa-chevron-up fa-chevron-down"
                    );
                    return false;
                });
            }
        }
        handleDeviceChange(smallDevice);

        // Change add to cart button text after click
        $(
            ".et_pb_shop .ajax_add_to_cart, #related .products .ajax_add_to_cart, .single-product .single_add_to_cart_button"
        ).on("click", function (event) {
            $(this).text("Added to Cart");
            var addToCart = $(this);
            window.setTimeout(function () {
                $(addToCart).text("Add to Cart");
            }, 5000);
        });
        $(
            "#related .products .outofstock .button, .et_pb_shop .products .outofstock .button"
        ).text("Out of stock");

        // Dropdown Menu
        let ddMenu = null;
        ddMenu = document.querySelectorAll(".dropDownMenu > a:first-of-type");
        if (ddMenu !== null && ddMenu !== "") {
            for (var i = 0; i < ddMenu.length; i++) {
                ddMenu[i].onclick = function () {
                    event.preventDefault();
                    $(this).toggleClass("open");
                };
            }
        }

        // Artist list filter
        var options = {
            valueNames: ["artistName"],
        };
        var artistList = new List("artists", options);
        /* Artist Search Clear */
        $("#artists .search").on("keyup", function () {
            if (this.value.length > 0) {
                $("#artists .clear").show();
            } else {
                $("#artists .clear").hide();
            }
        });
        $("#artists .clear").on("click", function (event) {
            artistList.search();
            artistList.filter();
            artistList.update();
            $("#artists .search").val("");
            $("#artists .search").focus();
            $("#artists .clear").hide();
        });
        $("#artists .artistOverlay").hide();
        $("#artists .bioBtn").on("click", function (event) {
            var artistHash = $(this).attr("href").substring(1);
            $(".artistModal." + artistHash).fadeIn(500);
            $("#artists .artistOverlay").fadeIn(500);
        });
        $("#artists .closeArtist").on("click", function (event) {
            var artistHash = $(this).attr("href").substring(1);
            $(".artistModal." + artistHash).fadeOut(500);
            $("#artists .artistOverlay").fadeOut(500);
        });
        $("#artists .artist .artistDetails .artistContent a").attr(
            "target",
            "_blank"
        );

        // Validate Get Response Form
        const grFormBtn = document.querySelector(
            '.grForm input[type="submit"]'
        );
        if (grFormBtn !== null && grFormBtn !== "") {
            // Check if form button field exists
            const grForm = document.querySelector(".grForm form");
            const grFormAlert = document.querySelector(".grForm form .alert"); // Define the alert element
            /* American phone number */
            const poPhone = document.querySelector(
                '.grForm input[name="custom_phone"]'
            );
            let pVal = 1;
            const valPhone = () => {
                // Validate phone number starts with +1
                if (poPhone.value !== "") {
                    // If phone number field not empty
                    if (poPhone.value.indexOf("+1") == 0) {
                        // Check if +1 is present and pass validation
                        pVal = 1;
                        poPhone.classList.remove("invalid");
                    } else {
                        // Fail validation
                        pVal = 0;
                        poPhone.classList.add("invalid");
                    }
                } else {
                    // If phone number field empty
                    poPhone.classList.remove("invalid");
                    pVal = 1;
                }
            };
            // Listen to phone field and validate the form
            if (poPhone) {
                poPhone.addEventListener("touchend", valPhone);
                poPhone.addEventListener("keyup", valPhone);
            }
            // Validate the form if required fields are populated
            const reqFields = grForm.querySelectorAll("[required]");
            let rfVal = 1;
            const valReqFields = () => {
                for (var i = 0; i < reqFields.length; i++) {
                    if (reqFields[i].value === "") {
                        // If the field is empty
                        rfVal = 0;
                        reqFields[i].classList.add("invalid");
                    } else {
                        // If the field is not empty
                        rfVal = 1;
                        reqFields[i].classList.remove("invalid");
                    }
                }
            };
            // Listen to required fields and validate the form
            for (var i = 0; i < reqFields.length; i++) {
                reqFields[i].addEventListener("touchend", valReqFields);
                reqFields[i].addEventListener("keyup", valReqFields);
            }
            const formReturn = () => {
                grFormAlert.textContent = "";
            };
            window.addEventListener("onpageshow", formReturn);
            // If the form button is clicked
            const valForm = (e) => {
                e.preventDefault(); // Stop noraml actions
                if (poPhone) {
                    valPhone(); // Validate the phone field if it exists
                }
                valReqFields(); // Validate the required fields are populated
                if (rfVal === 0 || pVal === 0) {
                    // If validation fails
                    e.preventDefault();
                    grFormAlert.textContent =
                        "Please ensure fields are populated appropriately.";
                } else {
                    // Otherwise hand over to google recaptcha
                    grFormBtn.disabled = true;
                    grFormAlert.textContent = "Processing...";
                    /* reCaptcha */
                    grecaptcha.ready(function () {
                        grecaptcha
                            .execute(
                                "6Ldo_N4UAAAAAK3pUABb8yv4CUpDxTaAu657Dpdt",
                                { action: "getresponse" }
                            )
                            .then(function (token) {
                                // Add your logic to submit to your backend server here.
                                let recaptchaResponse =
                                    document.getElementById(
                                        "recaptchaResponse"
                                    );
                                recaptchaResponse.value = token; // Set the recaptcha response
                                fetch(
                                    "/wp-content/themes/wamplerpedals/lib/recaptcha.php",
                                    {
                                        method: "POST",
                                        body: new FormData(grForm), // Send the form data
                                    }
                                )
                                    .then((response) => response.text())
                                    .then((response) => {
                                        const responseText =
                                            JSON.parse(response); // Get the response
                                        if (responseText.error !== "") {
                                            // If there is an error
                                            grFormAlert.textContent =
                                                responseText.error;
                                            grFormBtn.disabled = false;
                                            return;
                                        } else if (
                                            responseText.success !== ""
                                        ) {
                                            grFormAlert.textContent =
                                                responseText.success;
                                            grFormBtn.disabled = false;
                                            grForm.submit();
                                            setTimeout(() => {
                                                formReturn();
                                            }, 3000);
                                        }
                                    });
                            });
                    });
                }
            };
            grFormBtn.addEventListener("click", valForm);
        }
    });
})(jQuery);
