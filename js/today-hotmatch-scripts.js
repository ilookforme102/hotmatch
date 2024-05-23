jQuery(document).ready(function($) {
    
    console.log('haha')
    var isMouseDown = false;
    var startX = 0;
    var startY = 0;
    ///////////////////////////////////
    var currentIndex = 0; // Start index
    var slides = $('.shang-slide');
    var slideCount = slides.length;
    function updateSliderPosition() {
        var containerCenter = $('.slider').width() / 2;
        var currentSlide = slides.eq(currentIndex);
        var slideWidth = currentSlide.outerWidth();
        var slideCenter = currentSlide.position().left + slideWidth / 2;
        var newScrollPosition = slideCenter - containerCenter;
        // console.log(currentIndex,currentSlide.position().left);
        if (currentIndex == 0) {
            $('.slider').css('transform', 'translateX(' +(-0) + 'px)');
            $('.slider').css('transition', ' transform 1s cubic-bezier(0.4, 0, 1, 1)');

        }
        else {
            $('.slider').css('transform', 'translateX(' +(-newScrollPosition) + 'px)');
            $('.slider').css('transition', ' transform 1s cubic-bezier(0.4, 0, 1, 1)');

        }
        
    }

    $('.shang-next').click(function() {
        if (currentIndex < slideCount - 1) {
            
            currentIndex++;
            updateSliderPosition();

        }
    });
    
    $('.shang-prev').click(function() {
        if (currentIndex > 0) {
            currentIndex--;
            updateSliderPosition();
        }
    });
    ///////mobile action handler
    // $('.slider').on('mousedown', function(e) {
    //     isMouseDown = true;
    //     startX = e.pageX; // Get the initial position
    //     startY = e.pageY;
    //     e.preventDefault(); // Prevent default drag behavior
    // });
    // $('.slider').on('mousemove', function(e) {
    //     if (isMouseDown) {
    //         var deltaX = e.pageX - startX;
    //         var deltaY = e.pageY - startY;

    //         // Determine if the swipe is more horizontal than vertical
    //         if (Math.abs(deltaX) > Math.abs(deltaY)) {
    //             if (deltaX > 10) {
    //                 console.log('Swiped right');
    //                 isMouseDown = false; // Reset the swipe
    //                 if (currentIndex > 0) {
    //                     currentIndex--;
    //                     updateSliderPosition();
    //                 }
    //             } else if (deltaX < -10) {
    //                 console.log('Swiped left');
    //                 isMouseDown = false; // Reset the swipe
                   
    //                 if (currentIndex < slideCount - 1) {
    //                     currentIndex++;
    //                     updateSliderPosition();
            
    //                 }
    //             }
    //         }
    //     }
    // });
    // $(document).on('mouseup', function() {
    //     isMouseDown = false;
    // });
    // $(window).on('load', function() {
    //     $('.slider').css('transform', 'translateX(' +(-newScrollPosition/2) + 'px)');
    //     $('.slider').css('transition', ' transform 1s cubic-bezier(0.4, 0, 1, 1)');
    // })
    $(window).on('load', function() {
        // Initialize Swiper
        
        var swiper = new Swiper('.shang-carousel-container', {
            direction: 'horizontal',
            on: {
                slideNextTransitionStart: function () {
                    if (currentIndex < slideCount - 1) {
            
                        currentIndex++;
                        updateSliderPosition();
            
                    }
                    // console.log('Swiped left!');
                },
                slidePrevTransitionStart: function () {
                    if (currentIndex > 0) {
                        currentIndex--;
                        updateSliderPosition();
                    }
                    // console.log('Swiped right!');
                }
            }
        });
    });
    
    // setInterval(function(){
    //     currentIndex ++;
    //     updateSliderPosition();
    // },10000);
});
