const favIcon = document.querySelectorAll('.favIcon>img')[0]
const favIconActive = document.querySelectorAll('.favIcon>img')[1]

window.addEventListener('DOMContentLoaded', function(){
    if(favIconActive.getAttribute('isFav') == '1'){
        favIconActive.classList.add('active')
    }
})

if(favIcon != null){
    favIcon.classList.add('active')
    favIcon.addEventListener('click', function(){
        if(!favIconActive.classList.contains('active')){
            favIconActive.classList.add('active')
            favIcon.classList.remove('active')
            addFav()
        }
    })
    favIconActive.addEventListener('click', function(){
        if(favIconActive.classList.contains('active')){
            favIconActive.classList.remove('active')
            favIcon.classList.add('active')
            removeFav();
        }
    })
}

function addFav() {
    var xhttp = new XMLHttpRequest(); 
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
       console.log(xhttp.responseText)
      }
      else{ console.log("error")}
    };
    let vd_id = window.location.href.split("=")[1]
    xhttp.open("GET", "https://natpass.fr/favoris?addFav=1&vd_id="+vd_id, true);
    xhttp.send();
  }
function removeFav() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
       console.log(xhttp.responseText)
      }
      else{ console.log("error")}
    };

    let vd_id = window.location.href.split("=")[1]
    xhttp.open("GET", "https://natpass.fr/favoris?delete=1&vd_id="+vd_id, true);
    xhttp.send();
  }

