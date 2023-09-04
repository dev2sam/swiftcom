<?php 


require '../_0path.php';
require ROOTPATH.'/includes/permanent.php';
require ROOTPATH.'/includes/functions.php';


?>


<title>SwfitCom | Help center</title>
<?php include '../includes/1tagsnlinks2.php'; ?>

</head>

<body>



    <section class="settings_tab">

        <?php include '../includes/2swiftcom.php'; ?>


        <div class="main_tab">

            <div class="top">
                <a href="../_2settings.php"><i class="fas fa-chevron-left"></i></a>
                <h1>Help & support</h1>
            </div>

            <div class="mid help">

                <form action="help.php" method="POST">
                    <p>What is concern related to?</p>
                    <select name="concern">
                        <option value="Request a feature">Request a feature</option>
                        <option value="Report a bug">Report a bug</option>
                        <option value="Report criminal activity or violence">Report criminal activity or violence
                        </option>
                        <option value="Rate quality and experience">Rate quality and experience</option>
                        <option value="Other">Other</option>
                    </select>
                    <p>Your full name</p>
                    <input type="text" name="name">
                    <p>Email</p>
                    <input type="text" name="email">
                    <p>Describe your concern</p>
                    <textarea name="message"></textarea>

                    <button name="submit_contact">Submit</button>
                </form>

            </div>

            <div class="bottom help">
                <p><a href="policy.php">Terms & Privacy Policy →</a></p>
            </div>


        </div>

    </section>





    <?php include '../includes/4scripts2.php'; ?>
</body>

</html>