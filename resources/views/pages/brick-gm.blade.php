<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>It's a game</title>

    <style>
        @font-face {
            font-family: myFirstFont;
            src: url('{{ asset("storage/fonts/joystix-monospace.otf") }}');
        }

        html,
        body {
            height: 100%;
            margin: 0;
            font-family: myFirstFont;
            /* font-family: Arial, Helvetica, sans-serif; */
        }

        body {
            color: #240A34;
            background: #891652;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        canvas {
            background: #FFEDD8;
            /* border: 1px solid #240A34; */
            border-radius: 8px;
            /* box-shadow: 2px 2px 8px #000000; */
        }

        li {
            padding-bottom: 8px;
        }

        h2,
        .para {
            margin: 2px;
            margin-bottom: 4px;
        }

        ul {
            padding-left: 24px;
            padding-right: 16px;
        }

        .container {
            /* width: 100%; */
            margin: 8px;
            background: #FFEDD8;
            border-radius: 8px;
            padding: 8px;
        }

        .next-block {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 16px;
            /* height: 200px; */
        }

        .details-corner {
            width: 250px;
        }

        .copyright {
            color: #FFEDD8;
            position: absolute;
            bottom: 15px;
            right: 15px;
        }

        p,
        li {
            font-size: 12px;
        }

        .d-flex {
            display: flex;
        }
    </style>
</head>

<body>
    <canvas width="320" height="640" id="game"></canvas>

    <div class="details-corner ">
        <div class="container " style="text-align: center;">
            <h2>Tetris</h2>
        </div>
        <div style="display: flex; justify-content: center;">
            <canvas width="192" height="auto" id="block" style="margin: 8px;"></canvas>
        </div>

        <div class="container ">
            <div class="d-flex">
                <h2>Score:</h2>
                <h2 id="score">0</h2>
            </div>
            <div class="d-flex">
                <p class="para">Level:</p>
                <p class="para" id="level">0</p>
            </div>

            <div class="d-flex">
                <p class="para">High Score:</p>
                <p class="para" id="highScore">0</p>
            </div>
            <div class="d-flex">
                <p class="para">Lines Cleared:</p>
                <p class="para" id="lines">0</p>
            </div>
        </div>

        <div class="container ">
            <p>Controls to Play</p>
            <ul>
                <li>To start just click the game</li>
                <li>A, Left key moves Block Left</li>
                <li>D, Right key moves Block Right</li>
                <li>S, Down key moves Block Down</li>
                <li>Enter, Space, Up key Rotates Block</li>
            </ul>
        </div>
    </div>

    <!-- audios -->
    <audio id="blk_plc_dwn">
        <source src="{{ asset("storage/sounds/land_0.wav") }}" type="audio/mp3">
    </audio>
    <audio id="blk_dsy">
        <source src="{{ asset("storage/sounds/destroyed_0.wav") }}" type="audio/mp3">
    </audio>
    <audio id="lv_up">
        <source src="{{ asset("storage/sounds/level_up.ogg") }}" type="audio/mp3">
    </audio>
    <audio id="gm_end">
        <source src="{{ asset("storage/sounds/gameOverEnd.ogg") }}" type="audio/mp3">
    </audio>

    <span class="copyright">Mr. Dirtiest Rat (Leal)</span>

    <!-- link scripts -->
    <script src="{{ asset("storage/js/brick-gm.js") }}"></script>
</body>

</html>
