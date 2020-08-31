/**
 * @file
 * Provides mobile toggler for the the Ultimenu main block.
 */

(function ($, Drupal, window) {

  'use strict';

  Drupal.ultimenu = Drupal.ultimenu || {};
  var ultimenuTimer;

  Drupal.behaviors.ultimenu = {
    attach: function (context) {

      $(context).find('[data-ultimenu]').once('ultimenu').each(function () {
        var $that = $(this);
        var $link = $that.find('.ultimenu__link');

        if (!$link.find('.caret').length) {
          $link.append('<span class="caret" />');
        }

        $that.on('click', '.caret', function (e) {
          e.preventDefault();
          var $caret = $(this);

          $caret.closest('li').toggleClass('js-ultimenu-item-expanded');
          $caret.parent().toggleClass('js-ultimenu-active');
          $caret.parent().next('.ultimenu__flyout')
            .not(':animated').slideToggle();
        });
      });

      $('[data-ultimenu-button]').once('ultimenu-button').click(function (e) {
        e.preventDefault();
        var $button = $(this);

        $button.toggleClass('js-ultimenu-button-active');
        $('body').toggleClass('js-ultimenu-expanded');
        $('.js-ultimenu-item-expanded', '[data-ultimenu]').removeClass('js-ultimenu-item-expanded');
        $('[data-ultimenu] .ultimenu__link')
          .removeClass('js-ultimenu-active')
          .next('.ultimenu__flyout')
          .slideUp();
        $($button.data('ultimenuButton')).not(':animated').slideToggle();
      });

      $(window).off('resize.ultimenu').on('resize.ultimenu', function () {
        window.clearTimeout(ultimenuTimer);
        ultimenuTimer = window.setTimeout(Drupal.ultimenu.ultimenuMain, 10);
      });
    }
  };

  Drupal.ultimenu.ultimenuMain = function () {
    var $body = $('body');
    var $ultimenu = $('[data-ultimenu]');

    if ($('[data-ultimenu-button]').is(':hidden')) {
      $body.removeClass('js-ultimenu-expanded');
      $ultimenu.show();
    }
    else {
      $body.addClass('js-ultimenu-expanded');
      $ultimenu.hide();
    }
  };

})(jQuery, Drupal, this);
