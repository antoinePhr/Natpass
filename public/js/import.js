
var textAreas = document.querySelectorAll('textarea')
var importContainer = document.querySelector('.importContainer')
const videoChoice = document.querySelector('.videoChoice')
const inputFile =  document.querySelector('input[type="file"]')
const videoInfo = document.querySelector('.videoInfo')
const insertAfterEl = document.querySelector('.lessonVideo')


//INPUTS 

const impTitleVideo = document.querySelector('.titleContainer')
const impDescriVideo = document.querySelector('.lessonInfo>p:last-child')
const impAnalyseVideo = document.querySelector('.lessonAnalyse>p:last-child')
const lessonTags = document.querySelector(".tags>ul")


window.addEventListener('DOMContentLoaded', function(){
  let sidebarWidth = parseInt(getComputedStyle(sidebar).width)/2
  importContainer.style.left= "calc(50% + " + sidebarWidth + "px" + ")";

})
videoChoice.addEventListener('click', function(){
  inputFile.click()
})

inputFile.addEventListener('change', function(e){
  const preview = document.querySelector('.preview')
  if(window.matchMedia("(max-width: 1250px)")){
      
      preview.style.padding="0px 25px"

      importContainer.style.marginLeft=getComputedStyle(sidebar).width
      importContainer.style.padding="unset"
      importContainer.style.position="unset"
      importContainer.style.top="unset"
      importContainer.style.width="unset"
      importContainer.style.transform= "translate(0px, 0px)"
  }
  else{
    importContainer.style.top=""
  }

  videoInfo.classList.add('active')
  preview.classList.add('active')
  
  let file = e.target.files[0];
  
  loadPreview(file)

  videoChoice.style.display="none"
  //creation video 

})


textAreas.forEach(textarea =>{
  textarea.addEventListener('click', function(){
        autosize(textarea);
    
  })
  textarea.addEventListener('focus', function(){
    textarea.style.width="300px"
  })

  textarea.addEventListener('change', function(){
    //NIQUE BIEN TA MERE LA SALE PUTE SALE CHIEN DE LACASSE LA GROSSE SALOPE DFE TES MORTS
  })

  textarea.addEventListener('input', function(){
    switch (textarea.getAttribute("name")) {
      case "videoName":
            impTitleVideo.innerText =  textarea.value 
        break;
      
      case "videoDescription":
          impDescriVideo.innerText = textarea.value
        break;

      case "videoAnalyse":
        impAnalyseVideo.innerText = textarea.value
      break;

      default:
        break;
    }


  })
})


// affiche la preview de la vidéo
function loadPreview(file){
  let blobURL = URL.createObjectURL(file);
  var video = document.createElement('video')
  video.src = blobURL;
  video.setAttribute("controls", "true")

  insertAfterEl.insertAdjacentElement("afterbegin", video)
}


