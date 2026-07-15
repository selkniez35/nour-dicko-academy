// ═══ Calendrier Enseignant ═══
// Youssef Ben Ali enseigne Langue arabe Classe A (lundi) et Classe B (mardi)
// Ton dev remplacera par les vraies classes de l'enseignant connecté
const CLASSES_ENSEIGNANT = ['lundi', 'mardi']; // à adapter selon l'enseignant

const TOUS_COURS_ENS = {
  "2026-09-07":"19h-20h","2026-09-08":"19h-20h","2026-09-09":"19h-20h","2026-09-10":"19h-20h",
  "2026-09-14":"19h-20h","2026-09-15":"19h-20h","2026-09-16":"19h-20h","2026-09-17":"19h-20h",
  "2026-09-21":"19h-20h","2026-09-22":"19h-20h","2026-09-23":"19h-20h","2026-09-24":"19h-20h",
  "2026-09-28":"18h30-19h30","2026-09-29":"18h30-19h30","2026-09-30":"18h30-19h30",
  "2026-10-01":"18h30-19h30","2026-10-05":"18h30-19h30","2026-10-06":"18h30-19h30",
  "2026-10-07":"18h30-19h30","2026-10-08":"18h30-19h30",
  "2026-10-12":"19h30-20h30","2026-10-13":"19h30-20h30","2026-10-14":"19h30-20h30","2026-10-15":"19h30-20h30",
  "2026-10-19":"19h30-20h30","2026-10-20":"19h30-20h30","2026-10-21":"19h30-20h30","2026-10-22":"19h30-20h30",
  "2026-10-26":"19h30-20h30","2026-10-27":"19h30-20h30","2026-10-28":"19h30-20h30","2026-10-29":"19h30-20h30",
  "2026-11-02":"19h30-20h30","2026-11-03":"19h30-20h30","2026-11-04":"19h30-20h30","2026-11-05":"19h30-20h30",
  "2026-11-09":"19h30-20h30","2026-11-10":"19h30-20h30","2026-11-11":"19h30-20h30","2026-11-12":"19h30-20h30",
  "2026-11-16":"19h30-20h30","2026-11-17":"19h30-20h30","2026-11-18":"19h30-20h30","2026-11-19":"19h30-20h30",
  "2026-11-23":"19h30-20h30","2026-11-24":"19h30-20h30","2026-11-25":"19h30-20h30","2026-11-26":"19h30-20h30",
  "2026-11-30":"19h30-20h30",
  "2026-12-01":"19h30-20h30","2026-12-02":"19h30-20h30","2026-12-03":"19h30-20h30",
  "2026-12-07":"19h30-20h30","2026-12-08":"19h30-20h30","2026-12-09":"19h30-20h30","2026-12-10":"19h30-20h30",
  "2026-12-14":"19h30-20h30","2026-12-15":"19h30-20h30","2026-12-16":"19h30-20h30","2026-12-17":"19h30-20h30",
  "2026-12-21":"19h30-20h30","2026-12-22":"19h30-20h30","2026-12-23":"19h30-20h30","2026-12-24":"19h30-20h30",
  "2026-12-28":"19h30-20h30","2026-12-29":"19h30-20h30","2026-12-30":"19h30-20h30","2026-12-31":"19h30-20h30",
  "2027-01-04":"19h30-20h30","2027-01-05":"19h30-20h30","2027-01-06":"19h30-20h30","2027-01-07":"19h30-20h30",
  "2027-01-11":"19h30-20h30","2027-01-12":"19h30-20h30","2027-01-13":"19h30-20h30","2027-01-14":"19h30-20h30",
  "2027-01-18":"19h30-20h30","2027-01-19":"19h30-20h30","2027-01-20":"19h30-20h30","2027-01-21":"19h30-20h30",
  "2027-01-25":"19h30-20h30","2027-01-26":"19h30-20h30","2027-01-27":"19h30-20h30","2027-01-28":"19h30-20h30",
  "2027-02-01":"19h30-20h30","2027-02-02":"19h30-20h30","2027-02-03":"19h30-20h30","2027-02-04":"19h30-20h30",
  "2027-03-15":"19h30-20h30","2027-03-16":"19h30-20h30","2027-03-17":"19h30-20h30","2027-03-18":"19h30-20h30",
  "2027-03-22":"19h30-20h30","2027-03-23":"19h30-20h30","2027-03-24":"19h30-20h30","2027-03-25":"19h30-20h30",
  "2027-03-29":"19h30-20h30","2027-03-30":"19h30-20h30","2027-03-31":"19h30-20h30",
  "2027-04-01":"19h30-20h30","2027-04-05":"19h30-20h30","2027-04-06":"19h30-20h30","2027-04-07":"19h30-20h30","2027-04-08":"19h30-20h30",
  "2027-04-12":"19h30-20h30","2027-04-13":"19h30-20h30","2027-04-14":"19h30-20h30","2027-04-15":"19h30-20h30",
  "2027-04-19":"19h30-20h30","2027-04-20":"19h30-20h30","2027-04-21":"19h30-20h30","2027-04-22":"19h30-20h30",
  "2027-04-26":"19h30-20h30","2027-04-27":"19h30-20h30","2027-04-28":"19h30-20h30","2027-04-29":"19h30-20h30",
  "2027-05-03":"19h30-20h30","2027-05-04":"19h30-20h30","2027-05-05":"19h30-20h30","2027-05-06":"19h30-20h30",
  "2027-05-10":"19h30-20h30","2027-05-11":"19h30-20h30","2027-05-12":"19h30-20h30","2027-05-13":"19h30-20h30",
  "2027-05-17":"19h30-20h30","2027-05-18":"19h30-20h30","2027-05-19":"19h30-20h30","2027-05-20":"19h30-20h30",
  "2027-05-24":"19h30-20h30","2027-05-25":"19h30-20h30","2027-05-26":"19h30-20h30","2027-05-27":"19h30-20h30",
  "2027-05-31":"19h30-20h30",
  "2027-06-01":"19h30-20h30","2027-06-02":"19h30-20h30","2027-06-03":"19h30-20h30",
  "2027-06-07":"19h30-20h30","2027-06-08":"19h30-20h30","2027-06-09":"19h30-20h30","2027-06-10":"19h30-20h30",
  "2027-06-14":"19h30-20h30","2027-06-15":"19h30-20h30","2027-06-16":"19h30-20h30","2027-06-17":"19h30-20h30",
  "2027-06-21":"19h30-20h30","2027-06-22":"19h30-20h30","2027-06-23":"19h30-20h30","2027-06-24":"19h30-20h30"
};

