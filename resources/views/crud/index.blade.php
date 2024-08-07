<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <form action="add" method="post">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-controll" name="name">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-controll" name="email">
        </div>
        <div class="form-group">
            <button type="submit">SAVE</button>
        </div>
    </form>
</div>

</body>
</html>
