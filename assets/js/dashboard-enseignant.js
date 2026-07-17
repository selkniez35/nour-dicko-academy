// ═══ Calendrier Enseignant ═══

function escEnsHtml(str){
  const span = document.createElement('span');
  span.textContent = str == null ? '' : String(str);
  return span.innerHTML;
}

// Charge les séances injectées par le serveur et les indexe par date (YYYY-MM-DD).
function loadEnsSessions(){
  const el = document.getElementById('enseignant-sessions-data');
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
const ENS_SESSIONS = loadEnsSessions();

const MONTHS_ENS = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
const todayEns0 = new Date();
let calYearEns = todayEns0.getFullYear(), calMonthEns = todayEns0.getMonth();

// Ouvre le calendrier sur le mois de la prochaine séance à venir (sinon mois courant).
(function(){
  const dates = Object.keys(ENS_SESSIONS).sort();
  if(!dates.length) return;
  const todayStr = calYearEns + '-' + String(calMonthEns + 1).padStart(2, '0') + '-' + String(todayEns0.getDate()).padStart(2, '0');
  const next = dates.find(d => d >= todayStr) || dates[dates.length - 1];
  const parts = next.split('-');
  calYearEns = parseInt(parts[0], 10);
  calMonthEns = parseInt(parts[1], 10) - 1;
})();

function padEns(n){ return String(n).padStart(2,'0'); }

function renderCal(){
  const title = document.getElementById('nav-title');
  const grid = document.getElementById('cal-days');
  if(!title || !grid) return;
  title.textContent = MONTHS_ENS[calMonthEns] + ' ' + calYearEns;
  grid.innerHTML = '';
  const firstDay = new Date(calYearEns, calMonthEns, 1).getDay();
  const offset = (firstDay === 0) ? 6 : firstDay - 1;
  const daysInMonth = new Date(calYearEns, calMonthEns+1, 0).getDate();
  const today = new Date();
  for(let i = 0; i < offset; i++){
    const d = document.createElement('div');
    d.className = 'nda-cal-day empty';
    grid.appendChild(d);
  }
  for(let day = 1; day <= daysInMonth; day++){
    const date = new Date(calYearEns, calMonthEns, day);
    const dow = date.getDay();
    const dateStr = calYearEns+'-'+padEns(calMonthEns+1)+'-'+padEns(day);
    const isWeekend = dow === 0 || dow === 6;
    const sessions = ENS_SESSIONS[dateStr] || [];
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
      inner += '<div class="nda-cal-time">'+(time ? escEnsHtml(time)+' · ' : '')+escEnsHtml(label)+'</div>';
    });
    d.innerHTML = inner;
    grid.appendChild(d);
  }
}

window.prevMonth = function(){
  calMonthEns--;
  if(calMonthEns < 0){ calMonthEns = 11; calYearEns--; }
  renderCal();
};
window.nextMonth = function(){
  calMonthEns++;
  if(calMonthEns > 11){ calMonthEns = 0; calYearEns++; }
  renderCal();
};
document.addEventListener('DOMContentLoaded', function(){
  renderCal();
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
