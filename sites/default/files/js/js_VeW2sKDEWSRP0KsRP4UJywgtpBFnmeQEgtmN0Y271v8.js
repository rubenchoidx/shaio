!function(e,s){"use strict";function a(s,a){var n=e(a);e(".details-legend-prefix",n).removeClass("element-invisible"),n[e(".form-checkbox--vanilla",n).prop("checked")?"addClass":"removeClass"]("form--vanilla-on"),n.on("click",".form-checkbox",function(){var s=e(this);s[s.prop("checked")?"addClass":"removeClass"]("on"),s.hasClass("form-checkbox--vanilla")&&n[s.prop("checked")?"addClass":"removeClass"]("form--vanilla-on")}),e('select[name$="[style]"]',n).on("change",function(){var s=e(this);n.removeClass(function(e,s){return(s.match(/(^|\s)form--style-\S+/g)||[]).join(" ")}),""===s.val()?n.addClass("form--style-off"):n.addClass("form--style-on form--style-"+s.val())}).change(),e('select[name$="[responsive_image_style]"]',n).on("change",function(){var s=e(this);n[""===s.val()?"removeClass":"addClass"]("form--responsive-image-on")}).change(),e('select[name$="[media_switch]"]',n).on("change",function(){var s=e(this);n.removeClass(function(e,s){return(s.match(/(^|\s)form--media-switch-\S+/g)||[]).join(" ")}),n[""===s.val()?"removeClass":"addClass"]("form--media-switch-"+s.val())}).change(),n.on("mouseenter touchstart",".hint",function(){e(this).closest(".form-item").addClass("is-hovered")}),n.on("mouseleave touchend",".hint",function(){e(this).closest(".form-item").removeClass("is-hovered")}),n.on("click",".hint",function(){e(".form-item.is-selected",n).removeClass("is-selected"),e(this).parent().toggleClass("is-selected")}),n.on("click",".description",function(){e(this).closest(".is-selected").removeClass("is-selected")}),n.on("focus",".js-expandable",function(){e(this).parent().addClass("is-focused")}),n.on("blur",".js-expandable",function(){e(this).parent().removeClass("is-focused")})}function n(s,a){var n=e(a);n.siblings(".hint").length||n.closest(".form-item").append('<span class="hint">?</span>')}s.behaviors.blazyAdmin={attach:function(s){var o=e(".form--slick",s);e(".description",o).once("blazy-tooltip").each(n),o.once("blazy-admin").each(a)}}}(jQuery,Drupal);
;