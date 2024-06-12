var category_id;
var condition;
var lowerPrice;
var highestPrice;
$(document).ready(function () {
    $(".apply-filter-btn").on("click", function () {
        category_id = getCheckedCat();
        condition = getCondition(); 
        lowerPrice = $("#lower-price").val() == "" ? undefined : $("#lower-price").val();
        highestPrice = $("#highest-price").val() == "" ? undefined : $("#highest-price").val();
        $("#lower-label").html(lowerPrice == undefined ? "RM 0" : `RM ${lowerPrice}`);
        $("#highest-label").html(highestPrice == undefined ? `RM <i class="fa-solid fa-infinity"></i>` : `RM ${highestPrice}`);
        applyFilter();
    });
    $(".reset-filter-btn").on("click", resetFilter);

    renderRatingsStar();
});

function paginate(page){
    $.ajax({
        type: "GET",
        data:{
            cat: category_id,
            cond: condition,
            lower: lowerPrice,
            highest: highestPrice,
            page: page,
        },
        success: function (response) {
            $('#pagination').html(response.pagination);
            $(".result-container").html(response.searchCards);
            renderRatingsStar();
        }
    });
}

function applyFilter(){
    $.ajax({
        type: "GET",
        data: {
            cat: category_id,
            cond: condition,
            lower: lowerPrice,
            highest: highestPrice,
        },
        success: function (response) {
            $('#pagination').html(response.pagination);
            $(".result-container").html(response.searchCards);
            renderRatingsStar();
        },
        error: function(xhr, status, error) {
            if(xhr.status == 500){
                $('.result-container').html("<p> No result found </p>");
                $('#pagination').html('');
            }
          }
    });
}

function getCheckedCat() {
    let id;
    $(".checkbox input").each(
        function(){
            if($(this).prop("checked")){
                id = $(this).data('categoryId');
            }
    });
    return id;
}

function getCondition(){
    let condition;
    $(".condition-label input").each(
        function(){
            if($(this).prop("checked")){
                condition = $(this).val();
            }
        });
    return condition;
}

function resetFilter(){
    $(".checkbox input").each(
        function () {
            $(this).prop("checked",false);
        }
    );
    $(".condition-label input").each(
        function () {
            $(this).prop("checked",false);
        }
    );
    $("#lower-price").val("");
    $("#highest-price").val("");
    $("#lower-label").html("RM 0");
    $("#highest-label").html(`RM <i class="fa-solid fa-infinity"></i>`);
    category_id = undefined;
    condition = undefined;
    lowerPrice = undefined;
    highestPrice = undefined;
    applyFilter();
}

const starTotal = 5;

function renderRatingsStar() {
    $(".product-ratings").each(
        function () {
            const rating = $(this).data('productRating');
            const starPercentage = (rating/starTotal) * 100;
            const starPercentageRounded = `${(Math.round(starPercentage / 10) * 10)}%`;
            $(this).find('.stars-inner').css("width",starPercentageRounded);
        }
    );
}