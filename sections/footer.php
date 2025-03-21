<footer>
    <p>&copy; 2021 Vakantie Villa</p>
    <p>Website by Syntax Err</a></p>

    <!-- jQuery (vereist door Owl Carousel) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<!-- Owl Carousel Init Script -->
<script>
    var owl = $('.owl-carousel');
    owl.owlCarousel({
        loop:true,
        nav:true,
        margin:10,
        responsive:{
            0:{ items:1 },
            600:{ items:1 },
            960:{ items:2 },
            1200:{ items:4 }
        }
    });

    owl.on('mousewheel', '.owl-stage', function (e) {
        if (e.originalEvent.deltaY > 0) {
            owl.trigger('next.owl');
        } else {
            owl.trigger('prev.owl');
        }
        e.preventDefault();
    });
</script>

</footer>

<script src="/assets/js/script.js"></script>