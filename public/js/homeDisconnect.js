//PARTIE NAV HEADER LINK ACTIVE
const nav = document.querySelector('nav.nav>ul')
const navLinks = document.querySelectorAll('.nav>ul>li')
const navMobile = document.querySelector('.mobileNav')
const navMobileLinks = document.querySelectorAll('.mobileNav>ul>li')
const hamElem = document.querySelectorAll('.hamburger>div')
const courseElems = document.querySelectorAll('.exempleCourse>div')
var accueil = document.getElementById('accueil')
var about = document.getElementById('pres')
var cours = document.getElementById('courses')
var contact = document.getElementById('contact')
accueil = accueil.getBoundingClientRect().top - accueil.getBoundingClientRect().height/2
about = about.getBoundingClientRect().top - about.getBoundingClientRect().height/2
cours = cours.getBoundingClientRect().top - cours.getBoundingClientRect().height/2
contact = contact.getBoundingClientRect().top - contact.getBoundingClientRect().height/2


window.addEventListener('DOMContentLoaded', function(){
    // resposiv de la nav avec mobile detect
        navMobile.style.top = getComputedStyle(header).height
        navMobile.style.height = "calc(100vh - " + getComputedStyle(header).height + ")"

        ham.addEventListener('click', function(){
            navMobile.style.top = getComputedStyle(header).height
            navMobile.style.height = "calc(100vh - " + getComputedStyle(header).height + ")"
            navMobile.classList.toggle('active')
            filter.classList.toggle('active')
            body.classList.toggle('overflow')

            navMobileLinks.forEach(link =>{
                    link.addEventListener('click', closeNav)
                })
            hamElem.forEach(elem =>{
                elem.classList.toggle('active')
            })

        })
        //set active link on link click != onscroll
        navLinks.forEach(link =>{
        link.addEventListener('click', function(){
            if(!link.classList.contains('active'))
                link.classList.add('active')
            
            var attri = link.getAttribute('name')
            resetNavLink(navLinks, attri)    
            })
        })  

        // initialise les filtres de recherche (une fois connecté)
        if(panelFilter)
            panelFilter.style.top= getComputedStyle(header).height

        // presention courses on click go to connection page 
        courseElems.forEach(e =>{
            e.addEventListener('click', function(){
                window.location.href="/login"
            })
        })

})



window.addEventListener('scroll', function(){
    setTimeout(() => {
        if(window.scrollY <= about){
            resetNavLink(navLinks, 'accueil')
            setActiveLink('accueil')
        }
        else if(window.scrollY <=cours){
            resetNavLink(navLinks, 'about')
            setActiveLink('about')
        }
        else if(window.scrollY <= contact){
            resetNavLink(navLinks, 'cours')
            setActiveLink('cours')
    
        }
        else{
            resetNavLink(navLinks, 'contact')
            setActiveLink('contact')
        }
        if(navMobile){
            navMobile.style.top = getComputedStyle(header).height 
        }
        
    }, 200);
})




//reset toutes les classes en rapport avec le fonctionnement de la navigation mobile
function closeNav(){
    navMobile.classList.remove('active')
    filter.classList.remove('active')
    body.classList.remove('overflow')
    hamElem.forEach(elem =>{
        elem.classList.remove('active')
    })
}

//reset les classes des élements de la nav qui ne sont plus l'actuel
function resetNavLink(navLinks, attri){
    navLinks.forEach(link =>{
        if(link.getAttribute('name') != attri && link.classList.contains('active')){
            link.classList.remove('active')
        }
    })
}


// set la section courante de la nav lors du scroll de l'utilisateur (voir listenner onscroll)
function setActiveLink(attri){
    document.querySelector('li[name="' +attri+'"]').classList.add('active')
}
