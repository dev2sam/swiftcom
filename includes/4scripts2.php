<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="../scripts/fontawesome.js"></script>


<script>
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
</script>