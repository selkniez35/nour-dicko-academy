import './styles/app.css';

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
        els.forEach((el) => el.classList.add('in'));
        return;
    }

    const io = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('in');
                io.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    els.forEach((el) => io.observe(el));
});
// ═══ Modals des cours ═══
window.openModal = function(id){
  const modal = document.getElementById(id);
  if(modal){
    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
  }
};

window.closeModal = function(id){
  const modal = document.getElementById(id);
  if(modal){
    modal.classList.remove('open');
    document.body.style.overflow = '';
  }
};

// Fermer en cliquant sur le fond sombre (hors de la boîte)
document.addEventListener('click', function(e){
  if(e.target.classList.contains('modal-overlay')){
    e.target.classList.remove('open');
    document.body.style.overflow = '';
  }
});

// Fermer avec la touche Échap
document.addEventListener('keydown', function(e){
  if(e.key === 'Escape'){
    document.querySelectorAll('.modal-overlay.open').forEach(function(m){
      m.classList.remove('open');
    });
    document.body.style.overflow = '';
  }
});
// ═══ Navbar active link au scroll ═══
document.addEventListener('DOMContentLoaded', function(){
  const sections = document.querySelectorAll('section[id], div[id]');
  const navLinks = document.querySelectorAll('.topbar-menu a');

  function setActive(){
    let current = '';
    sections.forEach(section => {
      const sectionTop = section.offsetTop - 100;
      if(window.scrollY >= sectionTop){
        current = section.getAttribute('id');
      }
    });
    navLinks.forEach(link => {
      link.classList.remove('active');
      const href = link.getAttribute('href').replace('#','');
      if(href === current){
        link.classList.add('active');
      }
    });
  }

  window.addEventListener('scroll', setActive);
  setActive();
});

window.toggleAvatarMenu = function(){
  const menu = document.getElementById('avatar-menu');
  menu.classList.toggle('open');
};
window.showSection = function(section){
  document.querySelectorAll('.db-nav-item').forEach(i => i.classList.remove('active'));
  document.querySelectorAll('.db-section').forEach(s => s.classList.remove('active'));
  document.querySelector('[data-section="'+section+'"]').classList.add('active');
  document.getElementById('section-'+section).classList.add('active');
};
// Fermer le menu avatar en cliquant ailleurs
document.addEventListener('click', function(e){
  if(!e.target.closest('.db-avatar-wrap')){
    const menu = document.getElementById('avatar-menu');
    if(menu) menu.classList.remove('open');
  }
});

// ═══ Toggle mot de passe ═══
window.togglePassword = function(inputId, iconId){
  const input = document.getElementById(inputId);
  const icon = document.getElementById(iconId);
  if(!input || !icon) return;
  if(input.type === 'password'){
    input.type = 'text';
    icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19M1 1l22 22"/>';
  } else {
    input.type = 'password';
    icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
  }
};

// ═══ Switcher connexion / inscription ═══
window.switchAuth = function(mode){
  const formConnexion = document.getElementById('form-connexion');
  const formInscription = document.getElementById('form-inscription');
  const title = document.getElementById('auth-title');
  const subtitle = document.getElementById('auth-subtitle');
  const error = document.getElementById('mcf-error');
  if(error) error.style.display = 'none';
  if(mode === 'inscription'){
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
window.checkPasswords = function(){
  const pwd = document.getElementById('mcf-reg-password').value;
  const confirm = document.getElementById('mcf-reg-confirm').value;
  const error = document.getElementById('mcf-error');
  if(pwd.length < 8){
    error.textContent = 'Le mot de passe doit contenir au moins 8 caractères.';
    error.style.display = 'block';
    return;
  }
  if(pwd !== confirm){
    error.textContent = 'Les mots de passe ne correspondent pas.';
    error.style.display = 'block';
    return;
  }
  error.style.display = 'none';
  // Ton dev branchera ici l'appel API pour créer le compte
  alert('Compte créé avec succès ! Votre dev branchera cette action.');
};

// ═══ Avatar menu ═══
window.toggleAvatarMenu = function(){
  const menu = document.getElementById('avatar-menu');
  if(menu) menu.classList.toggle('open');
};

document.addEventListener('click', function(e){
  if(!e.target.closest('.db-avatar-wrap') && !e.target.closest('.topbar-btns')){
    const menu = document.getElementById('avatar-menu');
    if(menu) menu.classList.remove('open');
  }
});

// ═══ Popup lancement ═══
window.closeLaunchPopup = function(){
  const popup = document.getElementById('launch-popup');
  if(popup){
    popup.style.opacity = '0';
    popup.style.transition = 'opacity .3s';
    setTimeout(() => popup.style.display = 'none', 300);
    localStorage.setItem('nda-launch-seen', '1');
  }
};

// Afficher la popup seulement si pas déjà vue
document.addEventListener('DOMContentLoaded', function(){
  const popup = document.getElementById('launch-popup');
  if(popup && localStorage.getItem('nda-launch-seen')){
    popup.style.display = 'none';
  }
});

// ═══ CTA flottant — apparaît après le hero ═══
window.addEventListener('scroll', function(){
  const cta = document.querySelector('.floating-cta');
  const hero = document.querySelector('.nda-hero');
  if(!cta || !hero) return;
  if(window.scrollY > hero.offsetHeight){
    cta.classList.add('visible');
  } else {
    cta.classList.remove('visible');
  }
});

// ═══ Auto-hide welcome toast ═══
document.addEventListener('DOMContentLoaded', function(){
  const toast = document.getElementById('welcome-toast');
  if(toast){
    setTimeout(function(){
      toast.style.display = 'none';
    }, 4000);
  }
});
