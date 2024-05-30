const paymentBtn = document.getElementById('generate-payment');
const responseContainer = document.getElementById('response-container');
const responseContent = document.getElementById('response-content');
function generatePayment(event){
  event.preventDefault();
  let href = event.srcElement.href;
  let ajax = new XMLHttpRequest();
  console.log(href);
  ajax.open('GET',href);
  ajax.send();
  ajax.onreadystatechange = function(){
    const response = JSON.parse(ajax.responseText);
    const status = response.status;
    const message = response.message;
    const elements = response.elements;
    console.log(response);
    if (status === "success") {
      responseContainer.classList.add('success');
      responseContainer.classList.remove('error');
    }
    if (status === 'error') {
      responseContainer.classList.add('error');
      responseContainer.classList.remove('success');
    }
    responseContainer.classList.remove('hidden');
    responseContent.textContent = message;
    Object.keys(elements).forEach(element => {
      const id = elements[element]['id'];
      const view = elements[element]['view'];
      const container = document.getElementById(id);
      container.innerHTML = view;
    })
  }
}

paymentBtn.addEventListener('click',generatePayment);
