var lower;
var highest;
var keyword;
var cond;
var current_page = 1;

$(document).ready(function () {
    renderRatingsStar();
    
    $(".price-input-box").on("input",function(){
        //This function is used to only allow number input
        let inputValue = $(this).val().replace(/\D/g,"");
        $(this).val(inputValue);
    });

    $(".apply-filter-btn").on("click", function () {
        lower = $("#lower-value").val().length == 0 ? undefined : $("#lower-value").val();
        highest = $("#highest-value").val().length == 0 ? undefined : $("#highest-value").val();
        keyword = $(".input-field").val().length == 0 ? undefined : $(".input-field").val();
        cond = getSelectedCondition();
        updateView();
    });

    $(".reset-filter-btn").on("click",resetFilter);
});

function updateView(page) {
    const data = {};
    if (typeof lower !== 'undefined') data.lower = lower;
    if (typeof highest !== 'undefined') data.highest = highest;
    if (typeof keyword !== 'undefined') data.keyword = keyword;
    if (typeof cond !== 'undefined') data.condition = cond;
    if (typeof page !== 'undefined') data.page = page; 
    $.ajax({
        type: "GET",
        data: data,
        success: function (response) {
            $(".result-container").html(response.productCards);
            $("#pagination").html(response.pagination); 
            renderRatingsStar(); 
            console.log(response);
            console.log("success");
        }
    });
}


function getSelectedCondition(){
    let val;
    $("input[name=condition]").each(
        function () {
            if ($(this).prop("checked")){
                val = $(this).val();
            }
        }
    );
    return val;
}

function resetFilter(){
    lower = undefined;
    highest = undefined;
    keyword = undefined;
    cond = undefined;

    $("#lower-value").val('');
    $("#highest-value").val('');
    $(".input-field").val('');
    $("input[name=condition]").each(
        function () {
            $(this).prop("checked",false);
        }
    )
    updateView();
}

function paginate(page){
    updateView(page);
    renderRatingsStar();
}

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