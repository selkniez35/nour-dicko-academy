document.addEventListener('click', function(event){
  const button = event.target.closest('[data-remove-student]');
  if(!button) return;
  const row = button.closest('[data-student-row]');
  const studentName = button.dataset.studentName || 'cet élève';
  if(window.confirm('Retirer ' + studentName + ' de cette classe ?')) row.remove();
});

const TOUS_COURS_ADMIN = {
  "2026-09-07":"19h-20h","2026-09-08":"19h-20h","2026-09-09":"19h-20h","2026-09-10":"19h-20h",
  "2026-09-14":"19h-20h","2026-09-15":"19h-20h","2026-09-16":"19h-20h","2026-09-17":"19h-20h",
  "2026-09-21":"19h-20h","2026-09-22":"19h-20h","2026-09-23":"19h-20h","2026-09-24":"19h-20h",
  "2026-09-28":"18h30-19h30","2026-09-29":"18h30-19h30","2026-09-30":"18h30-19h30","2026-10-01":"18h30-19h30"
};
const COURS_COLORS = {1:'rgba(201,146,42,.15)',2:'rgba(168,119,24,.2)',3:'rgba(12,12,12,.08)',4:'rgba(26,23,18,.06)'};
const COURS_LABELS = {1:'Cl. A',2:'Cl. B',3:'Éd. isl.',4:'Coran'};
const MONTHS_ADMIN = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
let adminYear = 2026, adminMonth = 8;

function padAdmin(n){ return String(n).padStart(2,'0'); }
function renderCalAdmin(){
  const title = document.getElementById('nav-title-admin');
  const grid = document.getElementById('cal-days-admin');
  if(!title || !grid) return;
  title.textContent = MONTHS_ADMIN[adminMonth] + ' ' + adminYear;
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
    const isCours = TOUS_COURS_ADMIN[dateStr];
    const isToday = date.toDateString() === today.toDateString();
    const d = document.createElement('div');
    let cls = 'nda-cal-day';
    if(dow === 0 || dow === 6) cls += ' weekend';
    if(isCours) cls += ' has-cours';
    if(isToday) cls += ' today';
    if(isCours && COURS_COLORS[dow]) d.style.background = COURS_COLORS[dow];
    d.className = cls;
    let inner = '<div class="nda-cal-num">'+day+'</div>';
    if(isCours) inner += '<div class="nda-cal-dot"></div><div class="nda-cal-time">'+(COURS_LABELS[dow]||'')+' '+TOUS_COURS_ADMIN[dateStr]+'</div>';
    d.innerHTML = inner;
    grid.appendChild(d);
  }
}
window.prevMonthAdmin = function(){ adminMonth--; if(adminMonth<0){adminMonth=11;adminYear--;} renderCalAdmin(); };
window.nextMonthAdmin = function(){ adminMonth++; if(adminMonth>11){adminMonth=0;adminYear++;} renderCalAdmin(); };

window.openSubModal = function(id){ const m = document.getElementById(id); if(m) m.style.display='flex'; };
window.closeSubModal = function(id){ const m = document.getElementById(id); if(m) m.style.display='none'; };

document.querySelectorAll('.db-nav-item').forEach(function(item){
  item.addEventListener('click', function(e){
    e.preventDefault();
    const section = this.dataset.section;
    document.querySelectorAll('.db-nav-item').forEach(i => i.classList.remove('active'));
    document.querySelectorAll('.db-section').forEach(s => s.classList.remove('active'));
    this.classList.add('active');
    const target = document.getElementById('section-'+section);
    if(target) target.classList.add('active');
  });
});

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
