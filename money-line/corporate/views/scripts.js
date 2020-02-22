
Raxan.beforeReady(function( $ ) {
    $.effects.blink = function(o) {
        var el = $(this);
        el.show('bounce','fast');
        window.setTimeout(function(){
            el.fadeOut('fast',function(){el.hide()});
        },2500);
    };
});
