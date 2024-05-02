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
        }
    </style>
</head>

<body class="bg-black ">
    <div>
        <img src="{{ asset('/storage/images/jeffy.png') }}" id="Hiee" alt="" width="500px">
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

</html>
