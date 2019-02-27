"use strict";

(function () {
  function r(e, n, t) {
    function o(i, f) {
      if (!n[i]) {
        if (!e[i]) {
          var c = "function" == typeof require && require;
          if (!f && c) return c(i, !0);
          if (u) return u(i, !0);
          var a = new Error("Cannot find module '" + i + "'");
          throw a.code = "MODULE_NOT_FOUND", a;
        }

        var p = n[i] = {
          exports: {}
        };
        e[i][0].call(p.exports, function (r) {
          var n = e[i][1][r];
          return o(n || r);
        }, p, p.exports, r, e, n, t);
      }

      return n[i].exports;
    }

    for (var u = "function" == typeof require && require, i = 0; i < t.length; i++) {
      o(t[i]);
    }

    return o;
  }

  return r;
})()({
  1: [function (require, module, exports) {
    "use strict";

    jQuery(document).ready(function ($) {
      // @see about https://github.com/wilddeer/stickyfill
      // Sticky removed in favour native css
      var Plugins = {
        appearJs: false,
        // || true,
        countTo: false // || '.counter',
        // Do you want some animate?
        // new WOW().init();

      };

      if (Plugins.appearJs) {
        if (Plugins.countTo) {
          $(Plugins.countTo).appear();
          $(Plugins.countTo).on("appear", function (event, $all_appeared_elements) {
            if (!$(this).data("appeared")) $(this).countTo();
            $(this).data("appeared", 1);
          }); // $(Plugins.countTo).on('disappear', function(event, $all_disappeared_elements) {
          // });
        }
      } else if (Plugins.countTo) {
        $(Plugins.countTo).countTo();
      }

      window.scrollTo = function (selector, topOffset, delay) {
        if (!selector || selector.length <= 1) return;
        if (!topOffset) topOffset = 40;
        if (!delay) delay = 500; // try get jQuery object by selector

        var $obj = $(selector),
            // try get by classic anchors (if is not found)
        offset = $obj.length && $obj.offset() || $('a[name=' + selector.slice(1) + ']').offset();

        if (offset) {
          $('html, body').animate({
            scrollTop: offset.top - topOffset
          }, delay);
        } // not found
        else {
            console.log('Element not exists.');
          }
      };
      /******************************** Fancybox ********************************/


      $.fancybox.defaults.buttons = ["zoom", //"share",
      "slideShow", "fullScreen", //"download",
      // "thumbs",
      "close"];
      $.fancybox.defaults.lang = "ru";
      $.fancybox.defaults.i18n.ru = {
        CLOSE: "Закрыть",
        NEXT: "Следующий",
        PREV: "Предыдущий",
        ERROR: "Контент по запросу не найден. <br/> Пожалуйста, попробуйте позже.",
        PLAY_START: "Начать слайдшоу",
        PLAY_STOP: "Остановить слайдшоу",
        FULL_SCREEN: "На весь экран",
        THUMBS: "Эскизы",
        DOWNLOAD: "Скачать",
        SHARE: "Поделиться",
        ZOOM: "Приблизить"
        /********************************* Custom *********************************/
        // ...

      };
    });
  }, {}]
}, {}, [1]);
//# sourceMappingURL=maps/main.js.map
