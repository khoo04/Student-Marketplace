//My Address Page
//Change default button state when user click it
default_buttons = document.querySelectorAll(".default-btn")

default_buttons.forEach( (default_button) => 
  default_button.addEventListener("click", (e) => {
    activeDefaultButton = document.querySelector(".default-btn[disabled]")
    inactiveDefaultButton = document.querySelectorAll(".default-btn:not([disabled]")

    if (e.target != activeDefaultButton)
    {
      activeDefaultButton.innerHTML = "Set as Default"
      activeDefaultButton.removeAttribute("disabled")
      delete activeDefaultButton.dataset.active
      e.target.innerHTML = "Default"
      e.target.setAttribute("disabled","")
      e.target.dataset.active = ""
    }
  })
)


//Add New Address Modal
const openModalButton = document.querySelector("[data-open-modal]")
const closeModalButton = document.querySelector("[data-close-modal]")
const modal = document.querySelector("[data-modal]")

openModalButton.addEventListener("click", () => {
  modal.showModal()
})

closeModalButton.addEventListener("click", () => {
  modal.close()
})



//Edit Address Modal