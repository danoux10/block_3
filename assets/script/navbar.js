const navbar = document.getElementById('navbar');
const buttonNavbar = document.getElementById('nav-button');

function toggleNavbar(){
  if(!navbar.classList.contains('close')){
    navbar.classList.add('close');
  }else{
    navbar.classList.remove('close');
  }
}

buttonNavbar.addEventListener('click', toggleNavbar);