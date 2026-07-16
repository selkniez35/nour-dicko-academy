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



function openModal(id) {
  const modal = document.getElementById(id);
  if (modal) {
    modal.style.display = 'flex';
  }
}
function closeModal(id) {
  const modal = document.getElementById(id);
  if (modal) {
    modal.style.display = 'none';
  }
}
function togglePassword() {
  const pwd = document.getElementById('mcf-password');
  if (pwd) {
    pwd.type = pwd.type === 'password' ? 'text' : 'password';
  }
}
document.addEventListener('DOMContentLoaded', function () {
  if (window.location.hash === '#modal-connexion') {
    openModal('modal-connexion');
  }
});
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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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Q0YsQ0FBQyxDQUFDLEM7Ozs7Ozs7Ozs7O0FDdk9GIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vYXNzZXRzL2FwcC5qcyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvc3R5bGVzL2FwcC5jc3M/M2ZiYSJdLCJzb3VyY2VzQ29udGVudCI6WyJpbXBvcnQgJy4vc3R5bGVzL2FwcC5jc3MnO1xuXG5mdW5jdGlvbiBvcGVuTW9kYWwoaWQpIHtcbiAgICBjb25zdCBtb2RhbCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKGlkKTtcbiAgICBpZiAobW9kYWwpIHtcbiAgICAgICAgbW9kYWwuc3R5bGUuZGlzcGxheSA9ICdmbGV4JztcbiAgICB9XG59XG5mdW5jdGlvbiBjbG9zZU1vZGFsKGlkKSB7XG4gICAgY29uc3QgbW9kYWwgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZChpZCk7XG4gICAgaWYgKG1vZGFsKSB7XG4gICAgICAgIG1vZGFsLnN0eWxlLmRpc3BsYXkgPSAnbm9uZSc7XG4gICAgfVxufVxuZnVuY3Rpb24gdG9nZ2xlUGFzc3dvcmQoKSB7XG4gICAgY29uc3QgcHdkID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ21jZi1wYXNzd29yZCcpO1xuICAgIGlmIChwd2QpIHtcbiAgICAgICAgcHdkLnR5cGUgPSBwd2QudHlwZSA9PT0gJ3Bhc3N3b3JkJyA/ICd0ZXh0JyA6ICdwYXNzd29yZCc7XG4gICAgfVxufVxuZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcignRE9NQ29udGVudExvYWRlZCcsIGZ1bmN0aW9uICgpIHtcbiAgICBpZiAod2luZG93LmxvY2F0aW9uLmhhc2ggPT09ICcjbW9kYWwtY29ubmV4aW9uJykge1xuICAgICAgICBvcGVuTW9kYWwoJ21vZGFsLWNvbm5leGlvbicpO1xuICAgIH1cbn0pO1xuXG5kb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdET01Db250ZW50TG9hZGVkJywgKCkgPT4ge1xuICAgIGNvbnN0IHJlZHVjZWQgPSB3aW5kb3cubWF0Y2hNZWRpYSgnKHByZWZlcnMtcmVkdWNlZC1tb3Rpb246IHJlZHVjZSknKS5tYXRjaGVzO1xuICAgIGNvbnN0IGVscyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJy5yZXZlYWwnKTtcblxuICAgIGlmIChyZWR1Y2VkIHx8ICEoJ0ludGVyc2VjdGlvbk9ic2VydmVyJyBpbiB3aW5kb3cpKSB7XG4gICAgICAgIGVscy5mb3JFYWNoKChlbCkgPT4gZWwuY2xhc3NMaXN0LmFkZCgnaW4nKSk7XG4gICAgICAgIHJldHVybjtcbiAgICB9XG5cbiAgICBjb25zdCBpbyA9IG5ldyBJbnRlcnNlY3Rpb25PYnNlcnZlcigoZW50cmllcykgPT4ge1xuICAgICAgICBlbnRyaWVzLmZvckVhY2goKGVudHJ5KSA9PiB7XG4gICAgICAgICAgICBpZiAoZW50cnkuaXNJbnRlcnNlY3RpbmcpIHtcbiAgICAgICAgICAgICAgICBlbnRyeS50YXJnZXQuY2xhc3NMaXN0LmFkZCgnaW4nKTtcbiAgICAgICAgICAgICAgICBpby51bm9ic2VydmUoZW50cnkudGFyZ2V0KTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSk7XG4gICAgfSwgeyB0aHJlc2hvbGQ6IDAuMTIgfSk7XG5cbiAgICBlbHMuZm9yRWFjaCgoZWwpID0+IGlvLm9ic2VydmUoZWwpKTtcbn0pO1xuLy8g4pWQ4pWQ4pWQIE1vZGFscyBkZXMgY291cnMg4pWQ4pWQ4pWQXG53aW5kb3cub3Blbk1vZGFsID0gZnVuY3Rpb24oaWQpe1xuICBjb25zdCBtb2RhbCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKGlkKTtcbiAgaWYobW9kYWwpe1xuICAgIG1vZGFsLmNsYXNzTGlzdC5hZGQoJ29wZW4nKTtcbiAgICBkb2N1bWVudC5ib2R5LnN0eWxlLm92ZXJmbG93ID0gJ2hpZGRlbic7XG4gIH1cbn07XG5cbndpbmRvdy5jbG9zZU1vZGFsID0gZnVuY3Rpb24oaWQpe1xuICBjb25zdCBtb2RhbCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKGlkKTtcbiAgaWYobW9kYWwpe1xuICAgIG1vZGFsLmNsYXNzTGlzdC5yZW1vdmUoJ29wZW4nKTtcbiAgICBkb2N1bWVudC5ib2R5LnN0eWxlLm92ZXJmbG93ID0gJyc7XG4gIH1cbn07XG5cbi8vIEZlcm1lciBlbiBjbGlxdWFudCBzdXIgbGUgZm9uZCBzb21icmUgKGhvcnMgZGUgbGEgYm/DrnRlKVxuZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCBmdW5jdGlvbihlKXtcbiAgaWYoZS50YXJnZXQuY2xhc3NMaXN0LmNvbnRhaW5zKCdtb2RhbC1vdmVybGF5Jykpe1xuICAgIGUudGFyZ2V0LmNsYXNzTGlzdC5yZW1vdmUoJ29wZW4nKTtcbiAgICBkb2N1bWVudC5ib2R5LnN0eWxlLm92ZXJmbG93ID0gJyc7XG4gIH1cbn0pO1xuXG4vLyBGZXJtZXIgYXZlYyBsYSB0b3VjaGUgw4ljaGFwXG5kb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdrZXlkb3duJywgZnVuY3Rpb24oZSl7XG4gIGlmKGUua2V5ID09PSAnRXNjYXBlJyl7XG4gICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLm1vZGFsLW92ZXJsYXkub3BlbicpLmZvckVhY2goZnVuY3Rpb24obSl7XG4gICAgICBtLmNsYXNzTGlzdC5yZW1vdmUoJ29wZW4nKTtcbiAgICB9KTtcbiAgICBkb2N1bWVudC5ib2R5LnN0eWxlLm92ZXJmbG93ID0gJyc7XG4gIH1cbn0pO1xuLy8g4pWQ4pWQ4pWQIE5hdmJhciBhY3RpdmUgbGluayBhdSBzY3JvbGwg4pWQ4pWQ4pWQXG5kb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdET01Db250ZW50TG9hZGVkJywgZnVuY3Rpb24oKXtcbiAgY29uc3Qgc2VjdGlvbnMgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCdzZWN0aW9uW2lkXSwgZGl2W2lkXScpO1xuICBjb25zdCBuYXZMaW5rcyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJy50b3BiYXItbWVudSBhJyk7XG5cbiAgZnVuY3Rpb24gc2V0QWN0aXZlKCl7XG4gICAgbGV0IGN1cnJlbnQgPSAnJztcbiAgICBzZWN0aW9ucy5mb3JFYWNoKHNlY3Rpb24gPT4ge1xuICAgICAgY29uc3Qgc2VjdGlvblRvcCA9IHNlY3Rpb24ub2Zmc2V0VG9wIC0gMTAwO1xuICAgICAgaWYod2luZG93LnNjcm9sbFkgPj0gc2VjdGlvblRvcCl7XG4gICAgICAgIGN1cnJlbnQgPSBzZWN0aW9uLmdldEF0dHJpYnV0ZSgnaWQnKTtcbiAgICAgIH1cbiAgICB9KTtcbiAgICBuYXZMaW5rcy5mb3JFYWNoKGxpbmsgPT4ge1xuICAgICAgbGluay5jbGFzc0xpc3QucmVtb3ZlKCdhY3RpdmUnKTtcbiAgICAgIGNvbnN0IGhyZWYgPSBsaW5rLmdldEF0dHJpYnV0ZSgnaHJlZicpLnJlcGxhY2UoJyMnLCcnKTtcbiAgICAgIGlmKGhyZWYgPT09IGN1cnJlbnQpe1xuICAgICAgICBsaW5rLmNsYXNzTGlzdC5hZGQoJ2FjdGl2ZScpO1xuICAgICAgfVxuICAgIH0pO1xuICB9XG5cbiAgd2luZG93LmFkZEV2ZW50TGlzdGVuZXIoJ3Njcm9sbCcsIHNldEFjdGl2ZSk7XG4gIHNldEFjdGl2ZSgpO1xufSk7XG5cbndpbmRvdy50b2dnbGVBdmF0YXJNZW51ID0gZnVuY3Rpb24oKXtcbiAgY29uc3QgbWVudSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdhdmF0YXItbWVudScpO1xuICBtZW51LmNsYXNzTGlzdC50b2dnbGUoJ29wZW4nKTtcbn07XG53aW5kb3cuc2hvd1NlY3Rpb24gPSBmdW5jdGlvbihzZWN0aW9uKXtcbiAgZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLmRiLW5hdi1pdGVtJykuZm9yRWFjaChpID0+IGkuY2xhc3NMaXN0LnJlbW92ZSgnYWN0aXZlJykpO1xuICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuZGItc2VjdGlvbicpLmZvckVhY2gocyA9PiBzLmNsYXNzTGlzdC5yZW1vdmUoJ2FjdGl2ZScpKTtcbiAgZG9jdW1lbnQucXVlcnlTZWxlY3RvcignW2RhdGEtc2VjdGlvbj1cIicrc2VjdGlvbisnXCJdJykuY2xhc3NMaXN0LmFkZCgnYWN0aXZlJyk7XG4gIGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdzZWN0aW9uLScrc2VjdGlvbikuY2xhc3NMaXN0LmFkZCgnYWN0aXZlJyk7XG59O1xuLy8gRmVybWVyIGxlIG1lbnUgYXZhdGFyIGVuIGNsaXF1YW50IGFpbGxldXJzXG5kb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIGZ1bmN0aW9uKGUpe1xuICBpZighZS50YXJnZXQuY2xvc2VzdCgnLmRiLWF2YXRhci13cmFwJykpe1xuICAgIGNvbnN0IG1lbnUgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnYXZhdGFyLW1lbnUnKTtcbiAgICBpZihtZW51KSBtZW51LmNsYXNzTGlzdC5yZW1vdmUoJ29wZW4nKTtcbiAgfVxufSk7XG5cbi8vIOKVkOKVkOKVkCBUb2dnbGUgbW90IGRlIHBhc3NlIOKVkOKVkOKVkFxud2luZG93LnRvZ2dsZVBhc3N3b3JkID0gZnVuY3Rpb24oaW5wdXRJZCwgaWNvbklkKXtcbiAgY29uc3QgaW5wdXQgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZChpbnB1dElkKTtcbiAgY29uc3QgaWNvbiA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKGljb25JZCk7XG4gIGlmKCFpbnB1dCB8fCAhaWNvbikgcmV0dXJuO1xuICBpZihpbnB1dC50eXBlID09PSAncGFzc3dvcmQnKXtcbiAgICBpbnB1dC50eXBlID0gJ3RleHQnO1xuICAgIGljb24uaW5uZXJIVE1MID0gJzxwYXRoIGQ9XCJNMTcuOTQgMTcuOTRBMTAuMDcgMTAuMDcgMCAwMTEyIDIwYy03IDAtMTEtOC0xMS04YTE4LjQ1IDE4LjQ1IDAgMDE1LjA2LTUuOTRNOS45IDQuMjRBOS4xMiA5LjEyIDAgMDExMiA0YzcgMCAxMSA4IDExIDhhMTguNSAxOC41IDAgMDEtMi4xNiAzLjE5TTEgMWwyMiAyMlwiLz4nO1xuICB9IGVsc2Uge1xuICAgIGlucHV0LnR5cGUgPSAncGFzc3dvcmQnO1xuICAgIGljb24uaW5uZXJIVE1MID0gJzxwYXRoIGQ9XCJNMSAxMnM0LTggMTEtOCAxMSA4IDExIDgtNCA4LTExIDgtMTEtOC0xMS04elwiLz48Y2lyY2xlIGN4PVwiMTJcIiBjeT1cIjEyXCIgcj1cIjNcIi8+JztcbiAgfVxufTtcblxuLy8g4pWQ4pWQ4pWQIFN3aXRjaGVyIGNvbm5leGlvbiAvIGluc2NyaXB0aW9uIOKVkOKVkOKVkFxud2luZG93LnN3aXRjaEF1dGggPSBmdW5jdGlvbihtb2RlKXtcbiAgY29uc3QgZm9ybUNvbm5leGlvbiA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdmb3JtLWNvbm5leGlvbicpO1xuICBjb25zdCBmb3JtSW5zY3JpcHRpb24gPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnZm9ybS1pbnNjcmlwdGlvbicpO1xuICBjb25zdCB0aXRsZSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdhdXRoLXRpdGxlJyk7XG4gIGNvbnN0IHN1YnRpdGxlID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2F1dGgtc3VidGl0bGUnKTtcbiAgY29uc3QgZXJyb3IgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnbWNmLWVycm9yJyk7XG4gIGlmKGVycm9yKSBlcnJvci5zdHlsZS5kaXNwbGF5ID0gJ25vbmUnO1xuICBpZihtb2RlID09PSAnaW5zY3JpcHRpb24nKXtcbiAgICBmb3JtQ29ubmV4aW9uLnN0eWxlLmRpc3BsYXkgPSAnbm9uZSc7XG4gICAgZm9ybUluc2NyaXB0aW9uLnN0eWxlLmRpc3BsYXkgPSAnZmxleCc7XG4gICAgdGl0bGUudGV4dENvbnRlbnQgPSAnQ3LDqWVyIHVuIGNvbXB0ZSc7XG4gICAgc3VidGl0bGUudGV4dENvbnRlbnQgPSAnUmVqb2lnbmV6IE5vdXIgRGlja28gQWNhZGVteSc7XG4gIH0gZWxzZSB7XG4gICAgZm9ybUluc2NyaXB0aW9uLnN0eWxlLmRpc3BsYXkgPSAnbm9uZSc7XG4gICAgZm9ybUNvbm5leGlvbi5zdHlsZS5kaXNwbGF5ID0gJ2ZsZXgnO1xuICAgIHRpdGxlLnRleHRDb250ZW50ID0gJ0Nvbm5leGlvbic7XG4gICAgc3VidGl0bGUudGV4dENvbnRlbnQgPSAnQWNjw6lkZXogw6Agdm90cmUgZXNwYWNlIHBlcnNvbm5lbCc7XG4gIH1cbn07XG5cbi8vIOKVkOKVkOKVkCBWw6lyaWZpY2F0aW9uIG1vdHMgZGUgcGFzc2Ug4pWQ4pWQ4pWQXG53aW5kb3cuY2hlY2tQYXNzd29yZHMgPSBmdW5jdGlvbigpe1xuICBjb25zdCBwd2QgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnbWNmLXJlZy1wYXNzd29yZCcpLnZhbHVlO1xuICBjb25zdCBjb25maXJtID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ21jZi1yZWctY29uZmlybScpLnZhbHVlO1xuICBjb25zdCBlcnJvciA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdtY2YtZXJyb3InKTtcbiAgaWYocHdkLmxlbmd0aCA8IDgpe1xuICAgIGVycm9yLnRleHRDb250ZW50ID0gJ0xlIG1vdCBkZSBwYXNzZSBkb2l0IGNvbnRlbmlyIGF1IG1vaW5zIDggY2FyYWN0w6hyZXMuJztcbiAgICBlcnJvci5zdHlsZS5kaXNwbGF5ID0gJ2Jsb2NrJztcbiAgICByZXR1cm47XG4gIH1cbiAgaWYocHdkICE9PSBjb25maXJtKXtcbiAgICBlcnJvci50ZXh0Q29udGVudCA9ICdMZXMgbW90cyBkZSBwYXNzZSBuZSBjb3JyZXNwb25kZW50IHBhcy4nO1xuICAgIGVycm9yLnN0eWxlLmRpc3BsYXkgPSAnYmxvY2snO1xuICAgIHJldHVybjtcbiAgfVxuICBlcnJvci5zdHlsZS5kaXNwbGF5ID0gJ25vbmUnO1xuICAvLyBUb24gZGV2IGJyYW5jaGVyYSBpY2kgbCdhcHBlbCBBUEkgcG91ciBjcsOpZXIgbGUgY29tcHRlXG4gIGFsZXJ0KCdDb21wdGUgY3LDqcOpIGF2ZWMgc3VjY8OocyAhIFZvdHJlIGRldiBicmFuY2hlcmEgY2V0dGUgYWN0aW9uLicpO1xufTtcblxuLy8g4pWQ4pWQ4pWQIEF2YXRhciBtZW51IOKVkOKVkOKVkFxud2luZG93LnRvZ2dsZUF2YXRhck1lbnUgPSBmdW5jdGlvbigpe1xuICBjb25zdCBtZW51ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2F2YXRhci1tZW51Jyk7XG4gIGlmKG1lbnUpIG1lbnUuY2xhc3NMaXN0LnRvZ2dsZSgnb3BlbicpO1xufTtcblxuZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCBmdW5jdGlvbihlKXtcbiAgaWYoIWUudGFyZ2V0LmNsb3Nlc3QoJy5kYi1hdmF0YXItd3JhcCcpICYmICFlLnRhcmdldC5jbG9zZXN0KCcudG9wYmFyLWJ0bnMnKSl7XG4gICAgY29uc3QgbWVudSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdhdmF0YXItbWVudScpO1xuICAgIGlmKG1lbnUpIG1lbnUuY2xhc3NMaXN0LnJlbW92ZSgnb3BlbicpO1xuICB9XG59KTtcblxuLy8g4pWQ4pWQ4pWQIFBvcHVwIGxhbmNlbWVudCDilZDilZDilZBcbndpbmRvdy5jbG9zZUxhdW5jaFBvcHVwID0gZnVuY3Rpb24oKXtcbiAgY29uc3QgcG9wdXAgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnbGF1bmNoLXBvcHVwJyk7XG4gIGlmKHBvcHVwKXtcbiAgICBwb3B1cC5zdHlsZS5vcGFjaXR5ID0gJzAnO1xuICAgIHBvcHVwLnN0eWxlLnRyYW5zaXRpb24gPSAnb3BhY2l0eSAuM3MnO1xuICAgIHNldFRpbWVvdXQoKCkgPT4gcG9wdXAuc3R5bGUuZGlzcGxheSA9ICdub25lJywgMzAwKTtcbiAgICBsb2NhbFN0b3JhZ2Uuc2V0SXRlbSgnbmRhLWxhdW5jaC1zZWVuJywgJzEnKTtcbiAgfVxufTtcblxuLy8gQWZmaWNoZXIgbGEgcG9wdXAgc2V1bGVtZW50IHNpIHBhcyBkw6lqw6AgdnVlXG5kb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdET01Db250ZW50TG9hZGVkJywgZnVuY3Rpb24oKXtcbiAgY29uc3QgcG9wdXAgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnbGF1bmNoLXBvcHVwJyk7XG4gIGlmKHBvcHVwICYmIGxvY2FsU3RvcmFnZS5nZXRJdGVtKCduZGEtbGF1bmNoLXNlZW4nKSl7XG4gICAgcG9wdXAuc3R5bGUuZGlzcGxheSA9ICdub25lJztcbiAgfVxufSk7XG5cbi8vIOKVkOKVkOKVkCBDVEEgZmxvdHRhbnQg4oCUIGFwcGFyYcOudCBhcHLDqHMgbGUgaGVybyDilZDilZDilZBcbndpbmRvdy5hZGRFdmVudExpc3RlbmVyKCdzY3JvbGwnLCBmdW5jdGlvbigpe1xuICBjb25zdCBjdGEgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcuZmxvYXRpbmctY3RhJyk7XG4gIGNvbnN0IGhlcm8gPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcubmRhLWhlcm8nKTtcbiAgaWYoIWN0YSB8fCAhaGVybykgcmV0dXJuO1xuICBpZih3aW5kb3cuc2Nyb2xsWSA+IGhlcm8ub2Zmc2V0SGVpZ2h0KXtcbiAgICBjdGEuY2xhc3NMaXN0LmFkZCgndmlzaWJsZScpO1xuICB9IGVsc2Uge1xuICAgIGN0YS5jbGFzc0xpc3QucmVtb3ZlKCd2aXNpYmxlJyk7XG4gIH1cbn0pO1xuXG4vLyDilZDilZDilZAgQXV0by1oaWRlIHdlbGNvbWUgdG9hc3Qg4pWQ4pWQ4pWQXG5kb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdET01Db250ZW50TG9hZGVkJywgZnVuY3Rpb24oKXtcbiAgY29uc3QgdG9hc3QgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnd2VsY29tZS10b2FzdCcpO1xuICBpZih0b2FzdCl7XG4gICAgc2V0VGltZW91dChmdW5jdGlvbigpe1xuICAgICAgdG9hc3Quc3R5bGUuZGlzcGxheSA9ICdub25lJztcbiAgICB9LCA0MDAwKTtcbiAgfVxufSk7XG4iLCIvLyBleHRyYWN0ZWQgYnkgbWluaS1jc3MtZXh0cmFjdC1wbHVnaW5cbmV4cG9ydCB7fTsiXSwibmFtZXMiOltdLCJzb3VyY2VSb290IjoiIn0=