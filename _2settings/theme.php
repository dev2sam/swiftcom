<?php 

require '../_0path.php';
require ROOTPATH.'/includes/permanent.php';
require ROOTPATH.'/includes/functions.php';


?>


<title>SwfitCom | Themes</title>
<?php include '../includes/1tagsnlinks2.php'; ?>

</head>

<body>



    <section class="settings_tab">

        <?php include '../includes/2swiftcom.php'; ?>


        <div class="main_tab">

            <div class="top">
                <a href="../_2settings.php"><i class="fas fa-chevron-left"></i></a>
                <h1>Themes</h1>
            </div>

            <div class="mid themes">
                <div class="wrapper">
                    <div class="theme">
                        <input type="radio" name="theme" id="default">
                        <label class="label" for="default">
                            <img src="../images/themes/default.svg" alt="">
                        </label>
                    </div>
                    <div class="theme">
                        <input type="radio" name="theme" id="cataclysm">
                        <label class="label" for="cataclysm">
                            <img src="../images/themes/cataclysm.svg" alt="">
                        </label>
                    </div>
                    <div class="theme">
                        <input type="radio" name="theme" id="fuchsia">
                        <label class="label" for="fuchsia">
                            <img src="../images/themes/fuchsia.svg" alt="">
                        </label>
                    </div>
                    <div class="theme">
                        <input type="radio" name="theme" id="pink">
                        <label class="label" for="pink">
                            <img src="../images/themes/pinkblossom.svg" alt="">
                        </label>
                    </div>
                    <div class="theme">
                        <input type="radio" name="theme" id="vampire">
                        <label class="label" for="vampire">
                            <img src="../images/themes/vampire.svg" alt="">
                        </label>
                    </div>
                    <div class="theme">
                        <input type="radio" name="theme" id="candyCane">
                        <label class="label" for="candyCane">
                            <img src="../images/themes/candycane.svg" alt="">
                        </label>
                    </div>
                </div>
            </div>

            <div class="bottom"></div>

        </div>

    </section>



    <?php include '../includes/4scripts2.php'; ?>

    <script>
    $(".label").click(function() {

        // for setting theme to local storage
        var themename = $(this).attr('for');
        localStorage.setItem("theme", themename);

        // set the theme
        document.querySelector("html").id = themename;
    })


    // for marking the selected element
    var labels = document.querySelectorAll("label");
    var selectedTheme = localStorage.getItem("theme");

    labels.forEach(function(label) {

        labela = label.getAttribute("for");
        if (labela == selectedTheme) {
            label.querySelector("img").className = "selected"
        }
    })
    </script>
</body>

</html>