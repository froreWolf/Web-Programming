window.addEventListener('load', function(){
  //add event listeners to the input boxes
  var hilightable = document.querySelectorAll('input.hilightable');
  for(var i = 0; i < hilightable.length; i++){
    hilightable[i].addEventListener('focus', toggleOn);
    hilightable[i].addEventListener('blur', toggleOff);
  }
  //the same but for the select boxes
  var hilightable = document.querySelectorAll('select.hilightable');
  for(var i = 0; i < hilightable.length; i++){
    hilightable[i].addEventListener('focus', toggleOn);
    hilightable[i].addEventListener('blur', toggleOff);
  }
  //addEventListener for the submit button
  document.getElementById('mainForm').addEventListener('submit', checkRequired);
  document.getElementById('mainForm').addEventListener('reset', resetForm);
});

////toggles the highlight tag on when focus is gained
function toggleOn(input){
  input.target.classList.add("highlight");
}

//toggles the highlight tag off when focus is lost
function toggleOff(input){
  input.target.classList.remove("highlight")
}

//add error tags to the required inputs when not filled in
function checkRequired(input){
  var requiredElements = document.querySelectorAll('input.required');
  for(var i = 0; i < requiredElements.length; i++){
    if(requiredElements[i].value == ''){
      requiredElements[i].classList.add('error');
      input.preventDefault();
    }
    else{
      requiredElements[i].classList.remove('error');
    }
  }
}

//clear the form of error tags upon being reset
function resetForm(input){
  var requiredElements = document.querySelectorAll('input.required');
  for(var i = 0; i < requiredElements.length; i++){
    requiredElements[i].classList.remove('error');
  }
}
