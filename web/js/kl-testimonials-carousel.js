!function(e){"use strict";e(document).ready(function(){var t=function(t){var n=t.find(".testimonials_carousel");n&&"undefined"!=typeof e.fn.carouFredSel&&e.each(n,function(t,n){var i=e(n),o=i.data("speed");i.carouFredSel({responsive:!0,items:{width:360,visible:{min:1,max:1}},auto:{timeoutDuration:o},prev:{button:function(){return i.closest(".testimonials-carousel").find(".prev")},key:"left"},next:{button:function(){return i.closest(".testimonials-carousel").find(".next")},key:"right"}})})},n=e(".testimonials-carousel");n&&t(n)})}(jQuery);