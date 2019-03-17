/* define functions here */
function calculateTotal(quantity, price){
  return quantity * price;
}

function outputCartRow(file, title, quantity, price, total) {
  price = "$" + price.toFixed(2);
  total = "$" + total.toFixed(2);
  document.write('<tr>');
  document.write('<td><img src="images/' + file + '"</td>');
  document.write('<td>' + title + '</td>');
  document.write('<td>' + quantity + '</td>');
  document.write('<td>' + price + '</td>');
  document.write('<td>' + total + '</td>');
  document.write('</tr>')
}

function getSubtotal(){
  var subtotal = 0;
  for (i = 0; i < prices.length; i++){
     subtotal += calculateTotal(quantities[i], prices[i]);
  }

  return subtotal
}

function getTax(){
  return 0.10 * getSubtotal();
}

function getshipping(){
  if (getSubtotal() > 1000){
    return 0
  }
  else {
    return 40
  }
}

function getGrandTotal(){
  return (getSubtotal() + getTax() + getshipping())
}
