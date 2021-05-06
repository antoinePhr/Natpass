const filter = document.querySelector('.filter')
//formualaire bar de recherche homepage
const formsSearchBar = document.querySelector('.searchBar>form')
/* var pour animation du menu login */
const body = document.querySelector('body')
const homeSection = document.querySelector('.homeSection')

/* var pour animation du menu des filtres */
const panelFilter = document.querySelector('.panelFilter')
const btnOpenFilter = document.querySelector('.optFilter>button')
const formFilter = document.querySelector('.panelFilter>form')
const btnSendFormFilter = document.querySelector('.buttonValidFilter>button')

/* var pour copy des value input pour passer a php form*/
const cpyKeyWordSearch = document.querySelector('.copyKeyWordSearch>input')
const originalKeyWordSearch = document.querySelector('.originalKeyWordSearch')

/* var pour ACTUALISATION ET CONSERVATIONS DES OPTIONS CHOISIES*/
const selectedPannels = document.querySelectorAll('select')

//var pour sidebar et video container
const videoSection = document.querySelector('.videos')
const sidebar = document.querySelector('.sideBar')
const videosContainer = document.querySelector('.videosContainer')
const miniature = document.querySelector('.miniature')
const header = document.querySelector('header')
const headerNav = document.querySelector('header>nav')

//var pour page lecon 
const lessonContainer = document.querySelector('.lessonContainer')
const lessonVideo = document.querySelector('.lessonVideo')
const jsMarg = document.querySelector('.jsMarginContainer')


const pageLinks = document.querySelectorAll('.pages>a')

const videos = document.querySelectorAll(".video") 
const videoLink = document.querySelectorAll(".lessonsBtn>a")

// var pour regler les problem d'affichage des videos 2 et 4 et 5
const flexContainer = document.querySelectorAll('.flexContainer')

const sectionTitleVideo = document.querySelector('.sectionVideoTitle')
const footer = document.querySelector("footer")
const maps = document.querySelector('.maps')

/*HAMBURGER NAV*/ 
const ham = document.querySelector('.hamburger')

