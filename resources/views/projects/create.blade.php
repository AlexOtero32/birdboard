<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Crear un proyecto</h1>

    <form action="/projects" method="POST">
        @csrf
        <input type="text" name="title" />
        <textarea name="description" cols="30" rows="10"></textarea>
        <input type="submit" value="Enviar">
    </form>
</body>

</html>