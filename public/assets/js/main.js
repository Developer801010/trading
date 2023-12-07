// HEADER
(function ($) {
    $(function () {
        $('.navigation-menu ul li a:not(:only-child)').click(function (e) {
            $(this).siblings('.nav-dropdown').toggle();
            $('.nav-dropdown').not($(this).siblings()).hide();
            e.stopPropagation();
        });
        $('html').click(function () {
            $('.nav-dropdown').hide();
        });
        $('#nav-toggle').click(function () {
            $('.navigation-menu ul').slideToggle(300).toggleClass("dm-block","dm-flex");
        });
        $('#nav-toggle').on('click', function () {
            this.classList.toggle('active');
        });
    });
})(jQuery);

$(function(){
    $(".table tr.view").on("click", function(){
      if($(this).hasClass("open")) {
        $(this).removeClass("open").next(".fold").removeClass("open");
      } else {
        $(".table tr.view").removeClass("open").next(".fold").removeClass("open");
        $(this).addClass("open").next(".fold").addClass("open");
      }
    });
  });
  $(document).ready(function() {
    $(".toggle-password").click(function () {
        $(this).find(".icon").toggle();
        input = $(this).parent().find("input");
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
});
