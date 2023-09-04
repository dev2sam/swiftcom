<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- <script src="https://kit.fontawesome.com/a076d05399.js"></script> -->
<script src="scripts/fontawesome.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.0/gsap.min.js"></script>
<script src="service-worker.js"></script>

<script>
//


// for service worker
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/service-worker.js');
}



// for setting the theme
var selectedTheme = localStorage.getItem("theme");
document.querySelector("html").id = selectedTheme;



// for onscreen keyboard fix
setTimeout(function() {
    let viewheight = $(window).height();
    let viewwidth = $(window).width();
    let viewport = document.querySelector("meta[name=viewport]");
    viewport.setAttribute("content", "height=" + viewheight + "px, width=" + viewwidth +
        "px, initial-scale=1.0");
}, 300);



// for pointing towards correct screen
var urlName = window.location.href;
var screenName = document.querySelector('.bottombar');
screenName = screenName.getElementsByTagName('a');

for (i = 0; i < screenName.length; i++) {

    var tabName = screenName[i].href;
    var divName2 = screenName[i].getElementsByTagName('div')[0];

    if (urlName == tabName) {
        divName2.className = "onthis";
    }

}


//
</script>