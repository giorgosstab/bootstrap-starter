<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?php echo assets() . 'css/app.css'; ?>">

        <title>Home page</title>
    </head>
    <body>
        <h1>Home page</h1>
        <?php echo $data['username'] ?>
        <a href="<?php route('gg'); ?>"

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?php echo assets() . 'js/app.js'; ?>"></script>
    </body>
</html>