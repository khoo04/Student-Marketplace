const ratings = { 
    "product-id-1" : 5,
    "product-id-2": 3,
    "product-id-3" : 2.9,
    "product-id-4" : 2
}
  
  // total number of stars
  const starTotal = 5;
  
  for(const rating in ratings) {  
    const starPercentage = (ratings[rating] / starTotal) * 100;
    const starPercentageRounded = `${(Math.round(starPercentage / 10) * 10)}%`;
    console.log(`#${rating} > .card-body > .rating > .stars-outer > .stars-inner`);
    document.querySelector(`#${rating} > .card-body > .rating > .stars-outer > .stars-inner`).style.width = starPercentageRounded; 
  }