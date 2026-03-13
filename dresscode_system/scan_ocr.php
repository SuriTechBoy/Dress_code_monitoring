<?php 
session_start();
?>

<!DOCTYPE html>
<html>
<head>

<title>Scan Student ID</title>

<script src="https://cdn.jsdelivr.net/npm/tesseract.js@4/dist/tesseract.min.js"></script>

<style>

body{
background:#f2f2f2;
font-family:Arial;
}

.container{
width:700px;
margin:auto;
margin-top:40px;
}

.card{
background:white;
padding:30px;
border-radius:10px;
box-shadow:0 0 10px rgba(0,0,0,0.2);
text-align:center;
}

video{
border-radius:10px;
width:100%;
max-width:640px;
}

</style>

</head>

<body>

<div class="container">

<div class="card">

<h3>📷 Scan Student ID Card</h3>

<video id="video" autoplay playsinline></video>

<p id="status">Show ID card to camera</p>

<canvas id="canvas" style="display:none;"></canvas>

<form id="scanForm" action="index.php" method="POST">

<input type="hidden" name="roll" id="roll">
<input type="hidden" name="name" id="name">
<input type="hidden" name="branch" id="branch">
<input type="hidden" name="image" id="image">

</form>

</div>

</div>

<script>

let video = document.getElementById("video");
let canvas = document.getElementById("canvas");
let context = canvas.getContext("2d");

let scanning = true;

navigator.mediaDevices.getUserMedia({
video:{width:1280,height:720}
})
.then(stream=>{
video.srcObject = stream;
})
.catch(err=>{
document.getElementById("status").innerHTML="Camera error";
});

function scanFrame(){

if(!scanning) return;

canvas.width = video.videoWidth;
canvas.height = video.videoHeight;

context.drawImage(video,0,0);

// capture image
let imageData = canvas.toDataURL("image/png");

Tesseract.recognize(canvas,'eng')

.then(result=>{

let rawText=result.data.text;

let cleanText=rawText.replace(/\s/g,'').toUpperCase();

let rollMatch=
cleanText.match(/[0-9]{2}BFA[0-9]{2}L[0-9]{2}/) ||
cleanText.match(/[0-9]{2}BFA[0-9]{5}/);

let branchMatch=cleanText.match(/CSE|ECE|EEE|MECH|CIVIL/);

let lines = rawText.split("\n");

let name = "";

for(let i=0;i<lines.length;i++){

let line = lines[i].toUpperCase().trim();

if(line.match(/[0-9]{2}BFA/)){

for(let j=i-1;j>=0 && j>=i-3;j--){

let candidate = lines[j].trim();

let clean = candidate.replace(/[^A-Za-z ]/g,"").trim();

if(clean.length>5 &&
!clean.toUpperCase().includes("COLLEGE") &&
!clean.toUpperCase().includes("PRINCIPAL") &&
!clean.toUpperCase().includes("B TECH") &&
!clean.toUpperCase().includes("ENGINEERING") &&
!clean.toUpperCase().includes("CSE") &&
!clean.toUpperCase().includes("ECE")){

name = clean;
break;

}

}

break;

}

}

name = name.replace(/[^A-Za-z ]/g,"").trim();

name = name.replace(/\s{2,}/g," ");

name = name.toLowerCase().replace(/\b\w/g,l=>l.toUpperCase());

name=name.replace(/[^A-Za-z ]/g,"").trim();
name=name.replace(/^[a-zA-Z]\s+/,"");
name=name.replace(/\s{2,}/g," ");
name=name.toLowerCase().replace(/\b\w/g,l=>l.toUpperCase());

if(rollMatch){

scanning=false;

document.getElementById("status").innerHTML="ID detected : "+rollMatch[0];

document.getElementById("roll").value=rollMatch[0];
document.getElementById("name").value=name;
document.getElementById("branch").value=branchMatch?branchMatch[0]:"CSE";
document.getElementById("image").value=imageData;

document.getElementById("scanForm").submit();

}

});

}

setInterval(scanFrame,2000);

</script>

</body>
</html>