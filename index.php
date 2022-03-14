<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        .upvote {
            width: 15%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 85%;
        }

        .downvote {
            width: 15%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
        }

        .imgdiv {
            position: fixed;
            transition: 0.3s;
            width: 70%;
            height: 100%;
            left: 15%;
            top: 0;
        }

        .image {
            position: absolute;
            margin: auto;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 5%;
            transition: all 1s;
        }

        .btn {
            border-radius: 100%;
            background-color: transparent;
        }

        .btn1 {
            content: "👇";
        }

        .btn2 {
            content: "👆";
        }
    </style>
    <script>
        function addTransform(name) {
            var obj = document.getElementById(name);
            obj.style.transform = "scale(1.5,1.5)";
        }

        function removeTransform(name) {
            var obj = document.getElementById(name);
            obj.style.transform = "scale(1,1)";
        }

        function removeTransition(name) {
            var obj = document.getElementById(name);
            obj.style.transition = "none";
            obj.style.transform = "none";
        }

        function vote(arg) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'vote.php?vote=' + arg + "&&height=" + window.innerHeight + "&&width=" + window.innerWidth, true);
            xhr.onload = function() {
                if (this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    var top = document.getElementById("top");
                    var bottom = document.getElementById('bottom');
                    if (top.style.opacity != "0") {
                        removeTransition('top');
                        top.style.visibility = 'hidden';
                        top.style.opacity = "0";
                        top.setAttribute("onmouseenter", '');
                        top.setAttribute("onmouseleave", '');
                        top.setAttribute('src', data.path);
                        top.setAttribute('height', data.height);
                        top.setAttribute('width', data.width);

                        bottom.style.transition = "all 1s ease-in";
                        bottom.style.visibility = 'visible';
                        bottom.style.opacity = "1";
                        bottom.setAttribute("onmouseenter", "addTransform('bottom')");
                        bottom.setAttribute("onmouseleave", "removeTransform('bottom')");

                    } else {
                        removeTransition('bottom');
                        bottom.setAttribute("onmouseenter", '');
                        bottom.setAttribute("onmouseleave", '');
                        bottom.style.visibility = 'hidden';
                        bottom.style.opacity = "0";
                        bottom.setAttribute('src', data.path);
                        bottom.setAttribute('height', data.height);
                        bottom.setAttribute('width', data.width);

                        top.style.transition = "all 1s ease-in";
                        top.style.visibility = 'visible';
                        top.style.opacity = "1";
                        top.setAttribute("onmouseenter", "addTransform('top')");
                        top.setAttribute("onmouseleave", "removeTransform('top')");
                    }
                }
            }
            xhr.send();
        }

        function loadImage() {
            var xhr = new XMLHttpRequest();
            var w = window.innerWidth;
            var h = window.innerHeight;
            xhr.open("GET", "return_data.php?height=" + h + "&&width=" + w, true);

            xhr.onload = function() {
                if (this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    var img = document.getElementById('top');
                    img.setAttribute('src', data[0].image_path);
                    img.setAttribute('height', data[0].height);
                    img.setAttribute('width', data[0].width);

                    var img = document.getElementById('bottom');
                    img.setAttribute('src', data[1].image_path);
                    img.setAttribute('height', data[1].height);
                    img.setAttribute('width', data[1].width);
                }
            }
            xhr.send();
        }

        window.onload = loadImage();
    </script>

</head>

<body>
    <div id="downvote" class='downvote' onclick="vote(0)"></div>

    <div id="imgdiv" class='imgdiv'>
        <button class='btn btn1'>👇</button>
        <img src="" id="bottom" class="image" style="opacity:0;visibility:hidden">
        <img src="" id="top" class="image" onmouseenter="addTransform('top')" onmouseleave="removeTransform('top')">
        <button class='btn btn2'>👆</button>
    </div>
    <div id="upvote" class='upvote' onclick="vote(1)"></div>

</body>

</html>