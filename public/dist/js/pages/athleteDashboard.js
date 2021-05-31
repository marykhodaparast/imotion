let i_fontawesome = "";
let td_childs = "";
//todayTime = "11:30";
function isMobile() {
    return ($(window).width >= 320 && $(window).width <= 768);
}

function isDesktop() {
    return ($(window).width >= 1024 && $(window).width <= 2560);
}

function clickArrowLeftOnMobile(slotIndex, arrOfTimes) {
    emptyTds();
    $(".arrow-right").css("display", "block");
    $.ajax({
        url: route_ajaxtableleftmobile,
        type: "POST",
        data: {
            _token: csrf_token,
            slot_index: slotIndex,
            arrOfTimes: arrOfTimes
        },
        success: function (result) {
            var slots = result[1];
            var row = 1;
            $.each(slots, function (key, value) {
                if (Object.keys(value).length) {
                    for (var i = 1; i <= 10; i++) {
                        whatToDoAccordingToSeatCount(value["slot-" + i]["seat_count"] == 1, row, i, "fas fa-user accepted", "far fa-user", "far fa-user");
                        disableSomeSlots(value["slot-" + i]["seat_count"] == null && value["slot-" + i]["is_mine"] == null, row, i, full_user_slots[key]["is_mine"]);
                        whatToDoAccordingToSeatCount(value["slot-" + i]["seat_count"] == null && value["slot-" + i]["is_mine"] == null, row, i, "far fa-user", "far fa-user", "far fa-user");
                        whatToDoAccordingToSeatCount(value["slot-" + i]["seat_count"] == 2, row, i, "fas fa-user accepted", "fas fa-user accepted", "far fa-user");
                        whatToDoAccordingToSeatCount(value["slot-" + i]["seat_count"] == 3, row, i, "fas fa-user danger", "fas fa-user danger", "fas fa-user danger");
                    }
                }
                row++;
            })

            arrayOfTimes = result[0];
            var i = 0;
            $.each(arrayOfTimes, function (key, value) {
                changeTime(i, value, key);
                i++;
            });
            addDisabledToSomeDateOfTodays();
        },
        error: function () {
            console.log("error");
        },
    });
}
//console.log(isMobile());
//if(isMobile()) {
//console.log('mobile');
let counter_arrow_left = 0;
let slotIndex = {};
let arrOfTimes = {};
$('.arrow-left').on('click', function () {
    counter_arrow_left++;
    switch (counter_arrow_left) {
        case 1:
            slotIndex = {"09:30:00": 1,"10:00:00": 2,"10:30:00": 3};
            arrOfTimes = {'09:30 - 10:00': '۹/۵','10:00 - 10:30': '۱۰','10:00 - 11:00': '۱۰/۵'};
            clickArrowLeftOnMobile(slotIndex, arrOfTimes);
            break;
        case 2:
            slotIndex = {"11:00:00": 1,"11:30:00": 2,"12:00:00": 3};
            arrOfTimes = {'11:00 - 11:30': '۱۱','11:30 - 12:00': '۱۱/۵','12:00 - 12:30': '۱۲'};
            clickArrowLeftOnMobile(slotIndex, arrOfTimes);
            break;
        case 3:
            slotIndex = {"12:30:00": 1,"13:00:00": 2,"13:30:00": 3};
            arrOfTimes = {'12:30 - 13:00': '۱۲/۵','13:00 - 13:30': '۱۳','13:30 - 14:00': '۱۳/۵'};
            clickArrowLeftOnMobile(slotIndex, arrOfTimes);
            break;
        case 4:
            slotIndex = {"14:00:00": 1,"14:30:00": 2,"15:00:00": 3};
            arrOfTimes = {'14:00 - 14:30': '۱۴','14:30 - 15:00': '۱۴/۵','15:00 - 15:30': '۱۵'};
            clickArrowLeftOnMobile(slotIndex, arrOfTimes);
            break;
        case 5:
            slotIndex = {"15:30:00": 1,"16:00:00": 2,"16:30:00": 3};
            arrOfTimes = {'15:30 - 16:00': '۱۵/۵','16:00 - 16:30': '۱۶','16:30 - 17:00': '۱۶/۵'};
            clickArrowLeftOnMobile(slotIndex, arrOfTimes);
            break;
        case 6:
            slotIndex = {"17:00:00": 1,"17:30:00": 2};
            arrOfTimes = {'17:00 - 17:30': '۱۷','17:30 - 18:00': '۱۷/۵'};
            clickArrowLeftOnMobile(slotIndex, arrOfTimes);
            break;
    }
});

