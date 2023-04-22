var currentIndex = 1;

showSlides(currentIndex);

function plusSlides(n) {
    showSlides(currentIndex += n);
}

function currentSlide(n) {
    showSlides(currentIndex = n);
}

function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("images");
    var dots = document.getElementsByClassName("navigation-dot");
    if (n > slides.length) {currentIndex = 1}
    if (n < 1) {currentIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[currentIndex-1].style.display = "block";
    dots[currentIndex-1].className += " active";
}

setInterval("plusSlides(1)", 4000);
