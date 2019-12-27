$(document).ready(function() {
  // Sidebar toggle
  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });

  // Page title
  var pageTitle = $(document).attr("title");
  $("#page-title").text(pageTitle);

  // Active sidebar menu item
  var menuID = pageTitle.toLowerCase().replace(" ", "-");
  $("#" + menuID).toggleClass("bg-light").toggleClass("active");

});