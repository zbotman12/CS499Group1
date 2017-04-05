<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <title>Email sent.</title>
    </head>
    <body>
        <?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/header.php"; 
               include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";
        ?>
        <div class="container-fluid">
            <h2>Your email has been sent.</h2>
            <hr/>
            <?php echo "We've delivered your message. <br>"; ?>
        </div>
        <?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/footer.php"; ?>
    </body>
</html>