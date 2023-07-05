
function showPage() {
    document.getElementById("loader").classList.toggle('d-none');
    document.getElementById("mainDiv").classList.toggle('d-none');
}


window.addEventListener('load',(evt)=>{
    showPage();
})