//}
// let sw = 0;
function emptyTds() {
    $("td").each(function () {
        i_fontawesome = $(this).find("div").find("i");
        if (!i_fontawesome.hasClass("accepted") && !i_fontawesome.hasClass("danger")) {
            i_fontawesome.removeClass("fas fa-user");
            i_fontawesome.addClass("far fa-user");
        }

        $(this).removeClass("text-lightgray");
        $(this).addClass("cursor_pointer hoverable");
    });
}

function addDisabledToSomeDateOfTodays() {
    $("td").each(function () {
        if ($(this).hasClass("text-lightgray")) {
            $(this).find("div").find("i").removeClass("far fa-user");
            $(this).find("div").find("i").addClass("fas fa-user");
        }
        var column = $(this).closest("td").index();
        if ($(this).data("date") == todayDate) {
            column = $("tr").children(".c_" + column).data("time");
            arrOfTimes = column.split(" - ");
            if (todayTime > arrOfTimes[1] || (todayTime > arrOfTimes[0] && todayTime < arrOfTimes[1])) {
                $(this).find("div").find("i").removeClass("far fa-user");
                $(this).find("div").find("i").addClass("fas fa-user");
                $(this).addClass("text-lightgray");
                $(this).removeClass("cursor_pointer hoverable");
            }
        }
    });
}
// function cssClassesInTd(){
//     $("td").each(function(){
//         td_childs = $(this).find("div").find("i");
//             if(td_childs.hasClass("accepted") || td_childs.hasClass("danger")){
//                 td_childs.removeClass();
//                 td_childs.addClass("far fa-user");
//             }
//     });
// }
// function whatToDoAccordingToSeatCount(condition, row, i, firstClassToAdd, secondClassToAdd, thirdClassToAdd){
//     if(condition) {
//         $('table').find("tbody").find("tr:nth-child(" + row + ")").find("td:nth-child(" + (i+1) + ")").find("div").find("i:nth-child(1)").removeClass().addClass(firstClassToAdd);
//         $('table').find("tbody").find("tr:nth-child(" + row + ")").find("td:nth-child(" + (i+1) + ")").find("div").find("i:nth-child(2)").removeClass().addClass(secondClassToAdd);
//         $('table').find("tbody").find("tr:nth-child(" + row + ")").find("td:nth-child(" + (i+1) + ")").find("div").find("i:nth-child(3)").removeClass().addClass(thirdClassToAdd);
//     }
// }
// function disableSomeSlots(condition, row, i, is_mine){
//     if(condition && is_mine == 1) {
//         $('table').find("tbody").find("tr:nth-child(" + row + ")").find("td:nth-child(" + (i+1) + ")").removeClass("cursor_pointer hoverable").addClass("text-lightgray");
//     }
// }
function changeTime(i, value, key) {
    $("#id_" + i).text(value);
    $("#id_" + i).data("time", key);
    $("#id_" + i).attr("data-time", key);
}
// function saveOrCancel(button_txt, classToRemove, classToAdd){
//     $("#saveBtn").text(button_txt);
//     $("#saveBtn").removeClass(classToRemove);
//     $("#saveBtn").addClass(classToAdd);
// }
// let arrayOfTimes = [];
// $(".arrow-left").on("click", function () {
//     emptyTds();
//     $(".arrow-right").css("display", "block");
//     $.ajax({
//         url: route_ajaxtableleft,
//         type: "POST",
//         data: {
//             _token: csrf_token,
//         },
//         success: function (result) {
//             var slots = result[1];
//             var row = 1;
//             $.each(slots, function(key, value){
//                 if(Object.keys(value).length) {
//                    for( var i = 1; i <= 10; i++) {
//                         whatToDoAccordingToSeatCount(value["slot-" + i]["seat_count"] == 1, row, i, "fas fa-user accepted", "far fa-user", "far fa-user");
//                         disableSomeSlots(value["slot-"+ i]["seat_count"] == null && value["slot-" + i]["is_mine"] == null, row, i, full_user_slots[key]["is_mine"]);
//                         whatToDoAccordingToSeatCount(value["slot-"+ i]["seat_count"] == null && value["slot-" + i]["is_mine"] == null, row, i, "far fa-user", "far fa-user", "far fa-user");
//                         whatToDoAccordingToSeatCount(value["slot-" + i]["seat_count"] == 2, row, i, "fas fa-user accepted", "fas fa-user accepted", "far fa-user");
//                         whatToDoAccordingToSeatCount(value["slot-" + i]["seat_count"] == 3, row, i, "fas fa-user danger", "fas fa-user danger", "fas fa-user danger");
//                    }
//                 }
//                 row++;
//             })

