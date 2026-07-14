"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["app"],{

/***/ "./assets/app.js"
/*!***********************!*\
  !*** ./assets/app.js ***!
  \***********************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_iterator_constructor_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.iterator.constructor.js */ "./node_modules/core-js/modules/es.iterator.constructor.js");
/* harmony import */ var core_js_modules_es_iterator_constructor_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_iterator_constructor_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var core_js_modules_es_iterator_for_each_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! core-js/modules/es.iterator.for-each.js */ "./node_modules/core-js/modules/es.iterator.for-each.js");
/* harmony import */ var core_js_modules_es_iterator_for_each_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_iterator_for_each_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _styles_app_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./styles/app.css */ "./assets/styles/app.css");



document.addEventListener('DOMContentLoaded', () => {
  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const els = document.querySelectorAll('.reveal');
  if (reduced || !('IntersectionObserver' in window)) {
    els.forEach(el => el.classList.add('in'));
    return;
  }
  const io = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('in');
        io.unobserve(entry.target);
      }
    });
  }, {
    threshold: 0.12
  });
  els.forEach(el => io.observe(el));
});
// ═══ Modals des cours ═══
window.openModal = function (id) {
  const modal = document.getElementById(id);
  if (modal) {
    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
  }
};
window.closeModal = function (id) {
  const modal = document.getElementById(id);
  if (modal) {
    modal.classList.remove('open');
    document.body.style.overflow = '';
  }
};

// Fermer en cliquant sur le fond sombre (hors de la boîte)
document.addEventListener('click', function (e) {
  if (e.target.classList.contains('modal-overlay')) {
    e.target.classList.remove('open');
    document.body.style.overflow = '';
  }
});

// Fermer avec la touche Échap
document.addEventListener('keydown', function (e) {
  if (e.key === 'Escape') {
    document.querySelectorAll('.modal-overlay.open').forEach(function (m) {
      m.classList.remove('open');
    });
    document.body.style.overflow = '';
  }
});
// ═══ Navbar active link au scroll ═══
document.addEventListener('DOMContentLoaded', function () {
  const sections = document.querySelectorAll('section[id], div[id]');
  const navLinks = document.querySelectorAll('.topbar-menu a');
  function setActive() {
    let current = '';
    sections.forEach(section => {
      const sectionTop = section.offsetTop - 100;
      if (window.scrollY >= sectionTop) {
        current = section.getAttribute('id');
      }
    });
    navLinks.forEach(link => {
      link.classList.remove('active');
      const href = link.getAttribute('href').replace('#', '');
      if (href === current) {
        link.classList.add('active');
      }
    });
  }
  window.addEventListener('scroll', setActive);
  setActive();
});
window.toggleAvatarMenu = function () {
  const menu = document.getElementById('avatar-menu');
  menu.classList.toggle('open');
};
window.showSection = function (section) {
  document.querySelectorAll('.db-nav-item').forEach(i => i.classList.remove('active'));
  document.querySelectorAll('.db-section').forEach(s => s.classList.remove('active'));
  document.querySelector('[data-section="' + section + '"]').classList.add('active');
  document.getElementById('section-' + section).classList.add('active');
};
// Fermer le menu avatar en cliquant ailleurs
document.addEventListener('click', function (e) {
  if (!e.target.closest('.db-avatar-wrap')) {
    const menu = document.getElementById('avatar-menu');
    if (menu) menu.classList.remove('open');
  }
});

// ═══ Toggle mot de passe ═══
window.togglePassword = function (inputId, iconId) {
  const input = document.getElementById(inputId);
  const icon = document.getElementById(iconId);
  if (!input || !icon) return;
  if (input.type === 'password') {
    input.type = 'text';
    icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19M1 1l22 22"/>';
  } else {
    input.type = 'password';
    icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
  }
};