const JOUR_MAP_ENS = { 'lundi':1, 'mardi':2, 'mercredi':3, 'jeudi':4 };
const JOUR_LABEL_ENS = { 'lundi':'Lundi', 'mardi':'Mardi', 'mercredi':'Mercredi', 'jeudi':'Jeudi' };
const MONTHS_ENS = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
let calYearEns = 2026, calMonthEns = 8;

function getCoursFiltresEns(){
  const jours = CLASSES_ENSEIGNANT.map(j => JOUR_MAP_ENS[j]);
  const filtered = {};
  Object.keys(TOUS_COURS_ENS).forEach(function(dateStr){
    const d = new Date(dateStr);
    if(jours.includes(d.getDay())) filtered[dateStr] = TOUS_COURS_ENS[dateStr];
  });
  return filtered;
}

function padEns(n){ return String(n).padStart(2,'0'); }

function renderCal(){
  const title = document.getElementById('nav-title');
  const grid = document.getElementById('cal-days');
  if(!title || !grid) return;
  title.textContent = MONTHS_ENS[calMonthEns] + ' ' + calYearEns;
  grid.innerHTML = '';
  const cours = getCoursFiltresEns();
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
    const isCours = cours[dateStr];
    const isToday = date.toDateString() === today.toDateString();
    const d = document.createElement('div');
    let cls = 'nda-cal-day';
    if(isWeekend) cls += ' weekend';
    if(isCours) cls += ' has-cours';
    if(isToday) cls += ' today';
    d.className = cls;
    // Ajouter label du jour si cours
    let label = '';
    if(isCours){
      const jourNom = Object.keys(JOUR_MAP_ENS).find(j => JOUR_MAP_ENS[j] === dow);
      label = jourNom === 'lundi' ? 'Cl. A' : jourNom === 'mardi' ? 'Cl. B' : '';
    }
    let inner = '<div class="nda-cal-num">'+day+'</div>';
    if(isCours){
      inner += '<div class="nda-cal-dot"></div>';
      inner += '<div class="nda-cal-time">'+(label ? label+' · ' : '')+cours[dateStr]+'</div>';
    }
    d.innerHTML = inner;
    grid.appendChild(d);
  }
  // Stats
  const total = Object.keys(getCoursFiltresEns()).length;
  const statEl = document.getElementById('stat-seances');
  if(statEl) statEl.textContent = total;
  const jourEl = document.getElementById('stat-jour');
  if(jourEl) jourEl.textContent = CLASSES_ENSEIGNANT.map(j => JOUR_LABEL_ENS[j]).join(' & ');
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
