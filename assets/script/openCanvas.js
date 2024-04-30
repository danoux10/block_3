const buttonFormAll = document.querySelectorAll('.btn-form');
const canvasForm = document.querySelector('.canvas-form');
const closeBtn = document.querySelector('.btn-close')

buttonFormAll.forEach(buttonAll =>{
  buttonAll.addEventListener('click', ()=>{
    const sectionId = buttonAll.dataset.section;

    buttonFormAll.forEach(otherButton =>{
      if(otherButton!== buttonAll){
        otherButton.classList.remove('active');
        document.getElementById(otherButton.dataset.section).classList.add('hidden');
      }
    })

    if(!buttonAll.classList.contains('active')){
      buttonAll.classList.add('active');
      document.getElementById(sectionId).classList.remove('hidden');
      canvasForm.classList.remove('close');

    }else{
      buttonAll.classList.remove('active');
      document.getElementById(sectionId).classList.add('hidden');
      canvasForm.classList.add('close');
    }
  })
})

function closeCanvas(){
  document.querySelector('.canvas-form form').classList.add('hidden');
  canvasForm.classList.add('close');
  buttonFormAll.forEach(button=>{
    button.classList.remove('active');
  })
}

closeBtn.addEventListener('click',closeCanvas)