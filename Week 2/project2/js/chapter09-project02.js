document.getElementById("thumbnails").addEventListener('click', function(e){
//e.target is the clicked element
var source = e.target
alert(source.attributes);
});

var items = document.getElementByTagName("img");
for(var i = 0; i< items.length; i++){
  items[i].textContent = 'src="images/small/5855774224.jpg" title="Battle" alt="Battle"
}
