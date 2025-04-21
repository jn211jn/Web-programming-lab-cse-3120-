const userBtn = document.querySelector('#user-btn');
userBtn.addEventListener("click", function(){
	const userBox = document.querySelector('.profile');
	userBox.classList.toggle('active');
})


const toggle = document.querySelector('#menu-btn');
toggle.addEventListener("click", function(){
	const navbar = document.querySelector('.navbar');
	navbar.classList.toggle('active');
})

const searchForm = document.querySelector('.search-form');
document.querySelector('#search-btn').onclick=()=>{
	searchForm.classList.toggle('active');
	
}

//slide section

"use strict"
const leftArrow = document.querySelector('.left-arrow .bxs-left-arrow');
const rightArrow = document.querySelector('.right-arrow .bxs-right-arrow');
const slider = document.querySelector('.slider');

//scroll to right

function scrollRight(){
	if (slider.scrollWidth - slider.clientWidth === slider.scrollLeft) {
		slider.scrollTo({
			left: 0,
			behavior: "smooth"
		})
	}else{
		slider.scrollBy({
			left: window.innerWidth,
			behavior: "smooth"
		})
	}
}

//scroll to left
function scrollLeft(){
	slider.scrollBy({
		left: -window.innerWidth,
			behavior: "smooth"
	})
}

//auto slider
let timeId = setInterval(scrollRight, 7000);
//reset timer
function resetTimer(){
	clearInterval(timeId);
	timeId = setInterval(scrollRight, 7000);
}

//scroll events
slider.addEventListener('click', function (ev) {
    if (ev.target === leftArrow) {
        scrollLeft();
        resetTimer();
    }
})

slider.addEventListener('click', function (ev) {
    if (ev.target === rightArrow) {
        scrollRight();
        resetTimer();
    }
})

//accordian section

const accordion = document.querySelectorAll('.contentBox');
for (let i = 0; i < accordion.length; i++) {
    accordion[i].addEventListener('click', function () {
        this.classList.toggle('active')
    })
}

//testimonial
let slides = document.querySelectorAll('.testimonial-item');
let index = 0;

function rightSlide(){
	slides[index].classList.remove('active');
	index = (index + 1) % slides.length;
	slides[index].classList.add('active');
}

function leftSlide(){
	slides[index].classList.remove('active');
	index = (index - 1 + slides.length) % slides.length;
	slides[index].classList.add('active');
}


const addToCartButtons = document.querySelectorAll('.add-to-cart-button');

addToCartButtons.forEach(button => {
    button.addEventListener('click', function(event) {
        const form = this.closest('form'); // Get the closest form
        if (form) {
            form.submit(); // Submit the form
        }
    });
});


// Select all cancel buttons
const cancelButtons = document.querySelectorAll('button[name="canceled"]');

cancelButtons.forEach(button => {
    button.addEventListener('click', function(event) {
        // Prevent form submission if the user cancels
        const confirmCancel = confirm('Do you want to cancel this order?');
        if (!confirmCancel) {
            event.preventDefault(); // Stop form submission
        }
    });
});

