<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <title>Email failed.</title>
    </head>
    <body>
        <?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/header.php"; ?>
        <div class="container-fluid">
            <h2>We could not send your email.</h2>
            <hr/>
            <?php echo "Please try again or contact the system administrator. <br>"; ?>
        </div>
        <?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/footer.php"; ?>
    </body>
</html>