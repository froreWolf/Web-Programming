window.addEventListener('load', function(){
//get a list of the elements that have the class hilightable
  var hilightable = document.querySelectorAll('input.hilightable');
  for(var i = 0; i < hilightable.length; i++){
    //add the focus events
    hilightable[i].addEventListener('focus', function(){
    hilightable[i].classList.add('highlight');
    });
    //add blur events
    hilightable[i].addEventListener('blur', function(){
    hilightable[i].classList.remove('highlight');
    });
  };
});
