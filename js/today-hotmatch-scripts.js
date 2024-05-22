jQuery(document).ready(function($) {
    var isMouseDown = false;
    var startX = 0;
    var startY = 0;
    ///////////////////////////////////
    var currentIndex = 0; // Start index
    var slides = $('.slide');
    var slideCount = slides.length;
    function updateSliderPosition() {
        var containerCenter = $('.slider-container').width() / 2;
        var currentSlide = slides.eq(currentIndex);
        var slideWidth = currentSlide.outerWidth();
        var slideCenter = currentSlide.position().left + slideWidth / 2;
        var newScrollPosition = slideCenter - containerCenter;
        console.log(currentIndex,currentSlide.position().left);
        if (currentIndex == 0) {
            $('.slider').css('transform', 'translateX(' +(-0) + 'px)');
        }
        else {
            $('.slider').css('transform', 'translateX(' +(-newScrollPosition) + 'px)');
        
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
    $('.slider').on('mousedown', function(e) {
        isMouseDown = true;
        startX = e.pageX; // Get the initial position
        startY = e.pageY;
        e.preventDefault(); // Prevent default drag behavior
    });
    $('.slider').on('mousemove', function(e) {
        if (isMouseDown) {
            var deltaX = e.pageX - startX;
            var deltaY = e.pageY - startY;

            // Determine if the swipe is more horizontal than vertical
            if (Math.abs(deltaX) > Math.abs(deltaY)) {
                if (deltaX > 10) {
                    console.log('Swiped right');
                    isMouseDown = false; // Reset the swipe
                    if (currentIndex > 0) {
                        currentIndex--;
                        updateSliderPosition();
                    }
                } else if (deltaX < -10) {
                    console.log('Swiped left');
                    isMouseDown = false; // Reset the swipe
                   
                    if (currentIndex < slideCount - 1) {
                        currentIndex++;
                        updateSliderPosition();
            
                    }
                }
            }
        }
    });

    $(document).on('mouseup', function() {
        isMouseDown = false;
    });
    // setInterval(function(){
    //     currentIndex ++;
    //     updateSliderPosition();
    // },10000);
});
