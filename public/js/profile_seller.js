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
)

//Create Chart
const ctx = document.getElementById('myChart');

new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['Jan','Feb','Mac','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
    datasets: [{
      label: 'Sales',
      data: [50,30,10,20,100,5,60,10,10,6,200,50],
      borderWidth: 1
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});


