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

// ═══ Avatar du header public (étudiant connecté) ═══
window.toggleHeaderAvatarMenu = function () {
  const menu = document.getElementById('header-avatar-menu');
  if (menu) menu.classList.toggle('open');
};
document.addEventListener('click', function (e) {
  if (!e.target.closest('.topbar-avatar-wrap')) {
    const menu = document.getElementById('header-avatar-menu');
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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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QUksQ0FBQyxJQUFJLEVBQUU7RUFDbEIsSUFBRyxNQUFNLENBQUMsT0FBTyxHQUFHLElBQUksQ0FBQyxZQUFZLEVBQUM7SUFDcEMsR0FBRyxDQUFDLFNBQVMsQ0FBQyxHQUFHLENBQUMsU0FBUyxDQUFDO0VBQzlCLENBQUMsTUFBTTtJQUNMLEdBQUcsQ0FBQyxTQUFTLENBQUMsTUFBTSxDQUFDLFNBQVMsQ0FBQztFQUNqQztBQUNGLENBQUMsQ0FBQzs7QUFFRjtBQUNBLFFBQVEsQ0FBQyxnQkFBZ0IsQ0FBQyxrQkFBa0IsRUFBRSxZQUFVO0VBQ3RELE1BQU0sS0FBSyxHQUFHLFFBQVEsQ0FBQyxjQUFjLENBQUMsZUFBZSxDQUFDO0VBQ3RELElBQUcsS0FBSyxFQUFDO0lBQ1AsVUFBVSxDQUFDLFlBQVU7TUFDbkIsS0FBSyxDQUFDLEtBQUssQ0FBQyxPQUFPLEdBQUcsTUFBTTtJQUM5QixDQUFDLEVBQUUsSUFBSSxDQUFDO0VBQ1Y7QUFDRixDQUFDLENBQUMsQzs7Ozs7Ozs7Ozs7QUNwUEYiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvYXBwLmpzIiwid2VicGFjazovLy8uL2Fzc2V0cy9zdHlsZXMvYXBwLmNzcz8zZmJhIl0sInNvdXJjZXNDb250ZW50IjpbImltcG9ydCAnLi9zdHlsZXMvYXBwLmNzcyc7XG5cbmZ1bmN0aW9uIG9wZW5Nb2RhbChpZCkge1xuICAgIGNvbnN0IG1vZGFsID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoaWQpO1xuICAgIGlmIChtb2RhbCkge1xuICAgICAgICBtb2RhbC5zdHlsZS5kaXNwbGF5ID0gJ2ZsZXgnO1xuICAgIH1cbn1cbmZ1bmN0aW9uIGNsb3NlTW9kYWwoaWQpIHtcbiAgICBjb25zdCBtb2RhbCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKGlkKTtcbiAgICBpZiAobW9kYWwpIHtcbiAgICAgICAgbW9kYWwuc3R5bGUuZGlzcGxheSA9ICdub25lJztcbiAgICB9XG59XG5mdW5jdGlvbiB0b2dnbGVQYXNzd29yZCgpIHtcbiAgICBjb25zdCBwd2QgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnbWNmLXBhc3N3b3JkJyk7XG4gICAgaWYgKHB3ZCkge1xuICAgICAgICBwd2QudHlwZSA9IHB3ZC50eXBlID09PSAncGFzc3dvcmQnID8gJ3RleHQnIDogJ3Bhc3N3b3JkJztcbiAgICB9XG59XG5kb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdET01Db250ZW50TG9hZGVkJywgZnVuY3Rpb24gKCkge1xuICAgIGlmICh3aW5kb3cubG9jYXRpb24uaGFzaCA9PT0gJyNtb2RhbC1jb25uZXhpb24nKSB7XG4gICAgICAgIG9wZW5Nb2RhbCgnbW9kYWwtY29ubmV4aW9uJyk7XG4gICAgfVxufSk7XG5cbmRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoJ0RPTUNvbnRlbnRMb2FkZWQnLCAoKSA9PiB7XG4gICAgY29uc3QgcmVkdWNlZCA9IHdpbmRvdy5tYXRjaE1lZGlhKCcocHJlZmVycy1yZWR1Y2VkLW1vdGlvbjogcmVkdWNlKScpLm1hdGNoZXM7XG4gICAgY29uc3QgZWxzID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLnJldmVhbCcpO1xuXG4gICAgaWYgKHJlZHVjZWQgfHwgISgnSW50ZXJzZWN0aW9uT2JzZXJ2ZXInIGluIHdpbmRvdykpIHtcbiAgICAgICAgZWxzLmZvckVhY2goKGVsKSA9PiBlbC5jbGFzc0xpc3QuYWRkKCdpbicpKTtcbiAgICAgICAgcmV0dXJuO1xuICAgIH1cblxuICAgIGNvbnN0IGlvID0gbmV3IEludGVyc2VjdGlvbk9ic2VydmVyKChlbnRyaWVzKSA9PiB7XG4gICAgICAgIGVudHJpZXMuZm9yRWFjaCgoZW50cnkpID0+IHtcbiAgICAgICAgICAgIGlmIChlbnRyeS5pc0ludGVyc2VjdGluZykge1xuICAgICAgICAgICAgICAgIGVudHJ5LnRhcmdldC5jbGFzc0xpc3QuYWRkKCdpbicpO1xuICAgICAgICAgICAgICAgIGlvLnVub2JzZXJ2ZShlbnRyeS50YXJnZXQpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcbiAgICB9LCB7IHRocmVzaG9sZDogMC4xMiB9KTtcblxuICAgIGVscy5mb3JFYWNoKChlbCkgPT4gaW8ub2JzZXJ2ZShlbCkpO1xufSk7XG4vLyDilZDilZDilZAgTW9kYWxzIGRlcyBjb3VycyDilZDilZDilZBcbndpbmRvdy5vcGVuTW9kYWwgPSBmdW5jdGlvbihpZCl7XG4gIGNvbnN0IG1vZGFsID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoaWQpO1xuICBpZihtb2RhbCl7XG4gICAgbW9kYWwuY2xhc3NMaXN0LmFkZCgnb3BlbicpO1xuICAgIGRvY3VtZW50LmJvZHkuc3R5bGUub3ZlcmZsb3cgPSAnaGlkZGVuJztcbiAgfVxufTtcblxud2luZG93LmNsb3NlTW9kYWwgPSBmdW5jdGlvbihpZCl7XG4gIGNvbnN0IG1vZGFsID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoaWQpO1xuICBpZihtb2RhbCl7XG4gICAgbW9kYWwuY2xhc3NMaXN0LnJlbW92ZSgnb3BlbicpO1xuICAgIGRvY3VtZW50LmJvZHkuc3R5bGUub3ZlcmZsb3cgPSAnJztcbiAgfVxufTtcblxuLy8gRmVybWVyIGVuIGNsaXF1YW50IHN1ciBsZSBmb25kIHNvbWJyZSAoaG9ycyBkZSBsYSBib8OudGUpXG5kb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIGZ1bmN0aW9uKGUpe1xuICBpZihlLnRhcmdldC5jbGFzc0xpc3QuY29udGFpbnMoJ21vZGFsLW92ZXJsYXknKSl7XG4gICAgZS50YXJnZXQuY2xhc3NMaXN0LnJlbW92ZSgnb3BlbicpO1xuICAgIGRvY3VtZW50LmJvZHkuc3R5bGUub3ZlcmZsb3cgPSAnJztcbiAgfVxufSk7XG5cbi8vIEZlcm1lciBhdmVjIGxhIHRvdWNoZSDDiWNoYXBcbmRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoJ2tleWRvd24nLCBmdW5jdGlvbihlKXtcbiAgaWYoZS5rZXkgPT09ICdFc2NhcGUnKXtcbiAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcubW9kYWwtb3ZlcmxheS5vcGVuJykuZm9yRWFjaChmdW5jdGlvbihtKXtcbiAgICAgIG0uY2xhc3NMaXN0LnJlbW92ZSgnb3BlbicpO1xuICAgIH0pO1xuICAgIGRvY3VtZW50LmJvZHkuc3R5bGUub3ZlcmZsb3cgPSAnJztcbiAgfVxufSk7XG4vLyDilZDilZDilZAgTmF2YmFyIGFjdGl2ZSBsaW5rIGF1IHNjcm9sbCDilZDilZDilZBcbmRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoJ0RPTUNvbnRlbnRMb2FkZWQnLCBmdW5jdGlvbigpe1xuICBjb25zdCBzZWN0aW9ucyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJ3NlY3Rpb25baWRdLCBkaXZbaWRdJyk7XG4gIGNvbnN0IG5hdkxpbmtzID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLnRvcGJhci1tZW51IGEnKTtcblxuICBmdW5jdGlvbiBzZXRBY3RpdmUoKXtcbiAgICBsZXQgY3VycmVudCA9ICcnO1xuICAgIHNlY3Rpb25zLmZvckVhY2goc2VjdGlvbiA9PiB7XG4gICAgICBjb25zdCBzZWN0aW9uVG9wID0gc2VjdGlvbi5vZmZzZXRUb3AgLSAxMDA7XG4gICAgICBpZih3aW5kb3cuc2Nyb2xsWSA+PSBzZWN0aW9uVG9wKXtcbiAgICAgICAgY3VycmVudCA9IHNlY3Rpb24uZ2V0QXR0cmlidXRlKCdpZCcpO1xuICAgICAgfVxuICAgIH0pO1xuICAgIG5hdkxpbmtzLmZvckVhY2gobGluayA9PiB7XG4gICAgICBsaW5rLmNsYXNzTGlzdC5yZW1vdmUoJ2FjdGl2ZScpO1xuICAgICAgY29uc3QgaHJlZiA9IGxpbmsuZ2V0QXR0cmlidXRlKCdocmVmJykucmVwbGFjZSgnIycsJycpO1xuICAgICAgaWYoaHJlZiA9PT0gY3VycmVudCl7XG4gICAgICAgIGxpbmsuY2xhc3NMaXN0LmFkZCgnYWN0aXZlJyk7XG4gICAgICB9XG4gICAgfSk7XG4gIH1cblxuICB3aW5kb3cuYWRkRXZlbnRMaXN0ZW5lcignc2Nyb2xsJywgc2V0QWN0aXZlKTtcbiAgc2V0QWN0aXZlKCk7XG59KTtcblxud2luZG93LnRvZ2dsZUF2YXRhck1lbnUgPSBmdW5jdGlvbigpe1xuICBjb25zdCBtZW51ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2F2YXRhci1tZW51Jyk7XG4gIG1lbnUuY2xhc3NMaXN0LnRvZ2dsZSgnb3BlbicpO1xufTtcbndpbmRvdy5zaG93U2VjdGlvbiA9IGZ1bmN0aW9uKHNlY3Rpb24pe1xuICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuZGItbmF2LWl0ZW0nKS5mb3JFYWNoKGkgPT4gaS5jbGFzc0xpc3QucmVtb3ZlKCdhY3RpdmUnKSk7XG4gIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJy5kYi1zZWN0aW9uJykuZm9yRWFjaChzID0+IHMuY2xhc3NMaXN0LnJlbW92ZSgnYWN0aXZlJykpO1xuICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCdbZGF0YS1zZWN0aW9uPVwiJytzZWN0aW9uKydcIl0nKS5jbGFzc0xpc3QuYWRkKCdhY3RpdmUnKTtcbiAgZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ3NlY3Rpb24tJytzZWN0aW9uKS5jbGFzc0xpc3QuYWRkKCdhY3RpdmUnKTtcbn07XG4vLyBGZXJtZXIgbGUgbWVudSBhdmF0YXIgZW4gY2xpcXVhbnQgYWlsbGV1cnNcbmRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgZnVuY3Rpb24oZSl7XG4gIGlmKCFlLnRhcmdldC5jbG9zZXN0KCcuZGItYXZhdGFyLXdyYXAnKSl7XG4gICAgY29uc3QgbWVudSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdhdmF0YXItbWVudScpO1xuICAgIGlmKG1lbnUpIG1lbnUuY2xhc3NMaXN0LnJlbW92ZSgnb3BlbicpO1xuICB9XG59KTtcblxuLy8g4pWQ4pWQ4pWQIFRvZ2dsZSBtb3QgZGUgcGFzc2Ug4pWQ4pWQ4pWQXG53aW5kb3cudG9nZ2xlUGFzc3dvcmQgPSBmdW5jdGlvbihpbnB1dElkLCBpY29uSWQpe1xuICBjb25zdCBpbnB1dCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKGlucHV0SWQpO1xuICBjb25zdCBpY29uID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoaWNvbklkKTtcbiAgaWYoIWlucHV0IHx8ICFpY29uKSByZXR1cm47XG4gIGlmKGlucHV0LnR5cGUgPT09ICdwYXNzd29yZCcpe1xuICAgIGlucHV0LnR5cGUgPSAndGV4dCc7XG4gICAgaWNvbi5pbm5lckhUTUwgPSAnPHBhdGggZD1cIk0xNy45NCAxNy45NEExMC4wNyAxMC4wNyAwIDAxMTIgMjBjLTcgMC0xMS04LTExLThhMTguNDUgMTguNDUgMCAwMTUuMDYtNS45NE05LjkgNC4yNEE5LjEyIDkuMTIgMCAwMTEyIDRjNyAwIDExIDggMTEgOGExOC41IDE4LjUgMCAwMS0yLjE2IDMuMTlNMSAxbDIyIDIyXCIvPic7XG4gIH0gZWxzZSB7XG4gICAgaW5wdXQudHlwZSA9ICdwYXNzd29yZCc7XG4gICAgaWNvbi5pbm5lckhUTUwgPSAnPHBhdGggZD1cIk0xIDEyczQtOCAxMS04IDExIDggMTEgOC00IDgtMTEgOC0xMS04LTExLTh6XCIvPjxjaXJjbGUgY3g9XCIxMlwiIGN5PVwiMTJcIiByPVwiM1wiLz4nO1xuICB9XG59O1xuXG4vLyDilZDilZDilZAgU3dpdGNoZXIgY29ubmV4aW9uIC8gaW5zY3JpcHRpb24g4pWQ4pWQ4pWQXG53aW5kb3cuc3dpdGNoQXV0aCA9IGZ1bmN0aW9uKG1vZGUpe1xuICBjb25zdCBmb3JtQ29ubmV4aW9uID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2Zvcm0tY29ubmV4aW9uJyk7XG4gIGNvbnN0IGZvcm1JbnNjcmlwdGlvbiA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdmb3JtLWluc2NyaXB0aW9uJyk7XG4gIGNvbnN0IHRpdGxlID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2F1dGgtdGl0bGUnKTtcbiAgY29uc3Qgc3VidGl0bGUgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnYXV0aC1zdWJ0aXRsZScpO1xuICBjb25zdCBlcnJvciA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdtY2YtZXJyb3InKTtcbiAgaWYoZXJyb3IpIGVycm9yLnN0eWxlLmRpc3BsYXkgPSAnbm9uZSc7XG4gIGlmKG1vZGUgPT09ICdpbnNjcmlwdGlvbicpe1xuICAgIGZvcm1Db25uZXhpb24uc3R5bGUuZGlzcGxheSA9ICdub25lJztcbiAgICBmb3JtSW5zY3JpcHRpb24uc3R5bGUuZGlzcGxheSA9ICdmbGV4JztcbiAgICB0aXRsZS50ZXh0Q29udGVudCA9ICdDcsOpZXIgdW4gY29tcHRlJztcbiAgICBzdWJ0aXRsZS50ZXh0Q29udGVudCA9ICdSZWpvaWduZXogTm91ciBEaWNrbyBBY2FkZW15JztcbiAgfSBlbHNlIHtcbiAgICBmb3JtSW5zY3JpcHRpb24uc3R5bGUuZGlzcGxheSA9ICdub25lJztcbiAgICBmb3JtQ29ubmV4aW9uLnN0eWxlLmRpc3BsYXkgPSAnZmxleCc7XG4gICAgdGl0bGUudGV4dENvbnRlbnQgPSAnQ29ubmV4aW9uJztcbiAgICBzdWJ0aXRsZS50ZXh0Q29udGVudCA9ICdBY2PDqWRleiDDoCB2b3RyZSBlc3BhY2UgcGVyc29ubmVsJztcbiAgfVxufTtcblxuLy8g4pWQ4pWQ4pWQIFbDqXJpZmljYXRpb24gbW90cyBkZSBwYXNzZSDilZDilZDilZBcbndpbmRvdy5jaGVja1Bhc3N3b3JkcyA9IGZ1bmN0aW9uKCl7XG4gIGNvbnN0IHB3ZCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdtY2YtcmVnLXBhc3N3b3JkJykudmFsdWU7XG4gIGNvbnN0IGNvbmZpcm0gPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnbWNmLXJlZy1jb25maXJtJykudmFsdWU7XG4gIGNvbnN0IGVycm9yID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ21jZi1lcnJvcicpO1xuICBpZihwd2QubGVuZ3RoIDwgOCl7XG4gICAgZXJyb3IudGV4dENvbnRlbnQgPSAnTGUgbW90IGRlIHBhc3NlIGRvaXQgY29udGVuaXIgYXUgbW9pbnMgOCBjYXJhY3TDqHJlcy4nO1xuICAgIGVycm9yLnN0eWxlLmRpc3BsYXkgPSAnYmxvY2snO1xuICAgIHJldHVybjtcbiAgfVxuICBpZihwd2QgIT09IGNvbmZpcm0pe1xuICAgIGVycm9yLnRleHRDb250ZW50ID0gJ0xlcyBtb3RzIGRlIHBhc3NlIG5lIGNvcnJlc3BvbmRlbnQgcGFzLic7XG4gICAgZXJyb3Iuc3R5bGUuZGlzcGxheSA9ICdibG9jayc7XG4gICAgcmV0dXJuO1xuICB9XG4gIGVycm9yLnN0eWxlLmRpc3BsYXkgPSAnbm9uZSc7XG4gIC8vIFRvbiBkZXYgYnJhbmNoZXJhIGljaSBsJ2FwcGVsIEFQSSBwb3VyIGNyw6llciBsZSBjb21wdGVcbiAgYWxlcnQoJ0NvbXB0ZSBjcsOpw6kgYXZlYyBzdWNjw6hzICEgVm90cmUgZGV2IGJyYW5jaGVyYSBjZXR0ZSBhY3Rpb24uJyk7XG59O1xuXG4vLyDilZDilZDilZAgQXZhdGFyIG1lbnUg4pWQ4pWQ4pWQXG53aW5kb3cudG9nZ2xlQXZhdGFyTWVudSA9IGZ1bmN0aW9uKCl7XG4gIGNvbnN0IG1lbnUgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnYXZhdGFyLW1lbnUnKTtcbiAgaWYobWVudSkgbWVudS5jbGFzc0xpc3QudG9nZ2xlKCdvcGVuJyk7XG59O1xuXG5kb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIGZ1bmN0aW9uKGUpe1xuICBpZighZS50YXJnZXQuY2xvc2VzdCgnLmRiLWF2YXRhci13cmFwJykgJiYgIWUudGFyZ2V0LmNsb3Nlc3QoJy50b3BiYXItYnRucycpKXtcbiAgICBjb25zdCBtZW51ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2F2YXRhci1tZW51Jyk7XG4gICAgaWYobWVudSkgbWVudS5jbGFzc0xpc3QucmVtb3ZlKCdvcGVuJyk7XG4gIH1cbn0pO1xuXG4vLyDilZDilZDilZAgQXZhdGFyIGR1IGhlYWRlciBwdWJsaWMgKMOpdHVkaWFudCBjb25uZWN0w6kpIOKVkOKVkOKVkFxud2luZG93LnRvZ2dsZUhlYWRlckF2YXRhck1lbnUgPSBmdW5jdGlvbigpe1xuICBjb25zdCBtZW51ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2hlYWRlci1hdmF0YXItbWVudScpO1xuICBpZihtZW51KSBtZW51LmNsYXNzTGlzdC50b2dnbGUoJ29wZW4nKTtcbn07XG5cbmRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgZnVuY3Rpb24oZSl7XG4gIGlmKCFlLnRhcmdldC5jbG9zZXN0KCcudG9wYmFyLWF2YXRhci13cmFwJykpe1xuICAgIGNvbnN0IG1lbnUgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnaGVhZGVyLWF2YXRhci1tZW51Jyk7XG4gICAgaWYobWVudSkgbWVudS5jbGFzc0xpc3QucmVtb3ZlKCdvcGVuJyk7XG4gIH1cbn0pO1xuXG4vLyDilZDilZDilZAgUG9wdXAgbGFuY2VtZW50IOKVkOKVkOKVkFxud2luZG93LmNsb3NlTGF1bmNoUG9wdXAgPSBmdW5jdGlvbigpe1xuICBjb25zdCBwb3B1cCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdsYXVuY2gtcG9wdXAnKTtcbiAgaWYocG9wdXApe1xuICAgIHBvcHVwLnN0eWxlLm9wYWNpdHkgPSAnMCc7XG4gICAgcG9wdXAuc3R5bGUudHJhbnNpdGlvbiA9ICdvcGFjaXR5IC4zcyc7XG4gICAgc2V0VGltZW91dCgoKSA9PiBwb3B1cC5zdHlsZS5kaXNwbGF5ID0gJ25vbmUnLCAzMDApO1xuICAgIGxvY2FsU3RvcmFnZS5zZXRJdGVtKCduZGEtbGF1bmNoLXNlZW4nLCAnMScpO1xuICB9XG59O1xuXG4vLyBBZmZpY2hlciBsYSBwb3B1cCBzZXVsZW1lbnQgc2kgcGFzIGTDqWrDoCB2dWVcbmRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoJ0RPTUNvbnRlbnRMb2FkZWQnLCBmdW5jdGlvbigpe1xuICBjb25zdCBwb3B1cCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdsYXVuY2gtcG9wdXAnKTtcbiAgaWYocG9wdXAgJiYgbG9jYWxTdG9yYWdlLmdldEl0ZW0oJ25kYS1sYXVuY2gtc2VlbicpKXtcbiAgICBwb3B1cC5zdHlsZS5kaXNwbGF5ID0gJ25vbmUnO1xuICB9XG59KTtcblxuLy8g4pWQ4pWQ4pWQIENUQSBmbG90dGFudCDigJQgYXBwYXJhw650IGFwcsOocyBsZSBoZXJvIOKVkOKVkOKVkFxud2luZG93LmFkZEV2ZW50TGlzdGVuZXIoJ3Njcm9sbCcsIGZ1bmN0aW9uKCl7XG4gIGNvbnN0IGN0YSA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5mbG9hdGluZy1jdGEnKTtcbiAgY29uc3QgaGVybyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5uZGEtaGVybycpO1xuICBpZighY3RhIHx8ICFoZXJvKSByZXR1cm47XG4gIGlmKHdpbmRvdy5zY3JvbGxZID4gaGVyby5vZmZzZXRIZWlnaHQpe1xuICAgIGN0YS5jbGFzc0xpc3QuYWRkKCd2aXNpYmxlJyk7XG4gIH0gZWxzZSB7XG4gICAgY3RhLmNsYXNzTGlzdC5yZW1vdmUoJ3Zpc2libGUnKTtcbiAgfVxufSk7XG5cbi8vIOKVkOKVkOKVkCBBdXRvLWhpZGUgd2VsY29tZSB0b2FzdCDilZDilZDilZBcbmRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoJ0RPTUNvbnRlbnRMb2FkZWQnLCBmdW5jdGlvbigpe1xuICBjb25zdCB0b2FzdCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCd3ZWxjb21lLXRvYXN0Jyk7XG4gIGlmKHRvYXN0KXtcbiAgICBzZXRUaW1lb3V0KGZ1bmN0aW9uKCl7XG4gICAgICB0b2FzdC5zdHlsZS5kaXNwbGF5ID0gJ25vbmUnO1xuICAgIH0sIDQwMDApO1xuICB9XG59KTtcbiIsIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpblxuZXhwb3J0IHt9OyJdLCJuYW1lcyI6W10sInNvdXJjZVJvb3QiOiIifQ==