;(function(window) {
  var notificationContainer = document.querySelector('.notf-container'); // Select the notification container

  var proto_methods = {
      options: {
          wrapper: notificationContainer, // Use the notification container as the wrapper
          dismissIn: 5000
      },
      init: function() {
          this.ntf = document.createElement('div');
          this.ntf.className = 'f-notification';
          var strinner = '<div class="f-notification-inner"></div><div class="f-close">x</div></div>';
          this.ntf.innerHTML = strinner;

          this.options.wrapper.insertBefore(this.ntf, this.options.wrapper.lastChild);

          this.initEvents();
      },
      initEvents: function() {
          var self = this;
          this.ntf.querySelector('.f-close').addEventListener('click', function() {
              self.dismiss();
          });
      },
      dismiss: function() {
          var self = this;
          clearTimeout(this.dismissttl);

          classie.remove(self.ntf, 'f-show');
          setTimeout(function() {
              classie.add(self.ntf, 'f-hide');
          }, 25);

          setTimeout(function() {
              self.options.wrapper.removeChild(self.ntf);
          }, 500);
          
      },
      setType: function(newType) {
          var self = this;

          classie.remove(self.ntf, 'f-notification-error');
          classie.remove(self.ntf, 'f-notification-alert');
          classie.remove(self.ntf, 'f-notification-success');

          classie.add(self.ntf, newType);

      },
      success: function(message, dismissIn) {
          var self = this;

          dismissIn = (typeof dismissIn === "undefined") ? this.options['dismissIn'] : dismissIn;

          self.setType('f-notification-success');

          self.ntf.querySelector('.f-notification-inner').innerHTML = message;

          classie.remove(self.ntf, 'f-hide');
          classie.add(self.ntf, 'f-show');

          if (dismissIn > 0) {
              this.dismissttl = setTimeout(function() {
                  self.dismiss();
              }, dismissIn);
          }
      },
      error: function(message, dismissIn) {
          var self = this;

          dismissIn = (typeof dismissIn === "undefined") ? this.options['dismissIn'] : dismissIn;

          self.setType('f-notification-error');

          self.ntf.querySelector('.f-notification-inner').innerHTML = message;

          classie.remove(self.ntf, 'f-hide');
          classie.add(self.ntf, 'f-show');

          if (dismissIn > 0) {
              this.dismissttl = setTimeout(function() {
                  self.dismiss();
              }, dismissIn);
          }
      },
      alert: function(message, dismissIn) {
          var self = this;

          dismissIn = (typeof dismissIn === "undefined") ? this.options['dismissIn'] : dismissIn;

          self.setType('f-notification-alert');

          self.ntf.querySelector('.f-notification-inner').innerHTML = message;

          classie.remove(self.ntf, 'f-hide');
          classie.add(self.ntf, 'f-show');

          if (dismissIn > 0) {
              this.dismissttl = setTimeout(function() {
                  self.dismiss();
              }, dismissIn);
          }
      }
  }, flatNotify, _flatNotifiy;

  _flatNotifiy = function() {
      this.init();
  };

  _flatNotifiy.prototype = proto_methods;

  flatNotify = function() {
      return new _flatNotifiy();
  };

  window.flatNotify = flatNotify;

  function showNotification(type, message, dismissIn) {
      var notification = flatNotify();
      notification.show(type, message, dismissIn);
  }

  window.showNotification = showNotification;
})(window);

;(function(window) {
  'use strict';

  function classReg(className) {
      return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
  }

  var hasClass, addClass, removeClass;

  if ('classList' in document.documentElement) {
      hasClass = function(elem, c) {
          return elem.classList.contains(c);
      };
      addClass = function(elem, c) {
          elem.classList.add(c);
      };
      removeClass = function(elem, c) {
          elem.classList.remove(c);
      };
  } else {
      hasClass = function(elem, c) {
          return classReg(c).test(elem.className);
      };
      addClass = function(elem, c) {
          if (!hasClass(elem, c)) {
              elem.className = elem.className + ' ' + c;
          }
      };
      removeClass = function(elem, c) {
          elem.className = elem.className.replace(classReg(c), ' ');
      };
  }

  function toggleClass(elem, c) {
      var fn = hasClass(elem, c) ? removeClass : addClass;
      fn(elem, c);
  }

  var classie = {
      hasClass: hasClass,
      addClass: addClass,
      removeClass: removeClass,
      toggleClass: toggleClass,
      has: hasClass,
      add: addClass,
      remove: removeClass,
      toggle: toggleClass
  };

  if (typeof define === 'function' && define.amd) {
      define(classie);
  } else {
      window.classie = classie;
  }

})(window);