//             arrayOfTimes = result[0];
//             var i = 0;
//             $.each(arrayOfTimes, function (key, value) {
//                 changeTime(i, value, key);
//                 i++;
//             });
//             addDisabledToSomeDateOfTodays();
//         },
//         error: function () {
//             console.log("error");
//         },
//     });
// });
// $(".arrow-right").on("click", function () {
//     emptyTds();
//     $(".arrow-right").css("display", "none");
//     $.ajax({
//         url: route_ajaxtableright,
//         type: "POST",
//         data: {
//             _token: csrf_token,
//         },
//         success: function (result) {
//             arrayOfTimes = result[0];
//             var slots = result[1];
//             var row = 1;
//             $.each(slots, function(key, value){
//                 if(Object.keys(value).length) {
//                     for( var i = 1; i <= 10; i++) {
//                         whatToDoAccordingToSeatCount(value["slot-" + i]["seat_count"] == 1, row, i, "fas fa-user accepted", "far fa-user", "far fa-user");
//                         disableSomeSlots(value["slot-"+ i]["seat_count"] == null && value["slot-" + i]["is_mine"] == null, row, i, full_user_slots[key]["is_mine"]);
//                         whatToDoAccordingToSeatCount(value["slot-"+ i]["seat_count"] == null && value["slot-" + i]["is_mine"] == null, row, i, "far fa-user", "far fa-user", "far fa-user");
//                         whatToDoAccordingToSeatCount(value["slot-" + i]["seat_count"] == 2, row, i, "fas fa-user accepted", "fas fa-user accepted", "far fa-user");
//                         whatToDoAccordingToSeatCount(value["slot-" + i]["seat_count"] == 3, row, i, "fas fa-user danger", "fas fa-user danger", "fas fa-user danger");
//                     }
//                  }
//                  row++;
//             })
//             var i = 0;
//             $.each(arrayOfTimes, function (key, value) {
//                 changeTime(i, value, key);
//                 i++;
//             });
//             addDisabledToSomeDateOfTodays();
//         },
//         error: function () {
//             console.log("error");
//         },
//     });
// });
// var arrOfTimes = [];

// function toPersianNum(num, dontTrim) {
//     var i = 0,
//         dontTrim = dontTrim || false,
//         num = dontTrim ? num.toString() : num.toString().trim(),
//         len = num.length,
//         res = "",
//         pos,
//         persianNumbers =
//             typeof persianNumber == "undefined"
//                 ? ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"]
//                 : persianNumbers;

//     for (; i < len; i++)
//         if ((pos = persianNumbers[num.charAt(i)])) res += pos;
//         else res += num.charAt(i);

//     return res;
// }
// $(document).ready(function () {
//     $("select.select2").select2();
//     addDisabledToSomeDateOfTodays();
//     $("td").on("click", function () {
//         if (!$(this).hasClass("text-lightgray")) {
//             $("#saveBtn").removeClass("display_none");
//         }
//         if ($(this).siblings().hasClass("text-lightgray") && $(this).data("date") != todayDate) {
//             saveOrCancel("لغو", "btn-primary", "btn-danger");
//         } else {
//             saveOrCancel("ذخیره", "btn-danger", "btn-primary");
//         }
//         var row = $(this).closest("tr").index() + 1;
//         var column = $(this).closest("td").index();
//         var date = $(this).data("date");
//         var nameofday = $(this).data("nameofday");
//         column = $("tr").children(".c_" + column).data("time");
//         var res = column.split(" - ");
//         if (nameofday != "جمعه" && !$(this).hasClass("text-lightgray") && !$(this).hasClass("bg-danger")) {
//             $("#day").css("display", "flex");
//             $("#time").css("display", "block");
//             $("#day").text(toPersianNum(date) + " " + nameofday);
//             $("#time").text(column);
//             $("#hidden_day").val(date);
//             $("#hidden_time1").val(res[0]);
//             $("#hidden_time2").val(res[1]);
//         }
//     });
// });
