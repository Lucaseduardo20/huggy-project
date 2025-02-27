<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Huggy</title>

</head>
<body>
    @vite('resources/js/app.js')
    <main class="h-full" id="app"></main>

    <script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
