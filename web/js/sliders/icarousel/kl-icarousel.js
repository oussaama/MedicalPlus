!function(a){"use strict";a(document).ready(function(){var e=function(e){var t=e.find(".th-icarousel");t&&t.length&&"undefined"!=typeof a.fn.iCarousel&&a.each(t,function(e,t){var i=a(t),r={easing:"easeInOutQuint",pauseOnHover:!0,timerPadding:0,timerStroke:4,timerBarStroke:0,animationSpeed:700,nextLabel:"",previousLabel:"",autoPlay:i.is("[data-autoplay]")?i.data("autoplay"):!0,slides:i.is("[data-slides]")?i.data("slides"):7,pauseTime:i.is("[data-timeout]")?i.data("timeout"):5e3,perspective:i.is("[data-perspective]")?i.data("perspective"):75,slidesSpace:i.is("[data-slidespaces]")?i.data("slidespaces"):300,direction:i.is("[data-direction]")?i.data("direction"):"ltr",timer:i.is("[data-timer]")?i.data("timer"):"Bar",timerOpacity:i.is("[data-timeropc]")?i.data("timeropc"):.4,timerDiameter:i.is("[data-timerdim]")?i.data("timerdim"):220,keyboardNav:i.is("[data-keyboard]")?i.data("keyboard"):!0,mouseWheel:i.is("[data-mousewheel]")?i.data("mousewheel"):!0,timerColor:i.is("[data-timercolor]")?i.data("timercolor"):"#FFF",timerPosition:i.is("[data-timerpos]")?i.data("timerpos"):"bottom-center",timerX:i.is("[data-timeroffx]")?i.data("timeroffx"):0,timerY:i.is("[data-timeroffy]")?i.data("timeroffy"):-20};"undefined"!=typeof a.fn.iCarousel&&i.imagesLoaded(function(){i.iCarousel(r)})})},t=a(".kl-icarousel-container");t&&e(t)})}(jQuery);