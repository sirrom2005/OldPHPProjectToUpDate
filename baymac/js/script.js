// <![CDATA[
$(function() {

  // Slider
  $('#coin-slider').coinslider({width:960,height:99,opacity:1, delay: 8000, spw: 1, sph: 1});
  $('#coin-slider').show().delegate('.cs-more', 'click', function() {
    var $e = $(this),
        fulltext = $e.next().html(),
        $textContainer = $e.prev();
        $textContainer.html(fulltext);
        $e.hide();
  });
  // Radius Box
  //$('p.infopost').css({"border-radius":"6px", "-moz-border-radius":"6px", "-webkit-border-radius":"6px"});
  //$('.content .sidebar .gadget, .fbg_resize').css({"border-radius":"12px", "-moz-border-radius":"12px", "-webkit-border-radius":"12px"});
  //$('.content p.pages span, .content p.pages a').css({"border-radius":"16px", "-moz-border-radius":"16px", "-webkit-border-radius":"16px"});
  //$('.menu_nav').css({"border-bottom-left-radius":"16px", "border-bottom-right-radius":"16px", "-moz-border-radius-bottomleft":"16px", "-moz-border-radius-bottomright":"16px", "-webkit-border-bottom-left-radius":"16px", "-webkit-border-bottom-right-radius":"16px"});
  $('ul.sb_menu li, ul.ex_menu li, .content p.pages span, .content p.pages a').css({"border-radius":"6px", "-moz-border-radius":"6px", "-webkit-border-radius":"6px"});
  $('a.rm').css({"border-top-left-radius":"6px", "border-bottom-left-radius":"6px", "-moz-border-radius-topleft":"6px", "-moz-border-radius-bottomleft":"6px", "-webkit-border-top-left-radius":"6px", "-webkit-border-bottom-left-radius":"6px"});
  $('a.com').css({"border-top-right-radius":"6px", "border-bottom-right-radius":"6px", "-moz-border-radius-topright":"6px", "-moz-border-radius-bottomright":"6px", "-webkit-border-top-right-radius":"6px", "-webkit-border-bottom-right-radius":"6px"});

});	

// Cufon
Cufon.replace('h1, h2, h3, h4, h5, h6, a.com,.menu_nav ul li a, a.rm', { hover: true });
//Cufon.replace('h1', { color: '-linear-gradient(#fff, #ffaf02)'});
//Cufon.replace('h1 small', { color: '#8a98a5'});

// ]]>
