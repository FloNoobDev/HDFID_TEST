
let objectTimer;

triggerAnimation();

function triggerAnimation() {
    objectTimer = setTimeout(showPage, 2000);
}

function showPage() {
    document.getElementById("loader").classList.toggle('d-none');
    document.getElementById("mainDiv").classList.toggle('d-none');
}
