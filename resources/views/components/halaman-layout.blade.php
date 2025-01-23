@props(['title'])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ isset($title) ? $title : 'Halaman Default' }}</title>
</head>

<body>
    {{ $slot }}
    <h1>Halaman Layout dari Component</h1>
    <p>Tanggal: {{ $tanggal }}</p>
    <p>Penulis: {{ $penulis }}</p>
</body>

</html>
