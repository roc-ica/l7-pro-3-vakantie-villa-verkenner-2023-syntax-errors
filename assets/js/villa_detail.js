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

        // Set a minimum desired width for each thumbnail. Assuming 1rem = 16px, 7rem ~ 112px.
        const minDesiredWidth = 112;

        // Calculate the number of slides that can fit based on container width,
        // clamped between 1 and 4.
        const getVisibleSlides = () => {
            const containerWidth = sliderContainer.offsetWidth;
            let visible = Math.floor(containerWidth / minDesiredWidth);
            visible = Math.max(1, Math.min(visible, 4));
            return visible;
        };

        const updateSlider = () => {
            const visibleSlides = getVisibleSlides();
            const containerWidth = sliderContainer.offsetWidth;
            // Compute each slide's width so the container is filled ear to ear.
            const slideWidth = containerWidth / visibleSlides;

            // Adjust currentIndex if it's out of bounds.
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

        // Update slider on window resize in case container width changes.
        window.addEventListener("resize", updateSlider);

        // Initialize slider.
        updateSlider();
    });
}
thumbnailSlider();