window.addEventListener('DOMContentLoaded', function(){
    isSideBar()

    if(footer && maps){
        const footerTop = (parseInt(getComputedStyle(maps).height) - parseInt(getComputedStyle(footer).height))
        footer.style.top= footerTop + 10 + "px"
    }

    // réduction de la height du header onscroll 
    window.addEventListener('scroll', function(){
        setTimeout(() => {
            if(window.scrollY > 100){
                header.style.height="80px"
                header.style.boxShadow="0 1px 17px -3px rgb(0 0 0 / 50%)"
            }
            else{
                header.style.height="100px"
                header.style.boxShadow="none"
            }
        }, 200);
    })

    const perPage = 6
    // ajout de faux flex container pour remplir la page et placer les div à leur bonne position
        switch (flexContainer.length) {
            case 2:
                for(var i = 0; i < (perPage - flexContainer.length); i++ ){
                  var C_flexContainer = document.createElement("div")
                  C_flexContainer.setAttribute("class", "flexContainer")
                  C_flexContainer.style.width = getComputedStyle(flexContainer[0]).width
                  videosContainer.insertAdjacentElement('beforeend', C_flexContainer)                    
                }

                break;
            case 4:
                for(var i = 0; i < (perPage - flexContainer.length); i++ ){
                    var C_flexContainer = document.createElement("div")
                    C_flexContainer.setAttribute("class", "flexContainer")
                    C_flexContainer.style.width = getComputedStyle(flexContainer[0]).width
                    videosContainer.insertAdjacentElement('beforeend', C_flexContainer)  

                  }
                break;
            case 5:
                for(var i = 0; i < (perPage - flexContainer.length); i++ ){
                    var C_flexContainer = document.createElement("div")
                    C_flexContainer.setAttribute("class", "flexContainer")
                    C_flexContainer.style.width = getComputedStyle(flexContainer[0]).width
                    videosContainer.insertAdjacentElement('beforeend', C_flexContainer)  
                  }
                break;
        }
    if(panelFilter){
        selectedPannels.forEach(select => {
            type = select.getAttribute('name')
            switch (type) {
                case 'nageur':
                    var disableSelect = document.getElementsByName('niveau')[0] // recuperer select incompatible
                    if(select.value != ''){
                        disableSelect.setAttribute('disabled', 'disabled') // desacivation
                    }
                    else{
                        if(disableSelect.getAttribute('disabled')){
                            disableSelect.removeAttribute('disabled') // si sans preference = réactivation
                        }
                    }
                break;
            
                case 'club':
                case 'niveau':
                    both = [document.getElementsByName('club')[0], document.getElementsByName('niveau')[0]] // ajout des deux sleect dans un tableaux pour la suite
                    var disableSelect = document.getElementsByName('nageur')[0] // recuperer select incompatible

                    //empeche le grisement de nageur si club et nageur on des valeurs (au submit = refresh)
                    if(both[0].value != '' && disableSelect.value != ''){ 
                        return
                    }
                    if(select.value != '') {
                        disableSelect.setAttribute('disabled', 'disabled') // desacivation
                    }
                    else{
                        if(disableSelect.getAttribute('disabled') && both[0].value == '' && both[1].value == ''){
                            disableSelect.removeAttribute('disabled') // si sans preference = réactivation
                        }
                    }
                break;
                
                default:
                break;
            }
        })
        panelFilter.style.marginTop = getComputedStyle(header).height
        panelFilter.style.paddingLeft = parseInt(getComputedStyle(sidebar).width) + 25 + "px"
    }

    if(pageLinks.length > 0){
       pageLinks[0].classList.add('active')
    }


    if(header && sectionTitleVideo && getComputedStyle(header).position == "fixed"){
        sectionTitleVideo.style.marginTop = parseInt(getComputedStyle(header).height) + 25 + "px"
    }
    else if (header && lessonVideo && getComputedStyle(header).position == "fixed"){
        lessonVideo.style.marginTop = parseInt(getComputedStyle(header).height) + "px"
    }

    //affichage en couleur du button de la page courante recuperer via l'url
    if(window.location.href.includes("?page=") || window.location.href.includes("&page=") ){
        var linkAttri = window.location.href.substr(-7)
        pageLinks.forEach(link => {
            var updateAttri = link.getAttribute("href").substr(-7)
            
            if(updateAttri == linkAttri){
                link.classList.add('active')
            }
            else if (updateAttri != linkAttri){
                if(link.classList.contains('active')){
                    link.classList.remove('active')
                }
            }
        })
        
    }

    
})


// copy des valeurs original de l'intput mot clé pour copier dans la copy de celui
// afin de recuperer sa valeur pour l'ajouter à la requete des filtres
if(originalKeyWordSearch){
    originalKeyWordSearch.addEventListener('input', function(){
        cpyKeyWordSearch.setAttribute('value', originalKeyWordSearch.value)
    })
}

// mettage en session de la valeur de l'input avant le submit pour pouvoir remettre sa valeur apres le refresh
//A CONTINUIER  

// DESACTIVATION DES FILTRES INCOMPATIBLE pour la rechercher example : filtre nageur et niveau
if(selectedPannels){
    selectedPannels.forEach(select => {
        select.addEventListener('change', function(){
            type = select.getAttribute('name')
            switch (type) {
                case 'nageur':
                    var disableSelect = document.getElementsByName('niveau')[0] // recuperer select incompatible
                    if(select.value != ''){
                        disableSelect.setAttribute('disabled', 'disabled') // desacivation
                    }
                    else{
                        if(disableSelect.getAttribute('disabled')){
                            disableSelect.removeAttribute('disabled') // si sans preference = réactivation
                        }
                    }
                break;
            
                case 'club':
                case 'niveau':
                    both = [document.getElementsByName('club')[0], document.getElementsByName('niveau')[0]] // ajout des deux sleect dans un tableaux pour la suite
                    var disableSelect = document.getElementsByName('nageur')[0] // recuperer select incompatible
                    if(both[0].value != '' && disableSelect.value != ''){
                        return
                    }
                    if(select.value != '') {
                        disableSelect.setAttribute('disabled', 'disabled') // desacivation
                    }
                    else{
                        if(disableSelect.getAttribute('disabled') && both[0].value == '' && both[1].value == ''){
                            disableSelect.removeAttribute('disabled') // si sans preference = réactivation
                        }
                    }
                break;
                
                default:
                break;
            }
        })
    })
}
if(formsSearchBar){
formsSearchBar.addEventListener('submit', function(e){
        if(panelFilter.classList.contains('active')){
            e.preventDefault();
            btnSendFormFilter.classList.add('active')
            setTimeout(() => {
                btnSendFormFilter.classList.remove('active')
            }, 1500);
        }
    })
}


