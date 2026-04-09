'use strict';

function formatYMD(date) {
  const y = date.getFullYear();
  const m = String(date.getMonth() + 1).padStart(2, '0');
  const d = String(date.getDate()).padStart(2, '0');
  return `${y}-${m}-${d}`;
}

/**
 * @param {HTMLElement} root - .calendar-host 要素（data-target に input の id）
 */
function closeAllCalendarHosts() {
  document.querySelectorAll('.calendar-host.is-open').forEach((host) => {
    host.classList.remove('is-open');
  });
}

function initCalendar(root) {
  const inputId = root.dataset.target;
  const input = document.getElementById(inputId);
  if (!input) {
    console.warn('initCalendar: input not found:', inputId);
    return;
  }

  const group = root.closest('.date-picker-group');

  function openPicker() {
    closeAllCalendarHosts();
    root.classList.add('is-open');
  }

  function closePicker() {
    root.classList.remove('is-open');
  }

  if (group) {
    function blockNativeDatePickerUi(ev) {
      ev.preventDefault();
    }
    input.addEventListener('mousedown', blockNativeDatePickerUi);
    input.addEventListener('pointerdown', blockNativeDatePickerUi, { passive: false });
    input.addEventListener('touchstart', blockNativeDatePickerUi, { passive: false });

    input.addEventListener('focusin', openPicker);
    input.addEventListener('click', openPicker);
  } else {
    root.classList.add('is-open');
  }

  const prevBtn = root.querySelector('.cal-prev');
  const nextBtn = root.querySelector('.cal-next');
  const titleEl = root.querySelector('.cal-title');
  const tbody = root.querySelector('tbody');

  const pageToday = new Date();
  const todayStr = formatYMD(pageToday);

  let year = pageToday.getFullYear();
  let month = pageToday.getMonth();

  function getCalendarHead() {
    const dates = [];
    const d = new Date(year, month, 0).getDate();
    const n = new Date(year, month, 1).getDay();

    for (let i = 0; i < n; i++) {
      const day = d - i;
      const dt = new Date(year, month - 1, day);
      dates.unshift({
        date: day,
        isDisabled: true,
        ymd: formatYMD(dt),
      });
    }
    return dates;
  }

  function getCalendarBody() {
    const dates = [];
    const lastDate = new Date(year, month + 1, 0).getDate();

    for (let i = 1; i <= lastDate; i++) {
      const dt = new Date(year, month, i);
      dates.push({
        date: i,
        isDisabled: false,
        ymd: formatYMD(dt),
      });
    }
    return dates;
  }

  function getCalendarTail() {
    const dates = [];
    const lastDay = new Date(year, month + 1, 0).getDay();

    for (let i = 1; i < 7 - lastDay; i++) {
      const dt = new Date(year, month + 1, i);
      dates.push({
        date: i,
        isDisabled: true,
        ymd: formatYMD(dt),
      });
    }
    return dates;
  }

  function clearCalendar() {
    while (tbody.firstChild) {
      tbody.removeChild(tbody.firstChild);
    }
  }

  function renderTitle() {
    const title = `${year}/${String(month + 1).padStart(2, '0')}`;
    titleEl.textContent = title;
  }

  function renderWeeks() {
    const dates = [
      ...getCalendarHead(),
      ...getCalendarBody(),
      ...getCalendarTail(),
    ];
    const weeks = [];
    const weeksCount = dates.length / 7;

    for (let i = 0; i < weeksCount; i++) {
      weeks.push(dates.splice(0, 7));
    }

    const selected = input.value;

    weeks.forEach((week) => {
      const tr = document.createElement('tr');
      week.forEach((cell) => {
        const td = document.createElement('td');
        td.textContent = cell.date;
        td.dataset.ymd = cell.ymd;
        if (cell.ymd === todayStr) {
          td.classList.add('today');
        }
        if (cell.isDisabled) {
          td.classList.add('disabled');
        }
        if (cell.ymd === selected) {
          td.classList.add('selected');
        }
        tr.appendChild(td);
      });
      tbody.appendChild(tr);
    });
  }

  function createCalendar() {
    clearCalendar();
    renderTitle();
    renderWeeks();
  }

  prevBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    month--;
    if (month < 0) {
      year--;
      month = 11;
    }
    createCalendar();
  });

  nextBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    month++;
    if (month > 11) {
      year++;
      month = 0;
    }
    createCalendar();
  });

  tbody.addEventListener('click', (e) => {
    const td = e.target.closest('td[data-ymd]');
    if (!td) return;
    const ymd = td.dataset.ymd;
    if (!ymd) return;
    e.stopPropagation();
    input.value = ymd;
    createCalendar();
    closePicker();
  });

  createCalendar();
}

document.addEventListener('DOMContentLoaded', () => {
  document.addEventListener('click', (e) => {
    if (e.target.closest('.date-picker-group')) {
      return;
    }
    closeAllCalendarHosts();
  });

  document.querySelectorAll('.calendar-host').forEach((host) => {
    initCalendar(host);
  });
});
