!function(t){"use strict";t(document).ready(function(){var e=function(e){var n=e.find(".zn_general_carousel");return n&&n.length&&"undefined"!=typeof t.fn.carouFredSel?(jQuery.each(n,function(e,n){function a(e,n){var a=(t(n),t(n).closest(".kl-slideshow")),i=t(e.items.visible).attr("data-color");a.css({backgroundColor:i})}var i=t(n),o=function(){var t=i.triggerHandler("currentVisible");i.children(".cfs--item").removeClass("cfs--active-item"),t.addClass("cfs--active-item")},r=function(){i.children(".cfs--item").removeClass("cfs--active-item")},c={fancy:!0,transition:"fade",direction:"left",responsive:!0,auto:!0,items:{visible:1},scroll:{fx:"fade",timeoutDuration:9e3,easing:"swing",onBefore:r,onAfter:o},swipe:{onTouch:!0,onMouse:!0},pagination:{container:i.parent().find(".cfs--pagination"),anchorBuilder:function(t){var e="";if(i.is("[data-thumbs]")&&"zn_has_thumbs"==i.data("thumbs")){var n=i.children("li");e='style="background-image:url('+n.eq(t-1).attr("data-thumb")+');"'}return'<a href="#'+t+'" '+e+"></a>"}},next:{button:i.parent().find(".cfs--next"),key:"right"},prev:{button:i.parent().find(".cfs--prev"),key:"left"},onCreate:o};i.is("[data-fancy]")&&(c.fancy=i.data("fancy"));var s={scroll:{fx:i.is("[data-transition]")?i.data("transition"):c.transition,timeoutDuration:i.is("[data-timout]")?parseFloat(i.data("timout")):c.scroll.timeoutDuration,easing:i.is("[data-easing]")?i.data("easing"):c.scroll.easing,onBefore:r,onAfter:o},auto:{play:i.is("[data-autoplay]")&&"1"==i.attr("data-autoplay")?c.auto:!1},direction:i.is("[data-direction]")?i.data("direction"):c.direction};c.fancy&&t.extend(s.scroll,{onBefore:function(t){a(t,i)},onAfter:function(t){a(t,i)}}),i.imagesLoaded(function(){i.carouFredSel(t.extend({},c,s))}),c.fancy&&t(window).on("debouncedresize",function(){t(window).width()<1199?i.trigger("configuration",["direction","left"]):i.trigger("configuration",["direction","up"]),i.trigger("updateSizes")})}),!1):void 0},n=t(".zn_fancy_slider_container");n&&e(n)})}(jQuery);