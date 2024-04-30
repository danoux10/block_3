const selects = document.querySelectorAll('.select');

selects.forEach(select=>{
  select.addEventListener('click',()=>{
    select.classList.toggle('close');
  })
})