const toggleBtn = document.querySelector('#toggle-menu-btn')
const toggleBtnIcon = document.querySelector('#toggle-menu-btn i')
const dropdown_navbar = document.querySelector('.dropdown-nav-bar')

toggleBtn.addEventListener("click", () => {
    dropdown_navbar.classList.toggle('open')
    const isOpen = dropdown_navbar.classList.contains('open')

    toggleBtnIcon.classList = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'
})

const searchDialog = document.getElementById("search-area")
const navSearchBtn = document.querySelector('#nav-search-btn')
navSearchBtn?.addEventListener("click", () => {
    dropdown_navbar.classList.remove('open')
    toggleBtnIcon.classList = 'fa-solid fa-bars'
    searchDialog.showModal()  
})


searchDialog?.addEventListener("click", e => {
    const dialogDimensions = searchDialog.getBoundingClientRect()
    if (
      e.clientX < dialogDimensions.left ||
      e.clientX > dialogDimensions.right ||
      e.clientY < dialogDimensions.top ||
      e.clientY > dialogDimensions.bottom
    ) {
      searchDialog.close()
    }
  })