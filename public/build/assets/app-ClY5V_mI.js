(function(){function t(){document.getElementById("loader").classList.add("d-none")}window.addEventListener("load",t),[...document.querySelectorAll('[data-bs-toggle="tooltip"]')].map(e=>new bootstrap.Tooltip(e)),[...document.querySelectorAll('[data-bs-toggle="popover"]')].map(e=>new bootstrap.Popover(e));function l(){let e=document.querySelector("html");e.getAttribute("data-theme-mode")==="dark"?(e.setAttribute("data-theme-mode","light"),e.setAttribute("data-header-styles","gradient"),e.setAttribute("data-menu-styles","dark"),e.removeAttribute("data-bg-theme"),e.removeAttribute("data-default-header-styles"),localStorage.getItem("primaryRGB")||e.setAttribute("style",""),document.querySelector("#switcher-canvas")&&(document.querySelector("#switcher-light-theme").checked=!0,document.querySelector("#switcher-menu-light").checked=!0),document.querySelector("html").style.removeProperty("--body-bg-rgb",localStorage.bodyBgRGB),e.style.removeProperty("--light-rgb"),e.style.removeProperty("--form-control-bg"),e.style.removeProperty("--input-border"),document.querySelector("#switcher-canvas")&&(document.querySelector("#switcher-header-gradient").checked=!0,document.querySelector("#switcher-menu-light").checked=!0,document.querySelector("#switcher-light-theme").checked=!0,document.querySelector("#switcher-background4").checked=!1,document.querySelector("#switcher-background3").checked=!1,document.querySelector("#switcher-background2").checked=!1,document.querySelector("#switcher-background1").checked=!1,document.querySelector("#switcher-background").checked=!1),localStorage.removeItem("velvetdarktheme"),localStorage.removeItem("velvetMenu"),localStorage.removeItem("velvetHeader"),localStorage.removeItem("velvetDefaultHeader"),localStorage.removeItem("bodylightRGB"),localStorage.removeItem("bodyBgRGB"),localStorage.getItem("velvetlayout")=="horizontal"&&e.setAttribute("data-menu-styles","gradient"),e.setAttribute("data-header-styles","gradient")):(e.setAttribute("data-theme-mode","dark"),e.setAttribute("data-header-styles","gradient"),e.setAttribute("data-menu-styles","dark"),e.removeAttribute("data-default-header-styles"),localStorage.getItem("primaryRGB")||e.setAttribute("style",""),document.querySelector("#switcher-canvas")&&(document.querySelector("#switcher-dark-theme").checked=!0,document.querySelector("#switcher-menu-dark").checked=!0,document.querySelector("#switcher-header-gradient").checked=!0,document.querySelector("#switcher-menu-dark").checked=!0,document.querySelector("#switcher-header-dark").checked=!0,document.querySelector("#switcher-dark-theme").checked=!0,document.querySelector("#switcher-background4").checked=!1,document.querySelector("#switcher-background3").checked=!1,document.querySelector("#switcher-background2").checked=!1,document.querySelector("#switcher-background1").checked=!1,document.querySelector("#switcher-background").checked=!1),localStorage.setItem("velvetdarktheme","true"),localStorage.setItem("velvetMenu","dark"),localStorage.setItem("velvetHeader","gradient"),localStorage.removeItem("velvetDefaultHeader"),localStorage.removeItem("bodylightRGB"),localStorage.removeItem("bodyBgRGB"))}document.querySelector(".layout-setting").addEventListener("click",l),document.addEventListener("DOMContentLoaded",function(){var e=document.querySelectorAll("[data-trigger]");for(let d=0;d<e.length;++d){var c=e[d];new Choices(c,{allowHTML:!0,placeholderValue:"This is a placeholder set in the config",searchPlaceholderValue:"Search"})}}),document.getElementById("year").innerHTML=new Date().getFullYear(),Waves.attach(".btn-wave",["waves-light"]),Waves.init();let i=".card";document.querySelectorAll('[data-bs-toggle="card-remove"]').forEach(e=>{e.addEventListener("click",function(c){return c.preventDefault(),this.closest(i).remove(),!1})}),document.querySelectorAll('[data-bs-toggle="card-fullscreen"]').forEach(e=>{e.addEventListener("click",function(c){let u=this.closest(i);return u.classList.toggle("card-fullscreen"),u.classList.remove("card-collapsed"),c.preventDefault(),!1})});var a=1;setInterval(()=>{document.querySelectorAll(".count-up").forEach(e=>{e.getAttribute("data-count")>=a&&(a=a+1,e.innerText=a)})},10);const s=document.querySelector(".scrollToTop"),m=document.documentElement;window.onscroll=()=>{m.scrollHeight-m.clientHeight,window.scrollY>100?s.style.display="flex":s.style.display="none"},s.onclick=()=>{window.scrollTo(0,0)};var h=document.getElementById("header-notification-scroll");new SimpleBar(h,{autoHide:!0});var g=document.getElementById("header-cart-items-scroll");new SimpleBar(g,{autoHide:!0}),document.querySelector("#typehead").addEventListener("click",y),document.body.addEventListener("click",S)})();function y(t){t.preventDefault(),t.stopPropagation(),document.querySelector("#headersearch").classList.add("searchdrop")}function S(t){let r=document.querySelector("#headersearch");t.target.classList.contains("header-search")||t.target.closest(".header-search")||r.classList.remove("searchdrop")}var o=document.documentElement;window.openFullscreen=function(){let t=document.querySelector(".full-screen-open"),r=document.querySelector(".full-screen-close");!document.fullscreenElement&&!document.webkitFullscreenElement&&!document.msFullscreenElement?(o.requestFullscreen?o.requestFullscreen():o.webkitRequestFullscreen?o.webkitRequestFullscreen():o.msRequestFullscreen&&o.msRequestFullscreen(),r.classList.add("d-block"),r.classList.remove("d-none"),t.classList.add("d-none")):(document.exitFullscreen?document.exitFullscreen():document.webkitExitFullscreen?(document.webkitExitFullscreen(),console.log("working")):document.msExitFullscreen&&document.msExitFullscreen(),r.classList.remove("d-block"),t.classList.remove("d-none"),r.classList.add("d-none"),t.classList.add("d-block"))};let v=document.querySelectorAll(".toggle");v.forEach(t=>t.addEventListener("click",()=>{t.classList.toggle("on")}));const p=document.querySelectorAll(".dropdown-item-close");p.forEach(t=>{t.addEventListener("click",r=>{if(r.preventDefault(),r.stopPropagation(),t.parentNode.parentNode.parentNode.parentNode.parentNode.remove(),document.getElementById("cart-data").innerText=`${document.querySelectorAll(".dropdown-item-close").length} Items`,document.getElementById("cart-icon-badge").innerText=`${document.querySelectorAll(".dropdown-item-close").length}`,console.log(document.getElementById("header-cart-items-scroll").children.length),document.querySelectorAll(".dropdown-item-close").length==0){let n=document.querySelector(".empty-header-item"),l=document.querySelector(".empty-item");n.classList.add("d-none"),l.classList.remove("d-none")}})});const f=document.querySelectorAll(".dropdown-item-close1");f.forEach(t=>{t.addEventListener("click",r=>{if(r.preventDefault(),r.stopPropagation(),t.parentNode.parentNode.parentNode.parentNode.remove(),document.getElementById("notifiation-data").innerText=`${document.querySelectorAll(".dropdown-item-close1").length} Unread`,document.getElementById("notification-icon-badge").innerText=`${document.querySelectorAll(".dropdown-item-close1").length}`,document.querySelectorAll(".dropdown-item-close1").length==0){let n=document.querySelector(".empty-header-item1"),l=document.querySelector(".empty-item1");n.classList.add("d-none"),l.classList.remove("d-none")}})});