const canvasForm = document.querySelector('.canvas-form');
const closeBtn = document.querySelector('.btn-close')
const formContainer = document.getElementById('form-container');
// const mainPage = document.querySelector('main');
function closeCanvas(){
  document.querySelector('.canvas-form form').classList.add('hidden');
  canvasForm.classList.add('close');
  buttonFormAll.forEach(button=>{
    button.classList.remove('active');
  })
}
// mainPage.addEventListener('click',closeCanvas)
closeBtn.addEventListener('click',closeCanvas)

const linkCanvas = Array.from(document.getElementsByClassName('open-canvas'));
function openCanvas(event){
  event.preventDefault();
  let href = event.srcElement.href;
  let ajax = new XMLHttpRequest();
  ajax.open('GET',href);
  ajax.send();
  ajax.onreadystatechange = function(){
    // console.log(ajax.response);
    formContainer.innerHTML = ajax.response;
    const forms = document.querySelectorAll('form');
    forms.forEach(form=>{
      form.addEventListener('submit',formSubmit);
    })
  }
  // console.log(href);
}
linkCanvas.forEach(linkCanva=>{
  linkCanva.addEventListener('click',openCanvas);
})

function formSubmit(event){
  event.preventDefault();
  let action = event.target.getAttribute('action');
  let ajax = new XMLHttpRequest();
  let data = new FormData(this);
  ajax.open('POST',action);
  ajax.send(data);
  ajax.onreadystatechange = function(){
    console.log(ajax.response);
    const elements = JSON.parse(this.responseText).elements;
    console.log(elements);
    elements.forEach(element=>{
      const id = element.id;
      const view = element.view;
      console.log(view)
      const container = document.getElementById(id);
      container.innerHTML = view;
    })
  }
}
