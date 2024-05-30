function toggleSelect(event){
  if(event.target.classList.contains('close')){
    event.target.classList.remove('close');
  }else{
    event.target.classList.add('close');
  }
}

