(function ($, window, Typist) {
    // Dropdown Menu Fade
    jQuery(document).ready(function () {
        $(".header .dropdown").hover(
            function () {
                $(".dropdown-menu", this).fadeIn("fast");
            },
            function () {
                $(".dropdown-menu", this).fadeOut("fast");
            }
        );
    });

    /*-------active---------*/

    $(document).ready(function () {
        $(".nav-link").click(function () {
            $(".nav-link").removeClass("active");
            $(this).addClass("active");
        });
    });

    /*-------------headder_fixed-------------*/

    $(window).scroll(function () {
        var sticky = $(".header"),
            scroll = $(window).scrollTop();

        if (scroll >= 20) sticky.addClass("fixed");
        else sticky.removeClass("fixed");
    });

    /*------------slider-------------*/

    var swiper = new Swiper(".smplace", {
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            640: {
                slidesPerView: 1,
                spaceBetween: 0,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 0,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 0,
            },
        },
    });

    var swiper = new Swiper(".Bestdeals", {
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            300: {
                slidesPerView: 2,
                spaceBetween: 8,
            },
            640: {
                slidesPerView: 1,
                spaceBetween: 10,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 15,
            },
            1366: {
                slidesPerView: 4,
                spaceBetween: 15,
            },
        },
    });
    
    var swiper = new Swiper(".featuredArticles", {
        navigation: {
            nextEl: ".featuredArticles-button-next",
            prevEl: ".featuredArticles-button-prev",
        },
        breakpoints: {
            300: {
                slidesPerView: 2,
                spaceBetween: 8,
            },
            640: {
                slidesPerView: 1,
                spaceBetween: 10,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 15,
            },
            1366: {
                slidesPerView: 4,
                spaceBetween: 15,
            },
        },
    });
    var swiper = new Swiper(".Bestdeals2", {
        navigation: {
            nextEl: ".swiper-button-next-2",
            prevEl: ".swiper-button-prev-2",
        },
        breakpoints: {
            300: {
                slidesPerView: 2,
                spaceBetween: 8,
            },
            620: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 15,
            },
            1366: {
                slidesPerView: 4,
                spaceBetween: 15,
            },
        },
    });
    var swiper = new Swiper(".top_dect", {
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            640: {
                slidesPerView: 1,
                spaceBetween: 10,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
            1024: {
                slidesPerView: 4,
                spaceBetween: 30,
            },
        },
    });

    $(".toggle").click(function (e) {
        e.preventDefault();

        var $this = $(this);

        if ($this.next().hasClass("show")) {
            $this.next().removeClass("show");
            $this.next().slideUp(350);
        } else {
            $this.parent().parent().find("li .inner").removeClass("show");
            $this.parent().parent().find("li .inner").slideUp(350);
            $this.next().toggleClass("show");
            $this.next().slideToggle(350);
        }
    });

    $(".toggle").click(function (e) {
        var $child = $(this).find(".plus-sign");
        if ($child.hasClass("fa-plus")) {
            $child.removeClass("fa-plus");
            $child.addClass("fa-minus");
        } else if ($child.hasClass("fa-minus")) {
            $child.removeClass("fa-minus");
            $child.addClass("fa-plus");
        }
    });

    // sign up form placeholder
    $(".form-field .form-control")
        .on("focus", function () {
            $(this).data("placeholder", $(this).attr("placeholder")); // Store for blur
            $(this).attr("placeholder", $(this).attr("title"));
        })
        .on("blur", function () {
            $(this).attr("placeholder", $(this).data("placeholder"));
        });

    $("#add-social").on("click", function () {
        $("#social-container").append(`<div class="form-field">
		<div class="form-icon">
			<img src="img/tick.png" alt="">
		</div>
		<div class="form-group">
			<i class="fas fa-hashtag"></i>
			<input type="text" placeholder="Others">
		</div>
	</div>`);
    });

    // Show the first tab and hide the rest
    $("#tabs-nav li:first-child").addClass("active");
    $(".tab-content").hide();
    $(".tab-content:first").show();

    // Click function
    $("#tabs-nav li").click(function () {
        $("#tabs-nav li").removeClass("active");
        $(this).addClass("active");
        $(".tab-content").hide();
 
        var activeTab = $(this).find("a").attr("href");
        $(activeTab).fadeIn();
        return false;
    });

    $(document).on('load', function(){
      $('.filterSearchBox .selection').addClass('did-floating-input')
      console.log("Hellllllllllllllllllllllllllo");
    })

    $(".details_tabs li").click(function () {
        $(".details_tabs li").removeClass("active");
        $(this).addClass("active");



        var targetTab = $(this).find("a").attr("href");
        var targetBox = $(targetTab);
        $(".tab-pane").not(targetBox).removeClass('active show');
        $(targetBox).addClass('active show');
        return false;
    });

    // $('.jQueryEqualHeight').jQueryEqualHeight('.blogCart .card-body-top');
    // $('.jQueryEqualHeight').jQueryEqualHeight('.blogCart .card-title');
    // $('.jQueryEqualHeight').jQueryEqualHeight('.Bestdeals .card-body');
    // $('.jQueryEqualHeight').jQueryEqualHeight('.articleCard .card-body');
    

    $('.job__desc > p').removeAttr('style');
    $('.job__desc > p span').removeAttr('style');
    
    /*
    $('.article_content > p').removeAttr('style');
    $('.article_content > p span').removeAttr('style');
    
    $('.article_content > h2').removeAttr('style');
    $('.article_content > h2 span').removeAttr('style');
    
    $('.article_content > h3').removeAttr('style');
    $('.article_content > h3 span').removeAttr('style');
    */




})(jQuery, window);


