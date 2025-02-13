<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<!-- resources/views/import.blade.php -->

<form action="{{ url('importar') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="file">Escolha um arquivo CSV:</label>
    <input type="file" name="file" required>
    <button type="submit">Importar</button>
</form>

@if (session('success'))
    <div style="color: green;">
        {{ session('success') }}
    </div>
@endif

</body>
</html>