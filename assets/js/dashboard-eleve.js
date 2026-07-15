// ═══ Calendrier Élève ═══
const TOUS_COURS = {
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

// Mapping jour → numéro (0=dim, 1=lun, 2=mar, 3=mer, 4=jeu)
const JOUR_MAP = { 'lundi':1, 'mardi':2, 'mercredi':3, 'jeudi':4 };
const JOUR_LABEL = { 'lundi':'Lundi', 'mardi':'Mardi', 'mercredi':'Mercredi', 'jeudi':'Jeudi' };
let currentCours = 'lundi';

function getCoursFiltres(jour){
  const jourNum = JOUR_MAP[jour];
  const filtered = {};
  Object.keys(TOUS_COURS).forEach(function(dateStr){
    const d = new Date(dateStr);
    if(d.getDay() === jourNum) filtered[dateStr] = TOUS_COURS[dateStr];
  });
  return filtered;
}

const MONTHS_ELEVE = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
let eleveYear = 2026, eleveMonth = 8;

function padEleve(n){ return String(n).padStart(2,'0'); }

function renderCalEleve(){
  const title = document.getElementById('nav-title-eleve');
  const grid = document.getElementById('cal-days-eleve');
  if(!title || !grid) return;
  title.textContent = MONTHS_ELEVE[eleveMonth] + ' ' + eleveYear;
  grid.innerHTML = '';
  const cours = getCoursFiltres(currentCours);
  const firstDay = new Date(eleveYear, eleveMonth, 1).getDay();
  const offset = (firstDay === 0) ? 6 : firstDay - 1;
  const daysInMonth = new Date(eleveYear, eleveMonth+1, 0).getDate();
  const today = new Date();
  for(let i = 0; i < offset; i++){
    const d = document.createElement('div');
    d.className = 'nda-cal-day empty';
    grid.appendChild(d);
  }
  let count = 0;
  for(let day = 1; day <= daysInMonth; day++){
    const date = new Date(eleveYear, eleveMonth, day);
    const dow = date.getDay();
    const dateStr = eleveYear+'-'+padEleve(eleveMonth+1)+'-'+padEleve(day);
    const isWeekend = dow === 0 || dow === 6;
    const isCours = cours[dateStr];
    const isToday = date.toDateString() === today.toDateString();
    if(isCours) count++;
    const d = document.createElement('div');
    let cls = 'nda-cal-day';
    if(isWeekend) cls += ' weekend';
    if(isCours) cls += ' has-cours';
    if(isToday) cls += ' today';
    d.className = cls;
    let inner = '<div class="nda-cal-num">'+day+'</div>';
    if(isCours){
      inner += '<div class="nda-cal-dot"></div>';
      inner += '<div class="nda-cal-time">'+cours[dateStr]+'</div>';
    }
    d.innerHTML = inner;
    grid.appendChild(d);
  }
  // Mise à jour stats
  const totalCours = Object.keys(getCoursFiltres(currentCours)).length;
  const statSeances = document.getElementById('stat-seances');
  const statJour = document.getElementById('stat-jour');
  if(statSeances) statSeances.textContent = totalCours;
  if(statJour) statJour.textContent = JOUR_LABEL[currentCours];
}

window.setCoursFilter = function(){
  const sel = document.getElementById('cours-filter');
  if(sel) currentCours = sel.value;
  renderCalEleve();
};
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
