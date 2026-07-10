import './styles/app.css';

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