// ═══ Switcher connexion / inscription ═══
window.switchAuth = function (mode) {
  const formConnexion = document.getElementById('form-connexion');
  const formInscription = document.getElementById('form-inscription');
  const title = document.getElementById('auth-title');
  const subtitle = document.getElementById('auth-subtitle');
  const error = document.getElementById('mcf-error');
  if (error) error.style.display = 'none';
  if (mode === 'inscription') {
    formConnexion.style.display = 'none';
    formInscription.style.display = 'flex';
    title.textContent = 'Créer un compte';
    subtitle.textContent = 'Rejoignez Nour Dicko Academy';
  } else {
    formInscription.style.display = 'none';
    formConnexion.style.display = 'flex';
    title.textContent = 'Connexion';
    subtitle.textContent = 'Accédez à votre espace personnel';
  }
};

// ═══ Vérification mots de passe ═══
window.checkPasswords = function () {
  const pwd = document.getElementById('mcf-reg-password').value;
  const confirm = document.getElementById('mcf-reg-confirm').value;
  const error = document.getElementById('mcf-error');
  if (pwd.length < 8) {
    error.textContent = 'Le mot de passe doit contenir au moins 8 caractères.';
    error.style.display = 'block';
    return;
  }
  if (pwd !== confirm) {
    error.textContent = 'Les mots de passe ne correspondent pas.';
    error.style.display = 'block';
    return;
  }
  error.style.display = 'none';
  // Ton dev branchera ici l'appel API pour créer le compte
  alert('Compte créé avec succès ! Votre dev branchera cette action.');
};

// ═══ Avatar menu ═══
window.toggleAvatarMenu = function () {
  const menu = document.getElementById('avatar-menu');
  if (menu) menu.classList.toggle('open');
};
document.addEventListener('click', function (e) {
  if (!e.target.closest('.db-avatar-wrap') && !e.target.closest('.topbar-btns')) {
    const menu = document.getElementById('avatar-menu');
    if (menu) menu.classList.remove('open');
  }
});

// ═══ Popup lancement ═══
window.closeLaunchPopup = function () {
  const popup = document.getElementById('launch-popup');
  if (popup) {
    popup.style.opacity = '0';
    popup.style.transition = 'opacity .3s';
    setTimeout(() => popup.style.display = 'none', 300);
    localStorage.setItem('nda-launch-seen', '1');
  }
};

// Afficher la popup seulement si pas déjà vue
document.addEventListener('DOMContentLoaded', function () {
  const popup = document.getElementById('launch-popup');
  if (popup && localStorage.getItem('nda-launch-seen')) {
    popup.style.display = 'none';
  }
});

// ═══ CTA flottant — apparaît après le hero ═══
window.addEventListener('scroll', function () {
  const cta = document.querySelector('.floating-cta');
  const hero = document.querySelector('.nda-hero');
  if (!cta || !hero) return;
  if (window.scrollY > hero.offsetHeight) {
    cta.classList.add('visible');
  } else {
    cta.classList.remove('visible');
  }
});

// ═══ Auto-hide welcome toast ═══
document.addEventListener('DOMContentLoaded', function () {
  const toast = document.getElementById('welcome-toast');
  if (toast) {
    setTimeout(function () {
      toast.style.display = 'none';
    }, 4000);
  }
});

/***/ },

