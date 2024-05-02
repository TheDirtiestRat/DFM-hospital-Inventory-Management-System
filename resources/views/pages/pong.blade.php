<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I am bored</title>

    <!-- links -->
    @vite(['resources/css/pongStyles.css'])
    @vite(['resources/js/pongScript.js'])
</head>
<body>
    <div class="score">
        <div id="player-score">00</div>
        <div id="computer-score">00</div>
    </div>

    <div class="ball" id="ball"></div>
    <div id="player-paddle" class="paddle left"></div>
    <div id="computer-paddle" class="paddle right"></div>
    
</body>
</html>