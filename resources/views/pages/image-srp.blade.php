<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hi There A Reward From Leal!</title>

    @vite(['resources/js/app.js'])
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden; /* Prevents scrollbars when the image rapidly expands */
        }

        /* The Jumpscare Animation Class */
        .jumpscare-anim {
            /* 0.15s duration makes it aggressive and sudden */
            animation: popOut 0.15s ease-out forwards;
            position: relative;
            z-index: 9999;
        }

        @keyframes popOut {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            80% {
                /* Overshoots its target size to give a "punch" effect */
                transform: scale(1.8);
                opacity: 1;
            }
            100% {
                /* Settles at a very large size */
                transform: scale(1.5);
                opacity: 1;
            }
        }
    </style>
</head>

<body class="bg-black">
    <div>
        <img src="{{ asset('/storage/images/jeffy.jpg') }}" id="Hiee" alt="" width="500px">
        <!-- Fixed the typo 'text-ligh' to 'text-light' so it shows on the black background -->
        <div class="spinner-border text-light" style="width: 3rem; height: 3rem;" id="spin" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <script>
        document.getElementById("Hiee").style.display = "none";
        setTimeout(myTimer, 8000);

        function myTimer() {
            const img = document.getElementById("Hiee");
            
            // Show the image and attach the animation class
            img.style.display = "block";
            img.classList.add("jumpscare-anim");
            
            // Hide the spinner
            document.getElementById("spin").style.display = "none";

            /* 
             * OPTIONAL: Jumpscares are 90% audio! 
             * Uncomment the lines below and add an audio file path to play a scream 
             * exactly as the image pops out.
             */
            // let scream = new Audio('{{ asset("/storage/sounds/scream.mp3") }}');
            // scream.play();
        }
    </script>
</body>

</html>
{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hi There A Reward From Leal!</title>

    @vite(['resources/js/app.js'])
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
    </style>
</head>

<body class="bg-black ">
    <div>
        <img src="{{ asset('/storage/images/jeffy.jpg') }}" id="Hiee" alt="" width="500px">
        <div class="spinner-border text-ligh" style="width: 3rem; height: 3rem;" id="spin" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</body>

<script>
    document.getElementById("Hiee").style.display = "none";
    setTimeout(myTimer, 8000);

    function myTimer() {
        document.getElementById("Hiee").style.display = "block";
        document.getElementById("spin").style.display = "none";
    }
</script>

</html> --}}