/***/ "./assets/styles/app.css"
/*!*******************************!*\
  !*** ./assets/styles/app.css ***!
  \*******************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_core-js_modules_es_iterator_constructor_js-node_modules_core-js_modules_-af7644"], () => (__webpack_exec__("./assets/app.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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QUcsQ0FBQyxTQUFTLENBQUMsTUFBTSxDQUFDLFNBQVMsQ0FBQztFQUNqQztBQUNGLENBQUMsQ0FBQzs7QUFFRjtBQUNBLFFBQVEsQ0FBQyxnQkFBZ0IsQ0FBQyxrQkFBa0IsRUFBRSxZQUFVO0VBQ3RELE1BQU0sS0FBSyxHQUFHLFFBQVEsQ0FBQyxjQUFjLENBQUMsZUFBZSxDQUFDO0VBQ3RELElBQUcsS0FBSyxFQUFDO0lBQ1AsVUFBVSxDQUFDLFlBQVU7TUFDbkIsS0FBSyxDQUFDLEtBQUssQ0FBQyxPQUFPLEdBQUcsTUFBTTtJQUM5QixDQUFDLEVBQUUsSUFBSSxDQUFDO0VBQ1Y7QUFDRixDQUFDLENBQUMsQzs7Ozs7Ozs7Ozs7QUMvTUYiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvYXBwLmpzIiwid2VicGFjazovLy8uL2Fzc2V0cy9zdHlsZXMvYXBwLmNzcz8zZmJhIl0sInNvdXJjZXNDb250ZW50IjpbImltcG9ydCAnLi9zdHlsZXMvYXBwLmNzcyc7XG5cbmRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoJ0RPTUNvbnRlbnRMb2FkZWQnLCAoKSA9PiB7XG4gICAgY29uc3QgcmVkdWNlZCA9IHdpbmRvdy5tYXRjaE1lZGlhKCcocHJlZmVycy1yZWR1Y2VkLW1vdGlvbjogcmVkdWNlKScpLm1hdGNoZXM7XG4gICAgY29uc3QgZWxzID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLnJldmVhbCcpO1xuXG4gICAgaWYgKHJlZHVjZWQgfHwgISgnSW50ZXJzZWN0aW9uT2JzZXJ2ZXInIGluIHdpbmRvdykpIHtcbiAgICAgICAgZWxzLmZvckVhY2goKGVsKSA9PiBlbC5jbGFzc0xpc3QuYWRkKCdpbicpKTtcbiAgICAgICAgcmV0dXJuO1xuICAgIH1cblxuICAgIGNvbnN0IGlvID0gbmV3IEludGVyc2VjdGlvbk9ic2VydmVyKChlbnRyaWVzKSA9PiB7XG4gICAgICAgIGVudHJpZXMuZm9yRWFjaCgoZW50cnkpID0+IHtcbiAgICAgICAgICAgIGlmIChlbnRyeS5pc0ludGVyc2VjdGluZykge1xuICAgICAgICAgICAgICAgIGVudHJ5LnRhcmdldC5jbGFzc0xpc3QuYWRkKCdpbicpO1xuICAgICAgICAgICAgICAgIGlvLnVub2JzZXJ2ZShlbnRyeS50YXJnZXQpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcbiAgICB9LCB7IHRocmVzaG9sZDogMC4xMiB9KTtcblxuICAgIGVscy5mb3JFYWNoKChlbCkgPT4gaW8ub2JzZXJ2ZShlbCkpO1xufSk7XG4vLyDilZDilZDilZAgTW9kYWxzIGRlcyBjb3VycyDilZDilZDilZBcbndpbmRvdy5vcGVuTW9kYWwgPSBmdW5jdGlvbihpZCl7XG4gIGNvbnN0IG1vZGFsID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoaWQpO1xuICBpZihtb2RhbCl7XG4gICAgbW9kYWwuY2xhc3NMaXN0LmFkZCgnb3BlbicpO1xuICAgIGRvY3VtZW50LmJvZHkuc3R5bGUub3ZlcmZsb3cgPSAnaGlkZGVuJztcbiAgfVxufTtcblxud2luZG93LmNsb3NlTW9kYWwgPSBmdW5jdGlvbihpZCl7XG4gIGNvbnN0IG1vZGFsID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoaWQpO1xuICBpZihtb2RhbCl7XG4gICAgbW9kYWwuY2xhc3NMaXN0LnJlbW92ZSgnb3BlbicpO1xuICAgIGRvY3VtZW50LmJvZHkuc3R5bGUub3ZlcmZsb3cgPSAnJztcbiAgfVxufTtcblxuLy8gRmVybWVyIGVuIGNsaXF1YW50IHN1ciBsZSBmb25kIHNvbWJyZSAoaG9ycyBkZSBsYSBib8OudGUpXG5kb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIGZ1bmN0aW9uKGUpe1xuICBpZihlLnRhcmdldC5jbGFzc0xpc3QuY29udGFpbnMoJ21vZGFsLW92ZXJsYXknKSl7XG4gICAgZS50YXJnZXQuY2xhc3NMaXN0LnJlbW92ZSgnb3BlbicpO1xuICAgIGRvY3VtZW50LmJvZHkuc3R5bGUub3ZlcmZsb3cgPSAnJztcbiAgfVxufSk7XG5cbi8vIEZlcm1lciBhdmVjIGxhIHRvdWNoZSDDiWNoYXBcbmRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoJ2tleWRvd24nLCBmdW5jdGlvbihlKXtcbiAgaWYoZS5rZXkgPT09ICdFc2NhcGUnKXtcbiAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcubW9kYWwtb3ZlcmxheS5vcGVuJykuZm9yRWFjaChmdW5jdGlvbihtKXtcbiAgICAgIG0uY2xhc3NMaXN0LnJlbW92ZSgnb3BlbicpO1xuICAgIH0pO1xuICAgIGRvY3VtZW50LmJvZHkuc3R5bGUub3ZlcmZsb3cgPSAnJztcbiAgfVxufSk7XG4vLyDilZDilZDilZAgTmF2YmFyIGFjdGl2ZSBsaW5rIGF1IHNjcm9sbCDilZDilZDilZBcbmRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoJ0RPTUNvbnRlbnRMb2FkZWQnLCBmdW5jdGlvbigpe1xuICBjb25zdCBzZWN0aW9ucyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJ3NlY3Rpb25baWRdLCBkaXZbaWRdJyk7XG4gIGNvbnN0IG5hdkxpbmtzID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLnRvcGJhci1tZW51IGEnKTtcblxuICBmdW5jdGlvbiBzZXRBY3RpdmUoKXtcbiAgICBsZXQgY3VycmVudCA9ICcnO1xuICAgIHNlY3Rpb25zLmZvckVhY2goc2VjdGlvbiA9PiB7XG4gICAgICBjb25zdCBzZWN0aW9uVG9wID0gc2VjdGlvbi5vZmZzZXRUb3AgLSAxMDA7XG4gICAgICBpZih3aW5kb3cuc2Nyb2xsWSA+PSBzZWN0aW9uVG9wKXtcbiAgICAgICAgY3VycmVudCA9IHNlY3Rpb24uZ2V0QXR0cmlidXRlKCdpZCcpO1xuICAgICAgfVxuICAgIH0pO1xuICAgIG5hdkxpbmtzLmZvckVhY2gobGluayA9PiB7XG4gICAgICBsaW5rLmNsYXNzTGlzdC5yZW1vdmUoJ2FjdGl2ZScpO1xuICAgICAgY29uc3QgaHJlZiA9IGxpbmsuZ2V0QXR0cmlidXRlKCdocmVmJykucmVwbGFjZSgnIycsJycpO1xuICAgICAgaWYoaHJlZiA9PT0gY3VycmVudCl7XG4gICAgICAgIGxpbmsuY2xhc3NMaXN0LmFkZCgnYWN0aXZlJyk7XG4gICAgICB9XG4gICAgfSk7XG4gIH1cblxuICB3aW5kb3cuYWRkRXZlbnRMaXN0ZW5lcignc2Nyb2xsJywgc2V0QWN0aXZlKTtcbiAgc2V0QWN0aXZlKCk7XG59KTtcblxud2luZG93LnRvZ2dsZUF2YXRhck1lbnUgPSBmdW5jdGlvbigpe1xuICBjb25zdCBtZW51ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2F2YXRhci1tZW51Jyk7XG4gIG1lbnUuY2xhc3NMaXN0LnRvZ2dsZSgnb3BlbicpO1xufTtcbndpbmRvdy5zaG93U2VjdGlvbiA9IGZ1bmN0aW9uKHNlY3Rpb24pe1xuICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuZGItbmF2LWl0ZW0nKS5mb3JFYWNoKGkgPT4gaS5jbGFzc0xpc3QucmVtb3ZlKCdhY3RpdmUnKSk7XG4gIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJy5kYi1zZWN0aW9uJykuZm9yRWFjaChzID0+IHMuY2xhc3NMaXN0LnJlbW92ZSgnYWN0aXZlJykpO1xuICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCdbZGF0YS1zZWN0aW9uPVwiJytzZWN0aW9uKydcIl0nKS5jbGFzc0xpc3QuYWRkKCdhY3RpdmUnKTtcbiAgZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ3NlY3Rpb24tJytzZWN0aW9uKS5jbGFzc0xpc3QuYWRkKCdhY3RpdmUnKTtcbn07XG4vLyBGZXJtZXIgbGUgbWVudSBhdmF0YXIgZW4gY2xpcXVhbnQgYWlsbGV1cnNcbmRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgZnVuY3Rpb24oZSl7XG4gIGlmKCFlLnRhcmdldC5jbG9zZXN0KCcuZGItYXZhdGFyLXdyYXAnKSl7XG4gICAgY29uc3QgbWVudSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdhdmF0YXItbWVudScpO1xuICAgIGlmKG1lbnUpIG1lbnUuY2xhc3NMaXN0LnJlbW92ZSgnb3BlbicpO1xuICB9XG59KTtcblxuLy8g4pWQ4pWQ4pWQIFRvZ2dsZSBtb3QgZGUgcGFzc2Ug4pWQ4pWQ4pWQXG53aW5kb3cudG9nZ2xlUGFzc3dvcmQgPSBmdW5jdGlvbihpbnB1dElkLCBpY29uSWQpe1xuICBjb25zdCBpbnB1dCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKGlucHV0SWQpO1xuICBjb25zdCBpY29uID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoaWNvbklkKTtcbiAgaWYoIWlucHV0IHx8ICFpY29uKSByZXR1cm47XG4gIGlmKGlucHV0LnR5cGUgPT09ICdwYXNzd29yZCcpe1xuICAgIGlucHV0LnR5cGUgPSAndGV4dCc7XG4gICAgaWNvbi5pbm5lckhUTUwgPSAnPHBhdGggZD1cIk0xNy45NCAxNy45NEExMC4wNyAxMC4wNyAwIDAxMTIgMjBjLTcgMC0xMS04LTExLThhMTguNDUgMTguNDUgMCAwMTUuMDYtNS45NE05LjkgNC4yNEE5LjEyIDkuMTIgMCAwMTEyIDRjNyAwIDExIDggMTEgOGExOC41IDE4LjUgMCAwMS0yLjE2IDMuMTlNMSAxbDIyIDIyXCIvPic7XG4gIH0gZWxzZSB7XG4gICAgaW5wdXQudHlwZSA9ICdwYXNzd29yZCc7XG4gICAgaWNvbi5pbm5lckhUTUwgPSAnPHBhdGggZD1cIk0xIDEyczQtOCAxMS04IDExIDggMTEgOC00IDgtMTEgOC0xMS04LTExLTh6XCIvPjxjaXJjbGUgY3g9XCIxMlwiIGN5PVwiMTJcIiByPVwiM1wiLz4nO1xuICB9XG59O1xuXG4vLyDilZDilZDilZAgU3dpdGNoZXIgY29ubmV4aW9uIC8gaW5zY3JpcHRpb24g4pWQ4pWQ4pWQXG53aW5kb3cuc3dpdGNoQXV0aCA9IGZ1bmN0aW9uKG1vZGUpe1xuICBjb25zdCBmb3JtQ29ubmV4aW9uID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2Zvcm0tY29ubmV4aW9uJyk7XG4gIGNvbnN0IGZvcm1JbnNjcmlwdGlvbiA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdmb3JtLWluc2NyaXB0aW9uJyk7XG4gIGNvbnN0IHRpdGxlID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2F1dGgtdGl0bGUnKTtcbiAgY29uc3Qgc3VidGl0bGUgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnYXV0aC1zdWJ0aXRsZScpO1xuICBjb25zdCBlcnJvciA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdtY2YtZXJyb3InKTtcbiAgaWYoZXJyb3IpIGVycm9yLnN0eWxlLmRpc3BsYXkgPSAnbm9uZSc7XG4gIGlmKG1vZGUgPT09ICdpbnNjcmlwdGlvbicpe1xuICAgIGZvcm1Db25uZXhpb24uc3R5bGUuZGlzcGxheSA9ICdub25lJztcbiAgICBmb3JtSW5zY3JpcHRpb24uc3R5bGUuZGlzcGxheSA9ICdmbGV4JztcbiAgICB0aXRsZS50ZXh0Q29udGVudCA9ICdDcsOpZXIgdW4gY29tcHRlJztcbiAgICBzdWJ0aXRsZS50ZXh0Q29udGVudCA9ICdSZWpvaWduZXogTm91ciBEaWNrbyBBY2FkZW15JztcbiAgfSBlbHNlIHtcbiAgICBmb3JtSW5zY3JpcHRpb24uc3R5bGUuZGlzcGxheSA9ICdub25lJztcbiAgICBmb3JtQ29ubmV4aW9uLnN0eWxlLmRpc3BsYXkgPSAnZmxleCc7XG4gICAgdGl0bGUudGV4dENvbnRlbnQgPSAnQ29ubmV4aW9uJztcbiAgICBzdWJ0aXRsZS50ZXh0Q29udGVudCA9ICdBY2PDqWRleiDDoCB2b3RyZSBlc3BhY2UgcGVyc29ubmVsJztcbiAgfVxufTtcblxuLy8g4pWQ4pWQ4pWQIFbDqXJpZmljYXRpb24gbW90cyBkZSBwYXNzZSDilZDilZDilZBcbndpbmRvdy5jaGVja1Bhc3N3b3JkcyA9IGZ1bmN0aW9uKCl7XG4gIGNvbnN0IHB3ZCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdtY2YtcmVnLXBhc3N3b3JkJykudmFsdWU7XG4gIGNvbnN0IGNvbmZpcm0gPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnbWNmLXJlZy1jb25maXJtJykudmFsdWU7XG4gIGNvbnN0IGVycm9yID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ21jZi1lcnJvcicpO1xuICBpZihwd2QubGVuZ3RoIDwgOCl7XG4gICAgZXJyb3IudGV4dENvbnRlbnQgPSAnTGUgbW90IGRlIHBhc3NlIGRvaXQgY29udGVuaXIgYXUgbW9pbnMgOCBjYXJhY3TDqHJlcy4nO1xuICAgIGVycm9yLnN0eWxlLmRpc3BsYXkgPSAnYmxvY2snO1xuICAgIHJldHVybjtcbiAgfVxuICBpZihwd2QgIT09IGNvbmZpcm0pe1xuICAgIGVycm9yLnRleHRDb250ZW50ID0gJ0xlcyBtb3RzIGRlIHBhc3NlIG5lIGNvcnJlc3BvbmRlbnQgcGFzLic7XG4gICAgZXJyb3Iuc3R5bGUuZGlzcGxheSA9ICdibG9jayc7XG4gICAgcmV0dXJuO1xuICB9XG4gIGVycm9yLnN0eWxlLmRpc3BsYXkgPSAnbm9uZSc7XG4gIC8vIFRvbiBkZXYgYnJhbmNoZXJhIGljaSBsJ2FwcGVsIEFQSSBwb3VyIGNyw6llciBsZSBjb21wdGVcbiAgYWxlcnQoJ0NvbXB0ZSBjcsOpw6kgYXZlYyBzdWNjw6hzICEgVm90cmUgZGV2IGJyYW5jaGVyYSBjZXR0ZSBhY3Rpb24uJyk7XG59O1xuXG4vLyDilZDilZDilZAgQXZhdGFyIG1lbnUg4pWQ4pWQ4pWQXG53aW5kb3cudG9nZ2xlQXZhdGFyTWVudSA9IGZ1bmN0aW9uKCl7XG4gIGNvbnN0IG1lbnUgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnYXZhdGFyLW1lbnUnKTtcbiAgaWYobWVudSkgbWVudS5jbGFzc0xpc3QudG9nZ2xlKCdvcGVuJyk7XG59O1xuXG5kb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIGZ1bmN0aW9uKGUpe1xuICBpZighZS50YXJnZXQuY2xvc2VzdCgnLmRiLWF2YXRhci13cmFwJykgJiYgIWUudGFyZ2V0LmNsb3Nlc3QoJy50b3BiYXItYnRucycpKXtcbiAgICBjb25zdCBtZW51ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2F2YXRhci1tZW51Jyk7XG4gICAgaWYobWVudSkgbWVudS5jbGFzc0xpc3QucmVtb3ZlKCdvcGVuJyk7XG4gIH1cbn0pO1xuXG4vLyDilZDilZDilZAgUG9wdXAgbGFuY2VtZW50IOKVkOKVkOKVkFxud2luZG93LmNsb3NlTGF1bmNoUG9wdXAgPSBmdW5jdGlvbigpe1xuICBjb25zdCBwb3B1cCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdsYXVuY2gtcG9wdXAnKTtcbiAgaWYocG9wdXApe1xuICAgIHBvcHVwLnN0eWxlLm9wYWNpdHkgPSAnMCc7XG4gICAgcG9wdXAuc3R5bGUudHJhbnNpdGlvbiA9ICdvcGFjaXR5IC4zcyc7XG4gICAgc2V0VGltZW91dCgoKSA9PiBwb3B1cC5zdHlsZS5kaXNwbGF5ID0gJ25vbmUnLCAzMDApO1xuICAgIGxvY2FsU3RvcmFnZS5zZXRJdGVtKCduZGEtbGF1bmNoLXNlZW4nLCAnMScpO1xuICB9XG59O1xuXG4vLyBBZmZpY2hlciBsYSBwb3B1cCBzZXVsZW1lbnQgc2kgcGFzIGTDqWrDoCB2dWVcbmRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoJ0RPTUNvbnRlbnRMb2FkZWQnLCBmdW5jdGlvbigpe1xuICBjb25zdCBwb3B1cCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdsYXVuY2gtcG9wdXAnKTtcbiAgaWYocG9wdXAgJiYgbG9jYWxTdG9yYWdlLmdldEl0ZW0oJ25kYS1sYXVuY2gtc2VlbicpKXtcbiAgICBwb3B1cC5zdHlsZS5kaXNwbGF5ID0gJ25vbmUnO1xuICB9XG59KTtcblxuLy8g4pWQ4pWQ4pWQIENUQSBmbG90dGFudCDigJQgYXBwYXJhw650IGFwcsOocyBsZSBoZXJvIOKVkOKVkOKVkFxud2luZG93LmFkZEV2ZW50TGlzdGVuZXIoJ3Njcm9sbCcsIGZ1bmN0aW9uKCl7XG4gIGNvbnN0IGN0YSA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5mbG9hdGluZy1jdGEnKTtcbiAgY29uc3QgaGVybyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5uZGEtaGVybycpO1xuICBpZighY3RhIHx8ICFoZXJvKSByZXR1cm47XG4gIGlmKHdpbmRvdy5zY3JvbGxZID4gaGVyby5vZmZzZXRIZWlnaHQpe1xuICAgIGN0YS5jbGFzc0xpc3QuYWRkKCd2aXNpYmxlJyk7XG4gIH0gZWxzZSB7XG4gICAgY3RhLmNsYXNzTGlzdC5yZW1vdmUoJ3Zpc2libGUnKTtcbiAgfVxufSk7XG5cbi8vIOKVkOKVkOKVkCBBdXRvLWhpZGUgd2VsY29tZSB0b2FzdCDilZDilZDilZBcbmRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoJ0RPTUNvbnRlbnRMb2FkZWQnLCBmdW5jdGlvbigpe1xuICBjb25zdCB0b2FzdCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCd3ZWxjb21lLXRvYXN0Jyk7XG4gIGlmKHRvYXN0KXtcbiAgICBzZXRUaW1lb3V0KGZ1bmN0aW9uKCl7XG4gICAgICB0b2FzdC5zdHlsZS5kaXNwbGF5ID0gJ25vbmUnO1xuICAgIH0sIDQwMDApO1xuICB9XG59KTtcbiIsIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpblxuZXhwb3J0IHt9OyJdLCJuYW1lcyI6W10sInNvdXJjZVJvb3QiOiIifQ==