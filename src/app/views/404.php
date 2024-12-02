<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Not Found</title>
</head>

<body>
    <h1>404 - Page not found...</h1>

    <h4>Request data:</h4>
    <p>URI: <?= $_SERVER['REQUEST_URI'] ?></p>
    <p>METHOD: <?= $_SERVER['REQUEST_METHOD'] ?></p>
    <p>TIME: <?= $_SERVER['REQUEST_TIME'] ?></p>
</body>

</html>