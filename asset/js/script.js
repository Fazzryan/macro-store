// window.addEventListener("scroll", function () {
//     const navbar = document.querySelector('.navbar');
//     if (window.pageYOffset > 0) {
//         navbar.classList.add("nav-shadow");
//         navbar.classList.add("shadow-sm");
//     } else {
//         navbar.classList.remove("nav-shadow");
//         navbar.classList.remove("shadow-sm");
//     }
// });
window.addEventListener("scroll", function () {
    const contentHeader = document.querySelector('.content-header');
    if (window.pageYOffset > 0) {
        contentHeader.classList.add("content-header-on");
    } else {
        contentHeader.classList.remove("content-header-on");
    }
});

const navbarNav = document.querySelector('.navbar-nav');
const content = document.querySelector('#content');
const btnSidebar = document.querySelector('#sidebarCollapse');
btnSidebar.addEventListener("click", function () {
    navbarNav.classList.toggle("on");
    content.classList.toggle("on");
});


const btnClose = document.querySelector('.btn-close');
btnClose.addEventListener("click", function (e) {
    navbarNav.classList.remove("on");
    content.classList.remove("on");
});

function openFullscreen() {
    var imgSrc = event.target.src;
    var fullscreenImg = document.querySelector('#fullscreen img');
    fullscreenImg.src = imgSrc;
    document.getElementById('fullscreen').style.display = 'flex';
}

function closeFullscreen() {
    document.getElementById('fullscreen').style.display = 'none';
}
