
$(document).ready(function(){

    $(".profile .kali_navbar_icon").click(function(){
      $(this).parent().toggleClass("active");
      $(".notifications").removeClass("active");
    });

    $(".notifications .kali_navbar_icon").click(function(){
      $(this).parent().toggleClass("active");
       $(".profile").removeClass("active");
    });

    $(".show_all .link").click(function(){
      $(".notifications").removeClass("active");
      $(".popup").show();
    });

    $(".close").click(function(){
      $(".popup").hide();
    });

});