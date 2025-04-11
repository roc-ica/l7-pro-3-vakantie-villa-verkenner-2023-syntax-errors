function contactPopup() {
    document.addEventListener("DOMContentLoaded", function () {
        const openBtn = document.getElementById("openModal");
        const closeBtn = document.getElementById("closeModal");
        const modal = document.getElementById("contactModal");

        if (openBtn && closeBtn && modal) {
            openBtn.addEventListener("click", function () {
                modal.classList.add("visible");
            });
            closeBtn.addEventListener("click", function () {
                modal.classList.remove("visible");
            });
        } else {
            console.error("Modal elements not found in the DOM.");
        }
    });
}
contactPopup();


function thumbnailSlider() {
    document.addEventListener("DOMContentLoaded", () => {
        const sliderContainer = document.getElementById('villa-detail_thumbnail');
        const slides = sliderContainer.querySelectorAll('.villa-detail__each-image');
        const prevButton = document.getElementById('prev');
        const nextButton = document.getElementById('next');
        let currentIndex = 0;

        const getVisibleSlides = () => {
            const width = window.innerWidth;
            if (width >= 768) {
                return 4;
            } else if (width >= 550) {
                return 3;
            }
            return 2;
        };

        const updateSlider = () => {
            const visibleSlides = getVisibleSlides();

            // Calculate the actual width of one slide including margins.
            const firstSlide = slides[0];
            const slideStyles = window.getComputedStyle(firstSlide);
            const slideWidth = firstSlide.offsetWidth +
                parseFloat(slideStyles.marginLeft) +
                parseFloat(slideStyles.marginRight);

            // Prevent the currentIndex from going out of bounds.
            if (currentIndex > slides.length - visibleSlides) {
                currentIndex = slides.length - visibleSlides;
            }
            if (currentIndex < 0) {
                currentIndex = 0;
            }

            sliderContainer.scrollTo({
                left: slideWidth * currentIndex,
                behavior: 'smooth'
            });
        };

        const slideNext = () => {
            const visibleSlides = getVisibleSlides();
            if (currentIndex < slides.length - visibleSlides) {
                currentIndex++;
                updateSlider();
            }
        };

        const slidePrev = () => {
            if (currentIndex > 0) {
                currentIndex--;
                updateSlider();
            }
        };

        nextButton.addEventListener("click", slideNext);
        prevButton.addEventListener("click", slidePrev);
        window.addEventListener("resize", updateSlider);
        updateSlider();
    });
}
thumbnailSlider();

