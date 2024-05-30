const buttons = document.querySelectorAll('.btn-dual');
const sections = document.querySelectorAll('.dual');

buttons.forEach((button, index) => {
  button.addEventListener('click', () => {
    buttons.forEach((btn) => btn.classList.remove('active'));
    button.classList.add('active');

    sections.forEach((section) => section.classList.add('close'));
    sections[index].classList.remove('close');
  });
});