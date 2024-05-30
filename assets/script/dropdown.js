const dropdownBtn = document.querySelector('.dropdown');
const dropdownMenu = document.querySelector('.dropdown-menu');
function toggleDropdown(){
  if(dropdownBtn.classList.contains('active')){
    dropdownBtn.classList.remove('active');
    dropdownMenu.classList.add('close');
  }else{
    dropdownBtn.classList.add('active');
    dropdownMenu.classList.remove('close');
  }
}

dropdownBtn.addEventListener('click', toggleDropdown);