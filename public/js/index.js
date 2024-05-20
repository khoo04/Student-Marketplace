

// // Event listener for pagination links
// $(document).on('click', '.paginator', function(event) {
//   console.log(event);
// });
var current_page = 1;

$(document).ready(function(){
  paginate(current_page);
})


function paginate(page) {
  $.ajax({
      url: '/product_data',
      type: 'GET',
      data:{
        page: page,
      },
      success: function(response) {
          // Update product container with new products
          $('#card-container').html(response.products_cards);
          //Update Ratings
          productRatings = response.ratings;
          renderRatings(productRatings);
          // Update pagination links
          $('#pagination').html(response.pagination);
          current_page = page;
      },
      error: function(xhr, status, error) {
        $('#card-container').html("<p> Some errors has occured </p>");
      }
  });
};

// total number of stars
const starTotal = 5;

function renderRatings(productRatings){
  productRatings.forEach(element => {
    const starPercentage = (element["rating"] / starTotal) * 100;
    const starPercentageRounded = `${(Math.round(starPercentage / 10) * 10)}%`;
    document.querySelector(`#product-id-${element["id"]} > .card-body > .rating > .stars-outer > .stars-inner`).style.width = starPercentageRounded; 
  });
}

