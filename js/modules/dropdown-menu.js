export function dropDownMenu() {
    // Dropdown Menu
    let ddMenu = null;
    ddMenu = document.querySelectorAll('.dropDownMenu > a:first-of-type');
    if (ddMenu !== null && ddMenu !== '') {
        for (var i = 0; i < ddMenu.length; i++) {
            ddMenu[i].onclick = function () {
                event.preventDefault();
                $(this).toggleClass('open');
            };
        }
    }
}
