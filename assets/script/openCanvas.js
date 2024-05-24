const canvasForm = document.querySelector('.canvas-form');
const closeBtn = document.querySelector('.btn-close')
const formContainer = document.getElementById('form-container');
const responseContainer = document.getElementById('response-container');
const responseContent = document.getElementById('response-content');
const linkCanvas = Array.from(document.getElementsByClassName('open-canvas'));

function closeResponse(){
  responseContainer.classList.add('hidden');
  responseContainer.classList.remove('success');
  responseContainer.classList.remove('error');
  // responseContent.textContent = "";
}
function closeCanvas(){
  canvasForm.classList.add('close');
}
function openCanvas(){
  canvasForm.classList.remove('close');
}
function showForm(event){
  event.preventDefault();
  openCanvas();
  let href = event.srcElement.href;
  // console.log(href);
  let ajax = new XMLHttpRequest();
  ajax.open('GET',href);
  ajax.send();
  ajax.onreadystatechange = function(){
    console.log(ajax.response);
    formContainer.innerHTML = ajax.response;
    const forms = document.querySelectorAll('form');
    forms.forEach(form=>{
      form.addEventListener('submit',formSubmit);
    })
  }
}
function formSubmit(event){
  event.preventDefault();
  let action = event.target.getAttribute('action');
  let ajax = new XMLHttpRequest();
  let data = new FormData(this);
  ajax.open('POST',action);
  ajax.send(data);
  ajax.onreadystatechange = function(){
    const elements = JSON.parse(this.responseText).elements;
    const status = JSON.parse(this.responseText).status;
    const message = JSON.parse(this.responseText).message;
    console.log(status);
    console.log(message);
    responseContainer.classList.remove('hidden');
    if(status === "success"){
      responseContainer.classList.add('success');
      responseContainer.classList.remove('error');
      console.log("green");
    }
    if(status === 'error'){
      responseContainer.classList.add('error');
      responseContainer.classList.remove('success');
      console.log("red");
    }
    responseContent.textContent = message;
    elements.forEach(element=>{
      const id = element.id;
      console.log(id)//delete
      const view = element.view;
      console.log(view)//delete
      const container = document.getElementById(id);
      container.innerHTML = view;
      closeCanvas();
    })
  }
}

linkCanvas.forEach(linkCanva=>{
  linkCanva.addEventListener('click',showForm);
});

closeBtn.addEventListener('click',closeCanvas);
responseContainer.addEventListener('mouseover',closeResponse);