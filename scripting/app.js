



function changeToInt(){
  let input = document.querySelector(".changeToInt").value;
  // conversion from string to integer
  if(isNaN(input)) return 0; // value is not a number
  let value = parseInt(input);
}

function showAccountDetails(){
  
a = document.querySelector(".accountDetails");
u = document.querySelector(".userBalance");
u.style.display="none";
a.style.display="block";
}







function hideAccountDetails(){
  a = document.querySelector(".accountDetails");
  a = document.querySelector(".accountDetails");
  u = document.querySelector(".userBalance");

  u.style.display="block";
  a.style.display="none";
}



function hideSendMoney(){
  s = document.querySelector(".sendMoney");
  u = document.querySelector(".userBalance");

  u.style.display="block";
  s.style.display="none";
}


function showSendMoney(){
  
  s = document.querySelector(".sendMoney");
  u = document.querySelector(".userBalance");
  u.style.display="none";
  s.style.display="block";
  }
  
  function showExchangeMoney(){
  
    e = document.querySelector(".exchangeMoney");
    u = document.querySelector(".userBalance");
    u.style.display="none";
    e.style.display="block";
    }
    






