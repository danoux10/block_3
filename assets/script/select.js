const selects = document.querySelectorAll('.select');

selects.forEach(select=>{
  select.addEventListener('click',()=>{
    console.log('hey');
    select.classList.toggle('close');
  })
})