/*-------------------Video-----------------*/

// Select elements here
const video = document.getElementById('video');
const videoControls = document.getElementById('video-controls');
const playButton = document.getElementById('play');
const playbackIcons = document.querySelectorAll('.playback-icons use');
const timeElapsed = document.getElementById('time-elapsed');
const duration = document.getElementById('duration');
const progressBar = document.getElementById('progress-bar');
const seek = document.getElementById('seek');
const seekTooltip = document.getElementById('seek-tooltip');
const volumeButton = document.getElementById('volume-button');
const volumeIcons = document.querySelectorAll('.volume-button use');
const volumeMute = document.querySelector('use[href="#volume-mute"]');
const volumeLow = document.querySelector('use[href="#volume-low"]');
const volumeHigh = document.querySelector('use[href="#volume-high"]');
const volume = document.getElementById('volume');
const playbackAnimation = document.getElementById('playback-animation');
const fullscreenButton = document.getElementById('fullscreen-button');
const videoContainer = document.getElementById('video-container');
const fullscreenIcons = fullscreenButton.querySelectorAll('use');
const pipButton = document.getElementById('pip-button')

const videoWorks = !!document.createElement('video').canPlayType;
if (videoWorks) {
  video.controls = false
  videoControls.classList.remove('hidden');
}

// Add functions here

// togglePlay toggles the playback state of the video.
// If the video playback is paused or ended, the video is played
// otherwise, the video is paused
function togglePlay() {
  if (video.paused || video.ended) {
    video.play();
  } else {
    video.pause();
  }
}

// updatePlayButton updates the playback icon and tooltip
// depending on the playback state
function updatePlayButton() {
  playbackIcons.forEach(icon => icon.classList.toggle('hidden'));

  if (video.paused) {
    playButton.setAttribute('data-title', 'Play (k)')
  } else {
    playButton.setAttribute('data-title', 'Pause (k)')
  }
}

// formatTime takes a time length in seconds and returns the time in
// minutes and seconds
function formatTime(timeInSeconds) {
  const result = new Date(timeInSeconds * 1000).toISOString().substr(11, 8);

  return {
    minutes: result.substr(3, 2),
    seconds: result.substr(6, 2),
  };
};

// initializeVideo sets the video duration, and maximum value of the
// progressBar
function initializeVideo() {
  const videoDuration = Math.round(video.duration);
  seek.setAttribute('max', videoDuration);
  progressBar.setAttribute('max', videoDuration);
  const time = formatTime(videoDuration);
  duration.innerText = `${time.minutes}:${time.seconds}`;
  duration.setAttribute('datetime', `${time.minutes}m ${time.seconds}s`)
}

// updateTimeElapsed indicates how far through the video
// the current playback is by updating the timeElapsed element
function updateTimeElapsed() {
  const time = formatTime(Math.round(video.currentTime));
  timeElapsed.innerText = `${time.minutes}:${time.seconds}`;
  timeElapsed.setAttribute('datetime', `${time.minutes}m ${time.seconds}s`)
}

// updateProgress indicates how far through the video
// the current playback is by updating the progress bar
function updateProgress() {
  seek.value = Math.floor(video.currentTime);
  progressBar.value = Math.floor(video.currentTime);
}

