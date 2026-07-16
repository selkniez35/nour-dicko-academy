document.addEventListener('click', function(event){
  const button = event.target.closest('[data-remove-student]');
  if(!button) return;
  const row = button.closest('[data-student-row]');
  const studentName = button.dataset.studentName || 'cet élève';
  if(window.confirm('Retirer ' + studentName + ' de cette classe ?')) row.remove();
});


const ADMIN_MONTHS = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];

function padAdmin(n){ return String(n).padStart(2,'0'); }

function escAdminHtml(str){
  const span = document.createElement('span');
  span.textContent = str == null ? '' : String(str);
  return span.innerHTML;
}

// Charge les séances injectées par le serveur et les indexe par date (YYYY-MM-DD).
function loadAdminSessions(){
  const el = document.getElementById('admin-sessions-data');
  const map = {};
  if(!el) return map;
  let list = [];
  try { list = JSON.parse(el.textContent || '[]'); } catch(e){ list = []; }
  list.forEach(function(s){
    if(!s || !s.date) return;
    (map[s.date] = map[s.date] || []).push(s);
  });
  return map;
}
const ADMIN_SESSIONS = loadAdminSessions();

const adminToday = new Date();
let adminYear = adminToday.getFullYear();
let adminMonth = adminToday.getMonth();

// Ouvre le calendrier sur le mois de la prochaine séance à venir (sinon mois courant).
(function(){
  const dates = Object.keys(ADMIN_SESSIONS).sort();
  if(!dates.length) return;
  const todayStr = adminYear + '-' + padAdmin(adminMonth + 1) + '-' + padAdmin(adminToday.getDate());
  const next = dates.find(d => d >= todayStr) || dates[dates.length - 1];
  const parts = next.split('-');
  adminYear = parseInt(parts[0], 10);
  adminMonth = parseInt(parts[1], 10) - 1;
})();

function renderCalAdmin(){
  const title = document.getElementById('nav-title-admin');
  const grid = document.getElementById('cal-days-admin');
  if(!title || !grid) return;
  title.textContent = ADMIN_MONTHS[adminMonth] + ' ' + adminYear;
  grid.innerHTML = '';
  const firstDay = new Date(adminYear, adminMonth, 1).getDay();
  const offset = (firstDay === 0) ? 6 : firstDay - 1;
  const daysInMonth = new Date(adminYear, adminMonth+1, 0).getDate();
  const today = new Date();
  for(let i = 0; i < offset; i++){
    const d = document.createElement('div');
    d.className = 'nda-cal-day empty';
    grid.appendChild(d);
  }
  for(let day = 1; day <= daysInMonth; day++){
    const date = new Date(adminYear, adminMonth, day);
    const dow = date.getDay();
    const dateStr = adminYear+'-'+padAdmin(adminMonth+1)+'-'+padAdmin(day);
    const sessions = ADMIN_SESSIONS[dateStr] || [];
    const isToday = date.toDateString() === today.toDateString();
    const d = document.createElement('div');
    let cls = 'nda-cal-day';
    if(dow === 0 || dow === 6) cls += ' weekend';
    if(isToday) cls += ' today';
    if(sessions.length) cls += ' has-cours';
    d.className = cls;
    let inner = '<div class="nda-cal-num">' + day + '</div>';
    sessions.forEach(function(s){
      const time = s.start ? (s.end ? s.start + '-' + s.end : s.start) : '';
      const label = s.label || 'Séance';
      const tip = label + (s.teacher ? ' — ' + s.teacher : '');
      inner += '<div class="nda-cal-cours" title="' + escAdminHtml(tip).replace(/"/g,'&quot;') + '">'
             + (time ? '<span class="nda-cal-time">' + escAdminHtml(time) + '</span>' : '')
             + '<span class="nda-cal-label">' + escAdminHtml(label) + '</span></div>';
    });
    d.innerHTML = inner;
    grid.appendChild(d);
  }
}
window.prevMonthAdmin = function(){ adminMonth--; if(adminMonth<0){adminMonth=11;adminYear--;} renderCalAdmin(); };
window.nextMonthAdmin = function(){ adminMonth++; if(adminMonth>11){adminMonth=0;adminYear++;} renderCalAdmin(); };

window.openSubModal = function(id){ const m = document.getElementById(id); if(m) m.style.display='flex'; };
window.closeSubModal = function(id){ const m = document.getElementById(id); if(m) m.style.display='none'; };

function activateAdminSection(section){
  const nav = document.querySelector('.db-nav-item[data-section="'+section+'"]');
  const target = document.getElementById('section-'+section);
  if(!nav || !target) return false;
  document.querySelectorAll('.db-nav-item').forEach(i => i.classList.remove('active'));
  document.querySelectorAll('.db-section').forEach(s => s.classList.remove('active'));
  nav.classList.add('active');
  target.classList.add('active');
  return true;
}

document.querySelectorAll('.db-nav-item').forEach(function(item){
  item.addEventListener('click', function(e){
    e.preventDefault();
    const section = this.dataset.section;
    if(activateAdminSection(section)){
      history.replaceState(null, '', '#' + section);
    }
  });
});

// Ouvre directement la section demandee via le hash de l'URL (ex: /admin#eleves),
// utilise apres une redirection depuis un formulaire admin.
(function(){
  const hash = window.location.hash.replace('#', '');
  if(hash) activateAdminSection(hash);
})();

window.toggleAvatarMenu = function(){
  document.getElementById('avatar-menu').classList.toggle('open');
};
document.addEventListener('click', function(e){
  if(!e.target.closest('.db-avatar-wrap')){
    const menu = document.getElementById('avatar-menu');
    if(menu) menu.classList.remove('open');
  }
});

document.addEventListener('DOMContentLoaded', function(){ renderCalAdmin(); });
