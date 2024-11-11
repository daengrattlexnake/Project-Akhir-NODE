// Modal Control
document.getElementById('openLoginModal')?.addEventListener('click', function() {
    document.getElementById('loginModal').style.display = 'flex';
});

document.getElementById('openRegisterModal')?.addEventListener('click', function() {
    document.getElementById('registerModal').style.display = 'flex';
});

document.getElementById('toRegister')?.addEventListener('click', function() {
    document.getElementById('loginModal').style.display = 'none';
    document.getElementById('registerModal').style.display = 'flex';
});

document.getElementById('toLogin')?.addEventListener('click', function() {
    document.getElementById('registerModal').style.display = 'none';
    document.getElementById('loginModal').style.display = 'flex';
});

// Close modal when clicking outside the modal content
window.addEventListener('click', function(event) {
    const loginModal = document.getElementById('loginModal');
    const registerModal = document.getElementById('registerModal');
    if (event.target === loginModal) {
        loginModal.style.display = 'none';
    }
    if (event.target === registerModal) {
        registerModal.style.display = 'none';
    }
});

// Hero Slider
let currentSlide = 0;
const heroSlides = document.querySelectorAll('.hero-slider .slide');

function changeHeroSlide() {
    heroSlides.forEach(slide => slide.classList.remove('active'));
    currentSlide = (currentSlide + 1) % heroSlides.length;
    heroSlides[currentSlide].classList.add('active');
}

setInterval(changeHeroSlide, 3000); // Change slide every 3 seconds

// Highlight Slider
let currentHighlightSlide = 0;
const highlightSlides = document.querySelectorAll('.highlight-slider .highlight-slide');

function changeHighlightSlide(direction) {
    highlightSlides[currentHighlightSlide].classList.remove('active');
    currentHighlightSlide += direction;

    // Handle slider wrap-around
    if (currentHighlightSlide >= highlightSlides.length) {
        currentHighlightSlide = 0;
    }
    if (currentHighlightSlide < 0) {
        currentHighlightSlide = highlightSlides.length - 1;
    }

    highlightSlides[currentHighlightSlide].classList.add('active');
}

// Search Popup Functions
function showPopup() {
    document.getElementById('popup').style.display = 'block';
}

function closePopup() {
    document.getElementById('popup').style.display = 'none';
}

// Optional: Attach close function to any close button in popup
document.getElementById('closePopupButton')?.addEventListener('click', closePopup);
