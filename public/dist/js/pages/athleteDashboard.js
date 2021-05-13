todayTime = "11:30";
let i_fontawesome = "";
let td_childs = "";
$("td").each(function(){

    //console.log($(this).parent().parent().prev().find("tr").find("th:nth-child(2)").text());
});
function emptyTds(){
    $("td").each(function () {
        i_fontawesome = $(this).find("div").find("i");
        if(!i_fontawesome.hasClass("accepted") && !i_fontawesome.hasClass("danger")){
            i_fontawesome.removeClass("fas fa-user");
            i_fontawesome.addClass("far fa-user");
        }

        $(this).removeClass("text-lightgray");
        $(this).addClass("cursor_pointer hoverable");
    });
}
function addDisabledToSomeDateOfTodays(){
    $("td").each(function () {
        if ($(this).hasClass("text-lightgray")) {
            $(this).find("div").find("i").removeClass("far fa-user");
            $(this).find("div").find("i").addClass("fas fa-user");
        }
        var column = $(this).closest("td").index();
        if ($(this).data("date") == todayDate) {
            column = $("tr")
                .children(".c_" + column)
                .data("time");
            arrOfTimes = column.split(" - ");
            if (
                todayTime > arrOfTimes[1] ||
                (todayTime > arrOfTimes[0] && todayTime < arrOfTimes[1])
            ) {
                $(this).find("div").find("i").removeClass("far fa-user");
                $(this).find("div").find("i").addClass("fas fa-user");
                $(this).addClass("text-lightgray");
                $(this).removeClass("cursor_pointer hoverable");
            }
        }
    });
}
function cssClassesInTd(){
    $("td").each(function(){
        //if($(this).parent().parent().prev().find("tr").find("th:nth-child(2)").text() == '۱۰'){
        td_childs = $(this).find("div").find("i");
            if(td_childs.hasClass("accepted") || td_childs.hasClass("danger")){
                td_childs.removeClass();
                td_childs.addClass("far fa-user");
            }
        //}
    });
}
let arrayOfTimes = [];
$(".arrow-left").on("click", function () {
    var counter = 0;
    $.each(user_slots, function(key, value){
        // for(var i = 1; i <= 16; i++){
        //     //$('.class_'+ i).text('hello');
        // }
        //console.log(value);
    });

    emptyTds();
    $(".arrow-right").css("display", "block");
    $.ajax({
        url: route_ajaxtableleft,
        type: "POST",
        data: {
            _token: csrf_token,
        },
        success: function (result) {
            console.log(result[1]);
            cssClassesInTd();
            // $("td").each(function(){
            //     console.log($(this).parent().parent().prev().find("tr").find("th:nth-child(2)").text());
            //     if($(this).parent().parent().prev().find("tr").find("th:nth-child(2)").text() == '۱۰'){
            //     td_childs = $(this).find("div").find("i");
            //         if(td_childs.hasClass("accepted") || td_childs.hasClass("danger")){
            //             td_childs.removeClass();
            //             td_childs.addClass("far fa-user");
            //         }
            //     }

            // });
            arrayOfTimes = result[0];
            //console.log(result[1]);
            var cnt = 1;
            $("table > tbody > tr:nth-child(1) > td:nth-child(4)").find("div").find("i:nth-child(1)").removeClass();
            $("table > tbody > tr:nth-child(1) > td:nth-child(4)").find("div").find("i:nth-child(2)").removeClass();
            $("table > tbody > tr:nth-child(1) > td:nth-child(4)").find("div").find("i:nth-child(3)").removeClass();
            $("table > tbody > tr:nth-child(1) > td:nth-child(4)").find("div").find("i:nth-child(1)").addClass("fas fa-user accepted");
            $("table > tbody > tr:nth-child(1) > td:nth-child(4)").find("div").find("i:nth-child(2)").addClass("far fa-user");
            $("table > tbody > tr:nth-child(1) > td:nth-child(4)").find("div").find("i:nth-child(3)").addClass("far fa-user");

            //console.log($("table > tbody > tr > td:nth-child(2)"));
            // $("td").each(function(){
            //     td_childs = $(this).find("div").find("i");
            //     if(td_childs.hasClass("accepted") || td_childs.hasClass("danger")){
            //         td_childs.removeClass();
            //         td_childs.addClass("far fa-user");
            //     }
            // });
            $.each(result[1], function(key, value){
                //console.log(key, value["slot-3"]);
                cnt++;
            });
            var i = 0;
            $.each(arrayOfTimes, function (key, value) {
                $("#id_" + i).text(value);
                $("#id_" + i).data("time", key);
                $("#id_" + i).attr("data-time", key);
                i++;
            });
            //cssClassesInTd();
            //console.log($('table').find("thead").find("tr").find("th:nth-child(2").text());
            addDisabledToSomeDateOfTodays();
        },
        error: function () {
            console.log("error");
        },
    });
});
$(".arrow-right").on("click", function () {
    emptyTds();
    $(".arrow-right").css("display", "none");
    $.ajax({
        url: route_ajaxtableright,
        type: "POST",
        data: {
            _token: csrf_token,
        },
        success: function (result) {
            console.log(result[1]);
            //cssClassesInTd();
           // console.log($("table > tbody > tr:nth-child(1) > td:nth-child(2)"));
            // if( !$("table > tbody > tr:nth-child(1) > td:nth-child(4)").hasClass("text-lightgray")){
            //     $("table > tbody > tr:nth-child(1) > td:nth-child(4)").find("div").find("i:nth-child(1)").addClass("fas fa-user accepted");
            //     //$(this).find("div").find("i:nth-child(1)").addClass("fas fa-user accepted");
            // }
            $("table > tbody > tr:nth-child(1) > td:nth-child(4)").find("div").find("i:nth-child(1)").removeClass();
            $("table > tbody > tr:nth-child(1) > td:nth-child(4)").find("div").find("i:nth-child(2)").removeClass();
            $("table > tbody > tr:nth-child(1) > td:nth-child(4)").find("div").find("i:nth-child(3)").removeClass();
            $("table > tbody > tr:nth-child(1) > td:nth-child(4)").find("div").find("i:nth-child(1)").addClass("fas fa-user");
            $("table > tbody > tr:nth-child(1) > td:nth-child(4)").find("div").find("i:nth-child(2)").addClass("far fa-user");
            $("table > tbody > tr:nth-child(1) > td:nth-child(4)").find("div").find("i:nth-child(3)").addClass("far fa-user");
            arrayOfTimes = result[0];
            var i = 0;
            $.each(arrayOfTimes, function (key, value) {
                $("#id_" + i).text(value);
                $("#id_" + i).data("time", key);
                $("#id_" + i).attr("data-time", key);
                i++;
            });
            addDisabledToSomeDateOfTodays();
        },
        error: function () {
            console.log("error");
        },
    });
});
var arrOfTimes = [];

