

function calculateTotal() {
  // Correct the querySelector calls
  let before = parseFloat(document.querySelector('.balanceBefore').innerText); // Get the current balance as a number
  let inputElement = parseFloat(document.querySelector('.inputAmount').value); // Get the amount entered in the input field

  // Add the input value to the before balance

  

  if(inputElement > before || inputElement <= 0){
    alert("Insufficient or Invalid Funds.");
  }
  else{
    let after = before + inputElement;
    let afterUpdate = after + inputElement;
    let updated = before  - inputElement;
    document.querySelector('.balanceAfter').innerHTML = after;
    document.querySelector('.balanceBefore').innerHTML = updated;
  }

  // Update the balanceAfter element with the new balance


// Log the new balance to the console
}


function changeToInt(){
  let textToNum = parseInt(document.querySelector(".changeToInt"));
}









