$(function() {
  $("div.scrollable").scrollable(
    {
      size: 4,
      loop: true,
      navi: ".cnavi",
      prev: ".prev",
      next: ".next",
      speed: 400,
      items: ".items",
      vertical: false,
      keyboard: false,
      prevPage: ".prevPage",
      nextPage: ".nextPage",
      clickable: false,
      hoverClass: "active",
      activeClass: "active",
      disabledClass: "disabled"
    }
  );
  $(".item_container, .ic_link").mouseover(function(){
    //var container = $(".carouselContainer")[0];
    //alert(  container.offsetTop + " -- " + container.offsetHeight + " -- "   +  container.offsetLeft + " -- " +  container.offsetWidth);
    //var top = container.offsetTop + container.offsetHeight - 25;
    //var left =  container.offsetLeft;
    //var width = container.offsetWidth;
    $("#movieInfo").html($(this).children("div").html());//.css({'top': top, 'left': left, 'width' : width});
    $("#movieInfo").show();    
  }).mouseout(function(){
    $("#movieInfo").html("&nbsp;");
  });
});