function toPersianNum(num, dontTrim) {
    var i = 0,
        dontTrim = dontTrim || false,
        num = dontTrim ? num.toString() : num.toString().trim(),
        len = num.length,
        res = "",
        pos,
        persianNumbers =
            typeof persianNumber == "undefined"
                ? ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"]
                : persianNumbers;

    for (; i < len; i++)
        if ((pos = persianNumbers[num.charAt(i)])) res += pos;
        else res += num.charAt(i);

    return res;
}
$(document).ready(function () {
    $("select.select2").select2();
    addDisabledToSomeDateOfTodays();
    $("td").on("click", function () {
        if (!$(this).hasClass("text-lightgray")) {
            $("#saveBtn").removeClass("display_none");
        }
        if (
            $(this).siblings().hasClass("text-lightgray") &&
            $(this).data("date") != todayDate
        ) {
            $("#saveBtn").text("لغو");
            $("#saveBtn").removeClass("btn-primary");
            $("#saveBtn").addClass("btn-danger");
        } else {
            $("#saveBtn").text("ذخیره");
            $("#saveBtn").addClass("btn-primary");
            $("#saveBtn").removeClass("btn-danger");
        }
        var row = $(this).closest("tr").index() + 1;
        var column = $(this).closest("td").index();
        var date = $(this).data("date");
        var nameofday = $(this).data("nameofday");
        column = $("tr")
            .children(".c_" + column)
            .data("time");
        var res = column.split(" - ");
        if (
            nameofday != "جمعه" &&
            !$(this).hasClass("text-lightgray") &&
            !$(this).hasClass("bg-danger")
        ) {
            $("#day").css("display", "flex");
            $("#time").css("display", "block");
            $("#day").text(toPersianNum(date) + " " + nameofday);
            $("#time").text(column);
            $("#hidden_day").val(date);
            $("#hidden_time1").val(res[0]);
            $("#hidden_time2").val(res[1]);
        }
    });
});
