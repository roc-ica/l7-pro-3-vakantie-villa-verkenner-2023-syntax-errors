var owl = $('.owl-carousel');
owl.owlCarousel({
    loop:true,
    nav:true,
    margin:18,
    responsive:{
        0:{ items:1 },
        600:{ items:2 },
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