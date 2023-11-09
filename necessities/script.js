// NAVIGATION BAR - MOBILE MENU
document.addEventListener("DOMContentLoaded", function () {
    const mobileMenuButton = document.querySelector(".mobile-menu-toggle");
    const menuList = document.querySelector(".menu-navbar ul");

    mobileMenuButton.addEventListener("click", function () {
        menuList.classList.toggle("active");
    });
});

// IMAGE TRANSITIONS - HOME PAGE
document.addEventListener("DOMContentLoaded", function () {
    const slides = document.querySelectorAll(".mySlides");
    let currentSlideIndex = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            if (i === index) {
                slide.style.opacity = "1";
            } else {
                slide.style.opacity = "0";
            }
        });
    }

    function nextSlide() {
        currentSlideIndex = (currentSlideIndex + 1) % slides.length;
        showSlide(currentSlideIndex);
    }

    showSlide(currentSlideIndex);
    setInterval(nextSlide, 5000); 
});


// IMAGE PREVIEW FUNCTION - SIGN UP PAGE
function previewImage(input) {
    const preview = document.getElementById('preview-image');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = 'Images/girl-icon.png'; // Default image when no file is selected
    }
}