// updateSeekTooltip uses the position of the mouse on the progress bar to
// roughly work out what point in the video the user will skip to if
// the progress bar is clicked at that point
function updateSeekTooltip(event) {
  const skipTo = Math.round((event.offsetX / event.target.clientWidth) * parseInt(event.target.getAttribute('max'), 10));
  seek.setAttribute('data-seek', skipTo)
  const t = formatTime(skipTo);
  seekTooltip.textContent = `${t.minutes}:${t.seconds}`;
  const rect = video.getBoundingClientRect();
  seekTooltip.style.left = `${event.pageX - rect.left}px`;
}

// skipAhead jumps to a different point in the video when the progress bar
// is clicked
function skipAhead(event) {
  const skipTo = event.target.dataset.seek
    ? event.target.dataset.seek
    : event.target.value;
  video.currentTime = skipTo;
  progressBar.value = skipTo;
  seek.value = skipTo;
}

// updateVolume updates the video's volume
// and disables the muted state if active
function updateVolume() {
  if (video.muted) {
    video.muted = false;
  }

  video.volume = volume.value;
}

// updateVolumeIcon updates the volume icon so that it correctly reflects
// the volume of the video
function updateVolumeIcon() {
  volumeIcons.forEach(icon => {
    icon.classList.add('hidden');
  });

  volumeButton.setAttribute('data-title', 'Mute (m)')

  if (video.muted || video.volume === 0) {
    volumeMute.classList.remove('hidden');
    volumeButton.setAttribute('data-title', 'Unmute (m)')
  } else if (video.volume > 0 && video.volume <= 0.5) {
    volumeLow.classList.remove('hidden');
  } else {
    volumeHigh.classList.remove('hidden');
  }
}

// toggleMute mutes or unmutes the video when executed
// When the video is unmuted, the volume is returned to the value
// it was set to before the video was muted
function toggleMute() {
  video.muted = !video.muted;

  if (video.muted) {
    volume.setAttribute('data-volume', volume.value);
    volume.value = 0;
  } else {
    volume.value = volume.dataset.volume;
  }
}

// animatePlayback displays an animation when
// the video is played or paused
function animatePlayback() {
    playbackAnimation.animate([
      {
        opacity: 1,
        transform: "scale(1)",
      },
      {
        opacity: 0,
        transform: "scale(1.3)",
      }
    ], {
      duration: 500,
    });
}

// toggleFullScreen toggles the full screen state of the video
// If the browser is currently in fullscreen mode,
// then it must be exited and vice versa.
function toggleFullScreen() {
  if (document.fullscreenElement) {
    document.exitFullscreen();
  } else {
    videoContainer.requestFullscreen();
  }
}

// updateFullscreenButton changes the icon of the full screen button
// and tooltip to reflect the current full screen state of the video
function updateFullscreenButton() {
  fullscreenIcons.forEach(icon => icon.classList.toggle('hidden'));

  if (document.fullscreenElement) {
    fullscreenButton.setAttribute('data-title', 'Exit full screen (f)')
  } else {
    fullscreenButton.setAttribute('data-title', 'Full screen (f)')
  }
}

// togglePip toggles Picture-in-Picture mode on the video
async function togglePip() {
  try {
    if (video !== document.pictureInPictureElement) {
      pipButton.disabled = true;
      await video.requestPictureInPicture();
    } else {
      await document.exitPictureInPicture();
    }
  } catch (error) {
    console.error(error)
  } finally {
    pipButton.disabled = false;
  }
}

// hideControls hides the video controls when not in use
// if the video is paused, the controls must remain visible
function hideControls() {
  if (video.paused) {
    return;
  }

  videoControls.classList.add('hide');
}

// showControls displays the video controls
function showControls() {
  videoControls.classList.remove('hide');
}

// keyboardShortcuts executes the relevant functions for
// each supported shortcut key
function keyboardShortcuts(event) {
  const { key } = event;
  switch(key) {
    case 'k':
      togglePlay();
      animatePlayback();
      if (video.paused) {
        showControls();
      } else {
        setTimeout(() => {
          hideControls();
        }, 2000);
      }
      break;
    case 'm':
      toggleMute();
      break;
    case 'f':
      toggleFullScreen();
      break;
    case 'p':
      togglePip();
      break;
  }
}

