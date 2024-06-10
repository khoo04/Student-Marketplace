// TODO:
// Use to omit the character for product which name is long
const options = document.querySelectorAll("option");
options.forEach(
    function(element){
        var optionText = element.innerHTML
        if (optionText.length > 50)
        {
            var newOption = optionText.substring(0,50)
            element.innerHTML = newOption + "..."
        }
    }
);
