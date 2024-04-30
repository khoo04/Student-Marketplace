const buttons = document.querySelectorAll("[data-carousel-button]")

buttons.forEach(button => {
    button.addEventListener("click", () => {
        const offset = button.dataset.carouselButton === "next" ? 1 : -1;
        const slides = button.closest("[data-carousel]").querySelector("[data-slides]");
       
        const activeSlide = slides.querySelector("[data-active]")
        let newIndex = [...slides.children].indexOf(activeSlide) + offset

        if (newIndex < 0)
        {
            newIndex = slides.children.length - 1
        }
        if (newIndex >= slides.children.length){
            newIndex = 0
        }

        //Set add data-active to new slide
        slides.children[newIndex].dataset.active = "" 
        //Delete data-active from previous slide
        delete activeSlide.dataset.active
        console.log(...slides.children.dataset)
    })
})



const starTotal = 5;

function calculatePercentageRounded(ratings)
{
    starPercentage = (ratings/ starTotal) * 100;
    starPercentageRounded = `${(Math.round(starPercentage / 10) * 10)}%`;
    return starPercentageRounded;
}

//Rating per comment
const ratings = [4,3,5];

const comments = document.querySelectorAll(".comment-card > .rating > .stars-outer > .stars-inner");
comments.forEach(
    function(value,index,arr) {
        arr[index].style.width = calculatePercentageRounded(ratings[index]);
    }
);


const rating_product = 10/3;
document.querySelector(`#details > .rating > .stars-outer > .stars-inner`).style.width = calculatePercentageRounded(rating_product);