videos.forEach(video =>{
    video.addEventListener("click", function(){
        video.lastElementChild.firstChild.click()
    })
})



const lessonsContainer = document.querySelector('.lessonContainer')
const navHistoryLinks = document.querySelectorAll('.histNav>a')
function isSideBar(){ 
    var sidebar = document.querySelector('.sideBar')
    if(sidebar != null){
       
        setCurrentSibarElem()
        const logoClub = document.querySelector('.logo')
        if(logoClub)
            logoClub.style.display="none"
        if(headerNav)
            headerNav.style.justifyContent="center"
        navHistoryLinks.forEach(navLinksHist => {
            if(navLinksHist.textContent.includes("login")){
                navLinksHist.classList.add('disabled')
            }
        })
        if(videosContainer){
            videosContainer.style.width = "95%"
        }
        if(header && window.matchMedia("(min-width: 1010px)").matches){
            if(window.matchMedia("(max-width: 1260px)").matches){
                jsMarg.style.margin= "50px 25px 0px " +(sidebar.getClientRects()[0].width +25)  + "px";
            }
            else{
                jsMarg.style.margin= "50px 0px 0px " +(sidebar.getClientRects()[0].width +25)  + "px";
            }
            header.style.paddingLeft= sidebar.getClientRects()[0].width + "px"
            header.style.margin="0 auto"
            header.style.width= "100%"
            header.style.paddingLeft = parseInt(getComputedStyle(sidebar).width) + "px"
            if(videosContainer)
                videosContainer.style.padding="50px 20px 0px 20px"
        }
        
        if(window.matchMedia("(max-width: 1010px)").matches){
            ham.addEventListener('click', function(){
                const filter = document.querySelector('.filter')
                sidebar.classList.toggle('active')
                filter.classList.toggle('active')
                if(sidebar.classList.contains('active')){
                    body.style.overflow="hidden"
                }
                else{
                    body.style.overflow="unset"
                }
    
                filter.addEventListener('click', function(){
                    if(sidebar.classList.contains('active')){
                        sidebar.classList.remove('active')
                        filter.classList.remove('active')
                        body.style.overflow="auto"
                    }
                })
            })
        }

        if(window.matchMedia("(min-width: 720px) and (max-width: 1200px)").matches){
           flexContainer.forEach(flex =>{
               flex.style.width="300px"
           })
        }
        else if(window.matchMedia('(max-width: 720px)').matches){
            flexContainer.forEach(flex =>{
                flex.style.width="100%"
            })
        }
    }
}

// actualise la navigation courante de la sidebar
function setCurrentSibarElem(){
    const elemNavBar = document.querySelectorAll('.sideBar>nav>ul>li')
    const url = window.location.href.split("/")[3]
    elemNavBar.forEach(el =>{
        if(el.classList.contains('active')){
            el.classList.remove('active')
        }
    })
    switch (url) {
        case "":
            elemNavBar[0].classList.add('active')
            break;
        case "favoris":
            elemNavBar[1].classList.add('active')
            break;
        case "historique":
            elemNavBar[2].classList.add('active')
            break;
        case "importation":
            elemNavBar[3].classList.add('active')
            break;
    
        default:
            break;
    }
}


