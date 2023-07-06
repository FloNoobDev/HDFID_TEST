const refAllA = document.querySelectorAll('a');


refAllA.forEach((ele)=>{
    ele.style.opacity = '0';
    ele.style.transition = '1s';
})

window.addEventListener('scroll',FadeIn);

FadeIn();

function FadeIn() {
    for (var i = 0; i < refAllA.length; i++) {
        
        var elem = refAllA[i];
        
        var distInView = elem.getBoundingClientRect().top - window.innerHeight + 150;

        if (distInView < 0) {
            elem.style.opacity = '1';
        } else {
            elem.style.opacity = '0';
        }
    }
}