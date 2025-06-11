<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scroll Animation</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;


        }

        .container {
            height: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            top: 10rem;
        }

        img {
            width: 80%;
            height: auto;
            margin-top: 10rem;
            margin-left: 5rem;
            position: absolute;
            transition: top 0.5s ease-in-out;

        }

        /*.bar {*/
        /*    position: absolute;*/
        /*    width: 100%;*/
        /*    height: 5px;*/
        /*    background-color: red;*/
        /*    bottom: 0;*/
        /*    left: 0;*/
        /*    transition: top 0.5s ease-in-out;*/
        /*}*/
    </style>
</head>
<body>
<div class="container">
{{--    <div class="ba r" id="bar"></div>--}}
    <img src="{{asset('img/image1.jpg')}}" alt="Image 1" style="z-index: 1 ;" id="image1">
    <img src="{{asset('img/image2.jpg')}}" alt="Image 2" style="z-index: 0" id="image2">
    <img src="{{asset('img/image3.jpg')}}" alt="Image 3" style="z-index: 0" id="image3">
</div>

<script>
    window.addEventListener('keydown', () => {
        // const bar = document.getElementById('bar');
        const scrollPosition = window.scrollY;
        const windowHeight = window.innerHeight;
        const containerHeight = document.querySelector('.container').offsetHeight;
        const scrollHeight = document.body.scrollHeight;
        console.log(scrollPosition);

        if(scrollPosition >= 0 && scrollPosition < 1) {
            document.getElementById('image1').style.zIndex = 0;
            document.getElementById('image2').style.zIndex = 1;

        }else if (scrollPosition > 1 && scrollPosition < 2) {
            document.getElementById('image1').style.zIndex = 0;
            document.getElementById('image2').style.zIndex = 0;
            document.getElementById('image3').style.zIndex = 1;

        }
    });
</script>
</body>
</html>
