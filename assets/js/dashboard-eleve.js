// ═══ Calendrier Élève ═══

function escEleveHtml(str){
  const span = document.createElement('span');
  span.textContent = str == null ? '' : String(str);
  return span.innerHTML;
}

// Charge les séances injectées par le serveur et les indexe par date (YYYY-MM-DD).
function loadEleveSessions(){
  const el = document.getElementById('eleve-sessions-data');
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
const ELEVE_SESSIONS = loadEleveSessions();

const MONTHS_ELEVE = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
const today0 = new Date();
let eleveYear = today0.getFullYear(), eleveMonth = today0.getMonth();

// Ouvre le calendrier sur le mois de la prochaine séance à venir (sinon mois courant).
(function(){
  const dates = Object.keys(ELEVE_SESSIONS).sort();
  if(!dates.length) return;
  const todayStr = eleveYear + '-' + String(eleveMonth + 1).padStart(2, '0') + '-' + String(today0.getDate()).padStart(2, '0');
  const next = dates.find(d => d >= todayStr) || dates[dates.length - 1];
  const parts = next.split('-');
  eleveYear = parseInt(parts[0], 10);
  eleveMonth = parseInt(parts[1], 10) - 1;
})();

function padEleve(n){ return String(n).padStart(2,'0'); }

function renderCalEleve(){
  const title = document.getElementById('nav-title-eleve');
  const grid = document.getElementById('cal-days-eleve');
  if(!title || !grid) return;
  title.textContent = MONTHS_ELEVE[eleveMonth] + ' ' + eleveYear;
  grid.innerHTML = '';
  const firstDay = new Date(eleveYear, eleveMonth, 1).getDay();
  const offset = (firstDay === 0) ? 6 : firstDay - 1;
  const daysInMonth = new Date(eleveYear, eleveMonth+1, 0).getDate();
  const today = new Date();
  for(let i = 0; i < offset; i++){
    const d = document.createElement('div');
    d.className = 'nda-cal-day empty';
    grid.appendChild(d);
  }
  for(let day = 1; day <= daysInMonth; day++){
    const date = new Date(eleveYear, eleveMonth, day);
    const dow = date.getDay();
    const dateStr = eleveYear+'-'+padEleve(eleveMonth+1)+'-'+padEleve(day);
    const isWeekend = dow === 0 || dow === 6;
    const sessions = ELEVE_SESSIONS[dateStr] || [];
    const isToday = date.toDateString() === today.toDateString();
    const d = document.createElement('div');
    let cls = 'nda-cal-day';
    if(isWeekend) cls += ' weekend';
    if(sessions.length) cls += ' has-cours';
    if(isToday) cls += ' today';
    d.className = cls;
    let inner = '<div class="nda-cal-num">'+day+'</div>';
    sessions.forEach(function(s){
      const time = s.start ? (s.end ? s.start + '-' + s.end : s.start) : '';
      const label = s.label || 'Séance';
      inner += '<div class="nda-cal-dot"></div>';
      if(time) inner += '<div class="nda-cal-time">'+escEleveHtml(time)+'</div>';
      inner += '<div class="nda-cal-time">'+escEleveHtml(label)+'</div>';
    });
    d.innerHTML = inner;
    grid.appendChild(d);
  }
}

window.prevMonthEleve = function(){
  eleveMonth--;
  if(eleveMonth < 0){ eleveMonth = 11; eleveYear--; }
  renderCalEleve();
};
window.nextMonthEleve = function(){
  eleveMonth++;
  if(eleveMonth > 11){ eleveMonth = 0; eleveYear++; }
  renderCalEleve();
};
document.addEventListener('DOMContentLoaded', function(){
  renderCalEleve();
});

document.querySelectorAll('.db-nav-item').forEach(function(item){
  item.addEventListener('click', function(e){
    e.preventDefault();
    const section = this.dataset.section;
    document.querySelectorAll('.db-nav-item').forEach(i => i.classList.remove('active'));
    document.querySelectorAll('.db-section').forEach(s => s.classList.remove('active'));
    this.classList.add('active');
    document.getElementById('section-' + section).classList.add('active');
  });
});

window.toggleAvatarMenu = function(){
  const menu = document.getElementById('avatar-menu');
  menu.classList.toggle('open');
};

window.showSection = function(section){
  document.querySelectorAll('.db-nav-item').forEach(i => i.classList.remove('active'));
  document.querySelectorAll('.db-section').forEach(s => s.classList.remove('active'));
  const navItem = document.querySelector('[data-section="'+section+'"]');
  if(navItem) navItem.classList.add('active');
  const sectionEl = document.getElementById('section-'+section);
  if(sectionEl) sectionEl.classList.add('active');
};

document.addEventListener('click', function(e){
  if(!e.target.closest('.db-avatar-wrap')){
    const menu = document.getElementById('avatar-menu');
    if(menu) menu.classList.remove('open');
  }
});