// Add eventlisteners here
playButton.addEventListener('click', togglePlay);
video.addEventListener('play', updatePlayButton);
video.addEventListener('pause', updatePlayButton);
video.addEventListener('loadedmetadata', initializeVideo);
video.addEventListener('timeupdate', updateTimeElapsed);
video.addEventListener('timeupdate', updateProgress);
video.addEventListener('volumechange', updateVolumeIcon);
video.addEventListener('click', togglePlay);
video.addEventListener('click', animatePlayback);
video.addEventListener('mouseenter', showControls);
video.addEventListener('mouseleave', hideControls);
videoControls.addEventListener('mouseenter', showControls);
videoControls.addEventListener('mouseleave', hideControls);
seek.addEventListener('mousemove', updateSeekTooltip);
seek.addEventListener('input', skipAhead);
volume.addEventListener('input', updateVolume);
volumeButton.addEventListener('click', toggleMute);
fullscreenButton.addEventListener('click', toggleFullScreen);
videoContainer.addEventListener('fullscreenchange', updateFullscreenButton);
pipButton.addEventListener('click', togglePip);

document.addEventListener('DOMContentLoaded', () => {
  if (!('pictureInPictureEnabled' in document)) {
    pipButton.classList.add('hidden');
  }
});
document.addEventListener('keyup', keyboardShortcuts);

// sweetalert fires | type = success, error, warning, info, question
function toastFire(type = 'success', title, body = '') {
  const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      showCloseButton: true,
      timer: 2000,
      timerProgressBar: false,
      didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
  })

  Toast.fire({
      icon: type,
      title: title,
      // text: body
  })
}

$('.home-directory--slider').on('beforeChange', function(event, slick, currentSlide) {
  console.log('test1' + currentSlide);
  if (currentSlide == 0) {
      $('.directory-bar').addClass('active');
  }
});

$('.home-directory--slider').on('afterChange', function(event, slick, currentSlide) {
  console.log('test2' + currentSlide);
  if (currentSlide == 0) {
      $('.directory-bar').removeClass('active');
  }
});

//community slider
$('.community-list').slick({
  dots: true,
  infinite: false,
  speed: 300,
  slidesToShow: 3,
  slidesToScroll: 1,
  responsive: [{
          breakpoint: 1024,
          settings: {
              slidesToShow: 2,
              slidesToScroll: 1,
              infinite: true,
              dots: true
          }
      },
      {
          breakpoint: 600,
          settings: {
              slidesToShow: 2,
              slidesToScroll: 1
          }
      },
      {
          breakpoint: 481,
          settings: {
              slidesToShow: 1,
              slidesToScroll: 1
          }
      }

  ]
});

//business slider
$('.business-list').slick({
  dots: true,
  //infinite: false,
  speed: 300,
  centerMode: true,
  centerPadding: '60px',
  slidesToShow: 3,
  slidesToScroll: 1,
  responsive: [{
          breakpoint: 1024,
          settings: {
              slidesToShow: 2,
              slidesToScroll: 1,
              infinite: true,
              dots: true
          }
      },
      {
          breakpoint: 600,
          settings: {
              slidesToShow: 2,
              slidesToScroll: 1
          }
      },
      {
          breakpoint: 481,
          settings: {
              slidesToShow: 1,
              slidesToScroll: 1
          }
      }

  ]
});


$('.home-banner--slider').slick({
  dots: false,
  arrows: false,
  infinite: false,
  speed: 600,
  slidesToShow: 1,
  slidesToScroll: 1,
  autoplay: true,
  cssEase: 'linear',
  responsive: [{
          breakpoint: 1024,
          settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              infinite: true,
              dots: true
          }
      },
      {
          breakpoint: 600,
          settings: {
              slidesToShow: 1,
              slidesToScroll: 1
          }
      },
      {
          breakpoint: 481,
          settings: {
              slidesToShow: 1,
              slidesToScroll: 1
          }
      }

  ]
});

$('.home-about--slider').slick({
  dots: false,
  arrows: false,
  infinite: false,
  speed: 300,
  slidesToShow: 1,
  slidesToScroll: 1,
  autoplay: true,
  responsive: [{
          breakpoint: 1024,
          settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              infinite: true,
              dots: true
          }
      },
      {
          breakpoint: 600,
          settings: {
              slidesToShow: 1,
              slidesToScroll: 1
          }
      },
      {
          breakpoint: 481,
          settings: {
              slidesToShow: 1,
              slidesToScroll: 1
          }
      }

  ]
});

$('.home-directory--slider').slick({
  dots: false,
  arrows: true,
  infinite: false,
  speed: 600,
  variableWidth: true,
  slidesToScroll: 1,
  cssEase: 'linear',
  prevArrow: $('.left-arrow'),
  nextArrow: $('.right-arrow'),
});

