

// // Event listener for pagination links
// $(document).on('click', '.paginator', function(event) {
//   console.log(event);
// });
var current_page = 1;

$(document).ready(function(){
  renderRatingsStar();
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
          // Update pagination links
          $('#pagination').html(response.pagination);
          current_page = page;
          //Update Rating
          renderRatingsStar();
      },
      error: function(xhr, status, error) {
        $('#card-container').html("<p> Some errors has occured </p>");
        console.error(xhr.responseText);
      }
  });
};

// total number of stars
const starTotal = 5;

function renderRatingsStar() {
  $(".rating").each(
      function () {
          const rating = $(this).data('productRating');
          const starPercentage = (rating/starTotal) * 100;
          const starPercentageRounded = `${(Math.round(starPercentage / 10) * 10)}%`;
          $(this).find('.stars-inner').css("width",starPercentageRounded);
      }
  );
}

