const userToggle = document.querySelector('#toggle-user');

const schoolsTitle = document.querySelector('#wdt-table-title-5');
const schools = schoolsTitle.nextElementSibling;

const teachersTitle = document.querySelector('#wdt-table-title-6');
const teachers = teachersTitle.nextElementSibling;

teachersTitle.setAttribute('data-current', 'false');
schoolsTitle.setAttribute('data-current', 'true');

userToggle.addEventListener('click', () => {
  if ( teachersTitle.getAttribute('data-current') === 'true' ) {
    teachersTitle.setAttribute('data-current', 'false');
    schoolsTitle.setAttribute('data-current', 'true');
    userToggle.textContent = 'Toggle Teachers';
  } else if (teachersTitle.getAttribute('data-current') === 'false') {
    teachersTitle.setAttribute('data-current', 'true');
    schoolsTitle.setAttribute('data-current', 'false');
    userToggle.textContent = 'Toggle Schools';

  }

});