$('.event-block:first').addClass('active');
$('.event-block').hover(function() {
  if ($(this).hasClass('active')) {
      //$(this).removeClass('active');
  } else {
      $('.event-block.active').removeClass('active');
      $(this).addClass('active');
  }
  //$(this).next().slideToggle();
  //$('.site_accordian_details').not($(this).next()).slideUp();
});

// counter
var a = 0;
$(window).scroll(function() {
  const servicecounter = document.querySelector(".counter-list");
  if (!document.body.contains(servicecounter)) return;
  var oTop = $('.counter-list').offset().top - window.innerHeight;
  if (a == 0 && $(window).scrollTop() > oTop) {
      $('.counter-list li figure').each(function() {
          var $this = $(this),
              countTo = $this.attr('data-count');
          $({
              countNum: $this.text()
          }).animate({
                  countNum: countTo
              },

              {

                  duration: 1000,
                  easing: 'swing',
                  step: function() {
                      $this.text(Math.floor(this.countNum));
                  },
                  complete: function() {
                      $this.text(this.countNum);
                      //alert('finished');
                  }

              });
      });
      a = 1;
  }

});



$(document).ready(function() {
  $('.ham').click(function(e) {
      e.stopPropagation();
      $('.navigation').toggleClass('slide');
  });

  $(document).click(function() {
      $('.navigation').removeClass('slide');
  });

  $('.navigation').click(function(e) {
      e.stopPropagation();
  });
  $('.filter_btn').click(function(e) {
      e.stopPropagation();
      $('.filter_wrap').slideToggle();
      $('.page-search-block').toggleClass('filter-open');
  });
  $('.filter_wrap').click(function(e) {
      e.stopPropagation();
  });

  $(document).click(function() {
      $('.filter_wrap').slideUp();
      $('.page-search-block').removeClass('filter-open');
  });

});

$('.filter_select').select2({
width:"100%",
});


$('.filter_select').select2().on('select2:select', function (e) {
var data = e.params.data;
});


$('.filter_select').select2().on('select2:open', (elm) => {
  const targetLabel = $(elm.target).prev('label');
  targetLabel.addClass('filled active');
}).on('select2:close', (elm) => {
  const target = $(elm.target);
  const targetLabel = target.prev('label');
  const targetOptions = $(elm.target.selectedOptions);
  if (targetOptions.length === 0) {
      targetLabel.removeClass('filled active');
  }
});


$(document).on('.filter_selectWrap select2:open', () => {
document.querySelector('.select2-search__field').focus();
});


$(".questionSetItemButton").click(function(){
$(this).parents(".questionSetItem").hide();
$(this).parents(".questionSetItem").next().show();
});
$(".questionSetItemButtonPrev").click(function(){
$(this).parents(".questionSetItem").hide();
$(this).parents(".questionSetItem").prev().show();
});
$("#questionModal").modal({
  show:false,
  backdrop:'static'
});

$(".openAlertModal").click(function(){
$("#questionModal").addClass("questionModalHide");
})
$(".closeAlertThis, .leaveBtn, .stayBtn").click(function(){
$("#questionModal").removeClass("questionModalHide");
})
$(".openreviewBbox").click(function(){

})

$('.jQueryEqualHeight').jQueryEqualHeight('.businessDirectoryCard h5');
$('.jQueryEqualHeight').jQueryEqualHeight('.businessDirectoryCard .card-body');
$('.jQueryEqualHeight').jQueryEqualHeight('.directoryCard h5');
$('.jQueryEqualHeight').jQueryEqualHeight('.directoryCard .card-body');

$('.jQueryEqualHeight').jQueryEqualHeight('.innerCatlistCard .card-body h5');
$('.jQueryEqualHeight').jQueryEqualHeight('.innerCatlistCard .card-body');
$('.jQueryEqualHeight').jQueryEqualHeight('.article_badge_wrap');

var searchPadding = $(".filterSearchBoxWraper").innerHeight();
$(".searchpadding").css({"padding-top": searchPadding + 10});
$(".filterSearchBoxWraper").css({"bottom": - searchPadding});

var collectionBreadcumb = $(".collection_breadcumb").innerHeight();
$(".collectionbreadcumbPadding").css({"padding-top": collectionBreadcumb + 10});
$(".collection_breadcumb").css({"bottom": - collectionBreadcumb});