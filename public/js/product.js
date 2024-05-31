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
    })
})


