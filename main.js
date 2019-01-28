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
    jQuery(document).ready(function ($) {
      var SETTINGS = {
        sticky: 'everywhere',
        // false || mobile
        stickySelector: '.site-header, .site-navigation',
        stickyHeight: 45 // wow: false, // || 'everywhere' || 'desktop',
        // appearJs: false, // || true,
        // countTo: false, // || '.counter',

      };

      if (SETTINGS.stickySelector) {
        if ('mobile' == SETTINGS.sticky && SETTINGS.is_mobile || SETTINGS.sticky == 'everywhere') {
          var $panel = $('#wpadminbar, #bx-panel');
          var space = $panel.length ? $panel.height() : 0;
          var $container = $(SETTINGS.stickySelector);

          try {
            if ($container.length) {
              if (undefined !== $container.sticky) {
                $container.sticky({
                  topSpacing: space,
                  zIndex: 1100,
                  height: SETTINGS.stickyHeight
                });
                $container.parent('.sticky-wrapper').css('margin-bottom', $container.css('margin-bottom'));
              } else {
                console.error('Sticky library is not available!');
              }
            }
          } catch (e) {
            console.error(e);
          }
        }
      }

      if (SETTINGS.wow) {
        if ('desktop' == SETTINGS.wow && !SETTINGS.is_mobile || SETTINGS.wow == 'everywhere') {
          new WOW().init();
        }
      }

      if (SETTINGS.appearJs) {
        if (SETTINGS.countTo) {
          $(SETTINGS.countTo).appear();
          $(SETTINGS.countTo).on("appear", function (event, $all_appeared_elements) {
            if (!$(this).data("appeared")) $(this).countTo();
            $(this).data("appeared", 1);
          });
        }
      } else if (SETTINGS.countTo) {
        $(SETTINGS.countTo).countTo();
      }
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
        ERROR: "Контент по запросу не найден. <br/> Пожалуйста попробуйте снова, позже.",
        PLAY_START: "Начать слайдшоу",
        PLAY_STOP: "Пауза",
        FULL_SCREEN: "На весь экран",
        THUMBS: "Превью",
        DOWNLOAD: "Скачать",
        SHARE: "Поделиться",
        ZOOM: "Приблизить"
      };

      window.showPreloader = function (message) {
        if (!message) message = 'Загрузка..';
        $preload = $('<p>' + message + '</p>').css({
          'margin-top': '50px',
          'margin-bottom': '-40px',
          'padding-bottom': '',
          'color': '#ddd'
        });
        ;
        $.fancybox.open({
          content: $preload,
          type: 'html',
          smallBtn: false,
          afterLoad: function afterLoad(instance, current) {
            $('.fancybox-content', instance.$refs['fancybox-stage']).css('background', 'none');
          },
          afterShow: function afterShow(instance, current) {
            instance.showLoading(current);
          },
          afterClose: function afterClose(instance, current) {
            instance.hideLoading(current);
          }
        });
      }; // showPreloader( 'What is love?' );
      // setTimeout(function(){
      //     $.fancybox.getInstance().close();
      //     $.fancybox.open({
      //         content  : 'Hello world!',
      //         type     : 'html',
      //     });
      // }, 3000);

      /********************************* Slick **********************************/


      window.slickSlider = function (target, props) {
        var _defaults = {
          autoplay: true,
          autoplaySpeed: 4000,
          dots: true,
          infinite: false,
          slidesToShow: 4,
          slidesToScroll: 4,
          responsive: [{
            breakpoint: 576,
            settings: {}
          }]
        };

        try {
          if (!props) props = {};
          this.props = Object.assign(_defaults, props);
        } catch (e) {
          console.log('Init props is demaged.');
          this.props = _defaults;
        }

        this.$slider = $(target);
        this.isInit = false;
      };

      window.slickSlider.prototype = {
        init: function init(minWidth) {
          if (!this.$slider.length) return false;

          try {
            if (!this.isInit) {
              if (undefined !== this.$slider.slick) {
                this.$slider.slick(this.props);
                this.isInit = this.$slider.hasClass('slick-initialized');
              } else {
                console.error('Slick library is not available!');
              }
            }
          } catch (e) {
            console.error(e);
          }
        },
        responsive: function responsive(minWidth) {
          var self = this;
          if (!minWidth) minWidth = 992;
          if (!this.$slider.length) return false;
          $(window).on('load resize', function (e) {
            if (minWidth < $(window).width()) {
              if (self.isInit) {
                self.$slider.slick('unslick');
                self.isInit = false;
              }
            } else {
              self.init();
            }
          });
        }
      };
      var slick = new slickSlider('.slider', {
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [{
          breakpoint: 576,
          settings: {
            slidesToShow: 1
          }
        }]
      });
      slick.responsive();
    });
  }, {}]
}, {}, [1]);
//# sourceMappingURL=maps/main.js.map
