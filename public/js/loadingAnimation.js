
let myVar;

document.getElementById('mainDiv').style.display = "none";

triggerAnimation();

function triggerAnimation() {
    myVar = setTimeout(showPage, 2000);
}

function showPage() {
    document.getElementById("loader").style.display = "none";
    document.getElementById('mainDiv').style.display = "block";
}
