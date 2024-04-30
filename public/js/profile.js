const pages = document.querySelectorAll(".control-panel")
const buttons = document.querySelectorAll("#navigate > button:not(#logout)")

buttons.forEach(
    (button) => {button.addEventListener("click",(e) => {
        activeButton = document.querySelector("#navigate").querySelector("[data-active]")
        activePage = document.querySelector("#profile-section").querySelector(".control-panel[data-active]")
        index = e.target.dataset.index
        if (activeButton != e.target && pages[index] !== activePage)
        {
            delete activePage.dataset.active
            delete activeButton.dataset.active
            e.target.dataset.active = ""
            pages[index].dataset.active = ""
        }
    })
})




