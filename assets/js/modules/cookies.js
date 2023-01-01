const getCookie = (cname) => {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
  }
  return "";
}


  
const setCookie = (cname, cvalue, exdays) => {
  const d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}


const checkCookie = (cname) => {
  let cookie = getCookie(cname);
  if (cookie != "") {
    return true;
  } else {
    return false;
  }
}

const generateToken = () => {
    var rand = function() {
      return Math.random().toString(36).substr(2); // remove `0.`
  };

  var token = function() {
      return rand() + "." + new Date().getTime() + "." + rand();
  };

  return token();
}