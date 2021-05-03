let arrayOfTimes = [];
$(".arrow-left").click(function () {
    $(this).data("clicked", true);
});
$(".arrow-right").click(function () {
    $(this).data("clicked", true);
});
$(".arrow-left").on("click", function () {
    $("td").each(function () {
        $(this).find("div").find("i").removeClass("fas fa-user");
        $(this).find("div").find("i").addClass("far fa-user");
        $(this).removeClass("text-lightgray");
        $(this).addClass("cursor_pointer hoverable");
    });
    $(".arrow-right").css("display", "block");
    $.ajax({
        url: route_ajaxtableleft,
        type: "POST",
        data: {
            _token: csrf_token,
        },
        success: function (result) {
            arrayOfTimes = result;
            var i = 0;
            $.each(arrayOfTimes, function (key, value) {
                $("#id_" + i).text(value);
                $("#id_" + i).data("time", key);
                $("#id_" + i).attr("data-time", key);
                i++;
            });
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
                        $(this)
                            .find("div")
                            .find("i")
                            .removeClass("far fa-user");
                        $(this).find("div").find("i").addClass("fas fa-user");
                        $(this).addClass("text-lightgray");
                        $(this).removeClass("cursor_pointer hoverable");
                    }
                }
            });
        },
        error: function () {
            console.log("error");
        },
    });
});
$(".arrow-right").on("click", function () {
    $("td").each(function () {
        $(this).find("div").find("i").removeClass("fas fa-user");
        $(this).find("div").find("i").addClass("far fa-user");
        $(this).removeClass("text-lightgray");
        $(this).addClass("cursor_pointer hoverable");
    });
    $(".arrow-right").css("display", "none");
    $.ajax({
        url: route_ajaxtableright,
        type: "POST",
        data: {
            _token: csrf_token,
        },
        success: function (result) {
            arrayOfTimes = result;
            var i = 0;
            $.each(arrayOfTimes, function (key, value) {
                $("#id_" + i).text(value);
                $("#id_" + i).attr("data-time", key);
                i++;
            });
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
                    console.log(todayTime, arrOfTimes);
                    if (
                        todayTime > arrOfTimes[1] ||
                        (todayTime > arrOfTimes[0] && todayTime < arrOfTimes[1])
                    ) {
                        $(this)
                            .find("div")
                            .find("i")
                            .removeClass("far fa-user");
                        $(this).find("div").find("i").addClass("fas fa-user");
                        $(this).addClass("text-lightgray");
                        $(this).removeClass("cursor_pointer hoverable");
                    }
                }
            });
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
    if (
        !$(".arrow-left").data("clicked") &&
        !$(".arrow-right").data("clicked")
    ) {
    }
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
