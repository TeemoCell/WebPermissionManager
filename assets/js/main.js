(function($) {
    "use strict";

    var path = window.location.href;
        $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function() {
            if (this.href === path) {
                $(this).addClass("active");
            }
        });

})(jQuery);

$(document).ready(function() {
  $('#GroupManager').DataTable();
});
