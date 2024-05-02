
// total number of stars
const starTotal = 5;

productRatings.forEach(element => {
  console.log(element)
  const starPercentage = (element["rating"] / starTotal) * 100;
  const starPercentageRounded = `${(Math.round(starPercentage / 10) * 10)}%`;
  document.querySelector(`#product-id-${element["id"]} > .card-body > .rating > .stars-outer > .stars-inner`).style.width = starPercentageRounded; 
});
