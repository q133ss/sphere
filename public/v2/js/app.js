"use strict";

var countElementListMenu = $(".menu__list-items").length;

var _loop = function _loop(i) {
  $("#menuList-".concat(i)).on("click", function () {
    for (var j = 1; j <= countElementListMenu; j++) {
      $("#menuList-".concat(j)).removeClass("menu__list-items-active");
    }

    $("#menuList-".concat(i)).addClass("menu__list-items-active");
  });
};

for (var i = 1; i <= countElementListMenu; i++) {
  _loop(i);
}

$(".t-header__nav-client-profile").on("click", function () {
  $(".t-header__nav-client-list").toggleClass("display-n");
  $(".t-header__nav-client-arrow").toggleClass("rotate-180");
});
$(function () {
  if ($(".t-profile__info-student-items").length == 0) {
    $(".t-profile__info-student-nav").addClass("display-n");
    $(".t-profile__info-student-list").addClass("display-n");
    $(".t-profile__info-student-banner").removeClass("display-n");
  } else {
    $(".t-profile__info-student-nav").removeClass("display-n");
    $(".t-profile__info-student-list").removeClass("display-n");
    $(".t-profile__info-student-banner").addClass("display-n");
  }

  if ($(".t-profile__info-lessons-items").length == 0) {
    $(".t-profile__info-lessons-nav").addClass("display-n");
    $(".t-profile__info-lessons-list").addClass("display-n");
    $(".t-profile__info-lessons-banner").removeClass("display-n");
  } else {
    $(".t-profile__info-lessons-nav").removeClass("display-n");
    $(".t-profile__info-lessons-list").removeClass("display-n");
    $(".t-profile__info-lessons-banner").addClass("display-n");
  }
});
;
var eventDatesTeacher = {};
var countElementDataListTeacher = $(".t-schedule__list-items").length;

for (var _i = 1; _i <= countElementDataListTeacher; _i++) {
  var element = $(".t-schedule__list-items:nth-child(".concat(_i, ")")).text();
  eventDatesTeacher[new Date("".concat(element))] = new Date("".concat(element));
}

$(function () {
  var quizOrderDataCalendarInput = $("#datepickerScheduleTeacher").val();
  $(".t-schedule__info-list-title").text(quizOrderDataCalendarInput);
});
console.log($.datepicker);
$.datepicker.regional.ru = {
  closeText: "Закрыть",
  prevText: "Предыдущий",
  nextText: "Следующий",
  currentText: "Сегодня",
  monthNames: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
  monthNamesShort: ["Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек"],
  dayNames: ["воскресенье", "понедельник", "вторник", "среда", "четверг", "пятница", " суббота"],
  dayNamesShort: ["вск", "пнд", "втр", "срд", "чтв", "птн", "сбт"],
  dayNamesMin: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
  weekHeader: "Не",
  dateFormat: "dd.mm.yy",
  firstDay: 1,
  // minDate: 0,
  isRTL: false,
  showMonthAfterYear: false,
  yearSuffix: "",
  beforeShowDay: function beforeShowDay(date) {
    var highlight = eventDatesTeacher[date];

    if (highlight) {
      return [true, "t-active-date", ""];
    } else {
      return [true, "", ""];
    }
  }
};
$.datepicker.setDefaults($.datepicker.regional.ru);
$("#datepickerScheduleTeacher").datepicker().on("change", function () {
  $(".model-calendar").addClass("display-n");
  var quizOrderDataCalendarInput = $("#datepickerScheduleTeacher").val();
  $(".t-schedule__info-list-title").text(quizOrderDataCalendarInput);
  $("#modaldatepickerScheduleTeacher").val(quizOrderDataCalendarInput);
});

for (var _i2 = 1; _i2 <= $(".t-schedule__info-items").length; _i2++) {
  if (_i2 < 10) {
    $(".t-schedule__info-items:nth-child(".concat(_i2, ") .t-schedule__info-items-number")).text("0" + _i2);
  } else {
    $(".t-schedule__info-items:nth-child(".concat(_i2, ") .t-schedule__info-items-number")).text(_i2);
  }
}

$(".t-schedule__info-calendar-btn").on("click", function () {
  $(".modelScheduleTeacher").removeClass("display-n");
  $("body").css("overflow", "hidden");
});
$(".modelScheduleTeacher__wrappers-close").on("click", function () {
  $("body").css("overflow", "visible");
  $(".modelScheduleTeacher").addClass("display-n");
});
$(function () {
  $("#modaldatepickerScheduleTeacher").datepicker();
  $("#modalsdatepickerScheduleTeacher").datepicker();
});
$(function () {
  var selected = $(".modelScheduleTeacher__time-items").map(function () {
    if ($(this).html()) return $(this).html();
  }).get();
  $.each(selected, function (index, value) {
    var newElementBlock = document.createElement("option");
    newElementBlock.setAttribute("value", "".concat(value));
    newElementBlock.innerHTML = "".concat(value);
    var classNameTime = document.getElementsByClassName("modaltime")[0];
    classNameTime.appendChild(newElementBlock);
  });
});
var quizOrderDataCalendarInput = $("#datepickerScheduleTeacher").val();
$("#modaldatepickerScheduleTeacher").val(quizOrderDataCalendarInput);
$("#againDate").on("click", function () {
  $(".modelScheduleTeacher__wrappers-calendars").toggleClass("display-n");
});
;

var _loop2 = function _loop2(_i3) {
  for (var j = 1; j <= $(".t-question__list-block-items").length; j++) {
    $("#t_questionListElement_".concat(j, " .t-question__list-block-text")).addClass("display-n");
    $("#t_questionListElement_".concat(j, " .t-question__list-block-btn")).removeClass("rotate-45");
  }

  $("#t_questionListElement_".concat(_i3)).on("click", function () {
    if ($("#t_questionListElement_".concat(_i3, " .t-question__list-block-text")).hasClass("display-n")) {
      $("#t_questionListElement_".concat(_i3, " .t-question__list-block-text")).removeClass("display-n");
      $("#t_questionListElement_".concat(_i3, " .t-question__list-block-btn")).addClass("rotate-45");
    } else {
      $("#t_questionListElement_".concat(_i3, " .t-question__list-block-text")).addClass("display-n");
      $("#t_questionListElement_".concat(_i3, " .t-question__list-block-btn")).removeClass("rotate-45");
    }
  });
};

for (var _i3 = 1; _i3 <= $(".t-question__list-block-items").length; _i3++) {
  _loop2(_i3);
}

;

for (var _i4 = 1; _i4 <= $(".t-quiz__page-items").length; _i4++) {
  if (_i4 < 10) {
    $(".t-quiz__page-items:nth-child(".concat(_i4, ") .t-quiz__page-items-number")).text("0" + _i4);
  } else {
    $(".t-quiz__page-items:nth-child(".concat(_i4, ") .t-quiz__page-items-number")).text(_i4);
  }
}

var _loop3 = function _loop3(_i5) {
  $(".t-quiz__type-block-items:nth-child(".concat(_i5, ")")).on("click", function () {
    var type = $(".t-quiz__type-block-items:nth-child(".concat(_i5, ") p")).text();
    $(".t-quiz__age-title p").text(type);
    $(".t-quiz__book-title h3").text(type);
    $(".t-quiz__page-title h3").text(type);
    $(".t-quiz__type").addClass("display-n");
    $(".t-quiz__age").removeClass("display-n");
  });
};

for (var _i5 = 1; _i5 <= $(".t-quiz__type-block-items").length; _i5++) {
  _loop3(_i5);
}

var _loop4 = function _loop4(_i6) {
  $("#t_quizAgeElement_".concat(_i6)).on("click", function () {
    var age = $("#t_quizAgeElement_".concat(_i6, " p")).text();
    $(".t-quiz__book-title p").text(age);
    $(".t-quiz__page-title p").text(age);
    $(".t-quiz__age").addClass("display-n");
    $(".t-quiz__book").removeClass("display-n");
  });
};

for (var _i6 = 1; _i6 <= $(".t-quiz__age-items").length; _i6++) {
  _loop4(_i6);
}

for (var _i7 = 1; _i7 <= $(".t-quiz__book-items").length; _i7++) {
  $(".t-quiz__book-items:nth-child(".concat(_i7, ")")).on("click", function () {
    $(".t-quiz__book").addClass("display-n");
    $(".t-quiz__page").removeClass("display-n");
  });
}

for (var _i8 = 1; _i8 <= $(".t-quiz__page-items").length; _i8++) {
  $(".t-quiz__page-items").on("click", function () {
    $(".t-quiz__pages").removeClass("display-n");
  });
}

$(".t-quiz__age-back").on("click", function () {
  $(".t-quiz__age").addClass("display-n");
  $(".t-quiz__type").removeClass("display-n");
});
$(".t-quiz__book-back").on("click", function () {
  $(".t-quiz__book").addClass("display-n");
  $(".t-quiz__age").removeClass("display-n");
});
$(".t-quiz__page-back").on("click", function () {
  $(".t-quiz__page").addClass("display-n");
  $(".t-quiz__pages").addClass("display-n");
  $(".t-quiz__book").removeClass("display-n");
});
;

var _loop5 = function _loop5(_i9) {
  $(".t-student__info-list-items:nth-child(".concat(_i9, ")")).on("click", function () {
    $(".wrappers .t-student__info-chat").addClass("display-n");
    $(".wrappers .t-student__info-chat:nth-child(".concat(_i9 + 1, ")")).removeClass("display-n");
  });
};

for (var _i9 = 1; _i9 <= $(".t-student__info-list-items").length; _i9++) {
  _loop5(_i9);
}

;
$(function () {
  $("select.js-select").each(function () {
    var $this = $(this);
    var html = '<div class="js-select-css sort-select-item"><div class="sort-select-placeholder">';
    html += $this.find("option:eq(0)").text();
    html += '</div><div class="sort-select-block display-n"><div class="sort-select-wrapper">';
    $this.find("option:eq(0)").css("display", "none");
    $this.find("option").each(function () {
      html += '<button class="sort-select-element" data-val="' + $(this).attr("value") + '" type="button">' + $(this).text() + "</button>";
    });
    html += "</div></div></div></div>";
    $(html).insertAfter($this.hide());
    $('.sort-select-element[data-val="undefined"]').remove();
    var $next = $this.next();
    $next.find(".sort-select-placeholder").on("click", function (e) {
      e.preventDefault();
      $next.find(".sort-select-block").toggleClass("display-n"), $next.toggleClass("sort-select-item-active");
    }).end().find(".sort-select-element").on("click", function (e) {
      e.preventDefault();
      $next.find(".sort-select-placeholder").text($(this).text());
      $this.val($(this).data("val")).trigger("change");
      $next.find(".sort-select-placeholder").trigger("click");
    });
  });
});
;
$(".t-lesson__contact-timeline-progress").css("width", "".concat($(".t-lesson__contact-timeline-progress span").text(), "%"));
;
$(".t-edit__info-plus").on("click", function () {
  var a = 1;
  var elementsS = $(".t-edit__info-student input").attr("placeholder");
  var inviteSectionS = document.getElementsByClassName("t-edit__info-student")[0];
  var newElementS = document.createElement("div");
  newElementS.classList.add("t-edit__info-students");
  newElementS.innerHTML = "<input type=\"text\" placeholder=\"".concat(elementsS, "\" id='edit__student_").concat(a, "' />");
  inviteSectionS.appendChild(newElementS);
  var elementsT = $(".t-edit__info-time input").attr("placeholder");
  var inviteSectionT = document.getElementsByClassName("t-edit__info-time")[0];
  var newElementT = document.createElement("div");
  newElementT.classList.add("t-edit__info-times");
  newElementT.innerHTML = "<input type=\"text\" placeholder=\"".concat(elementsT, "\" id='edit__time_").concat(a, "' />");
  inviteSectionT.appendChild(newElementT);
  var elementsP = $(".t-edit__info-price input").attr("placeholder");
  var inviteSectionP = document.getElementsByClassName("t-edit__info-price")[0];
  var newElementP = document.createElement("div");
  newElementP.classList.add("t-edit__info-prices");
  newElementP.innerHTML = "<input type=\"text\" placeholder=\"".concat(elementsP, "\" id='edit__price_").concat(a, "' />");
  inviteSectionP.appendChild(newElementP);
  a++;
});
;
$('.s-header__nav-client-profile').on('click', function () {
  $('.s-header__nav-client-list').toggleClass('display-n');
  $('.s-header__nav-client-arrow').toggleClass('rotate-180');
});
;
$(function () {
  $("select.quiz-select").each(function () {
    var $this = $(this);
    var html = '<div class="quiz-select-css quiz-select-item"><div class="quiz-select-placeholder">';
    html += $this.find("option:eq(0)").text();
    html += '</div><div class="quiz-select-block display-n"><div class="quiz-select-wrapper">';
    $this.find("option:eq(0)").css("display", "none");
    $this.find("option").each(function () {
      html += '<button class="quiz-select-element" data-val="' + $(this).attr("value") + '" type="button">' + $(this).text() + "</button>";
    });
    html += "</div></div></div></div>";
    $(html).insertAfter($this.hide());
    $('.quiz-select-element[data-val="undefined"]').remove();
    var $next = $this.next();
    $next.find(".quiz-select-placeholder").on("click", function (e) {
      e.preventDefault();
      $next.find(".quiz-select-block").toggleClass("display-n"), $next.toggleClass("quiz-select-item-active");
    }).end().find(".quiz-select-element").on("click", function (e) {
      e.preventDefault();
      $next.find(".quiz-select-placeholder").text($(this).text());
      $this.val($(this).data("val")).trigger("change");
      $next.find(".quiz-select-placeholder").trigger("click");
    });
  });
});
$("#numberAllQuiz").html($(".elementQuiz").length);
var activeQuizElement = 0;
var elementQuizCount = 6;

var _loop6 = function _loop6(_i10) {
  $(".s-search__quiz-navig:nth-child(".concat(_i10, ")")).on("click", function () {
    changeSlide(_i10);
  });
};

for (var _i10 = 0; _i10 <= $(".s-search__quiz-navig").length; _i10++) {
  _loop6(_i10);
}

$(".s-search__quiz-btn").on("click", function () {
  changeSlide("next");
});

function displayElementQuiz() {
  $(".s-search__quiz-things").addClass("display-n");
  $(".s-search__quiz-long").addClass("display-n");
  $(".s-search__quiz-times").addClass("display-n");
  $(".s-search__quiz-stat").addClass("display-n");
  $(".s-search__quiz-student").addClass("display-n");
  $(".s-search__quiz-price").addClass("display-n");
}

function lastElementQuiz() {
  $(".s-search__quiz-btn").removeClass("display-n");
  $(".s-search__quiz-btns").addClass("display-n");
}

function activeNavQuiz() {
  for (var _i11 = 1; _i11 <= $(".s-search__quiz-navig").length; _i11++) {
    $(".s-search__quiz-navig:nth-child(".concat(_i11, ")")).removeClass("s-search__quiz-navig-active");
  }
}

function changeSlide(id) {
  if (id === "next") {
    activeQuizElement++;

    if (activeQuizElement === elementQuizCount) {
      activeQuizElement = 0;
    }
  }

  if (activeQuizElement == 0) {
    activeNavQuiz();
    $(".s-search__quiz-navig:nth-child(1)").addClass("s-search__quiz-navig-active");
    displayElementQuiz();
    lastElementQuiz();
    $(".s-search__quiz-things").removeClass("display-n");
    $("#numberActiveQuiz").html(1);
    $(".s-search__quiz-title h3").html("Выбор предмета");
  }

  if (activeQuizElement == 1) {
    activeNavQuiz();
    $(".s-search__quiz-navig:nth-child(2)").addClass("s-search__quiz-navig-active");
    displayElementQuiz();
    lastElementQuiz();
    $(".s-search__quiz-long").removeClass("display-n");
    $("#numberActiveQuiz").html(2);
    $(".s-search__quiz-title h3").html("Выбор длительности и интенсивности");
  }

  if (activeQuizElement == 2) {
    activeNavQuiz();
    $(".s-search__quiz-navig:nth-child(3)").addClass("s-search__quiz-navig-active");
    displayElementQuiz();
    lastElementQuiz();
    $(".s-search__quiz-times").removeClass("display-n");
    $("#numberActiveQuiz").html(3);
    $(".s-search__quiz-title h3").html("Время проведения занятий");
  }

  if (activeQuizElement == 3) {
    activeNavQuiz();
    $(".s-search__quiz-navig:nth-child(4)").addClass("s-search__quiz-navig-active");
    displayElementQuiz();
    lastElementQuiz();
    $(".s-search__quiz-stat").removeClass("display-n");
    $("#numberActiveQuiz").html(4);
    $(".s-search__quiz-title h3").html("Требования к репетитору");
  }

  if (activeQuizElement == 4) {
    activeNavQuiz();
    $(".s-search__quiz-navig:nth-child(5)").addClass("s-search__quiz-navig-active");
    displayElementQuiz();
    lastElementQuiz();
    $(".s-search__quiz-student").removeClass("display-n");
    $("#numberActiveQuiz").html(5);
    $(".s-search__quiz-title h3").html("Об ученике");
  }

  if (activeQuizElement == 5) {
    activeNavQuiz();
    $(".s-search__quiz-navig:nth-child(6)").addClass("s-search__quiz-navig-active");
    displayElementQuiz();
    lastElementQuiz();
    $(".s-search__quiz-price").removeClass("display-n");
    $(".s-search__quiz-btns").removeClass("display-n");
    $(".s-search__quiz-btn").addClass("display-n");
    $("#numberActiveQuiz").html(6);
    $(".s-search__quiz-title h3").html("Стоимость занятия");
  }

  if (id == 1) {
    activeQuizElement = 0;
    activeNavQuiz();
    $(".s-search__quiz-navig:nth-child(1)").addClass("s-search__quiz-navig-active");
    displayElementQuiz();
    lastElementQuiz();
    $(".s-search__quiz-things").removeClass("display-n");
    $("#numberActiveQuiz").html(1);
    $(".s-search__quiz-title h3").html("Выбор предмета");
  }

  if (id == 2) {
    activeQuizElement = 1;
    activeNavQuiz();
    $(".s-search__quiz-navig:nth-child(2)").addClass("s-search__quiz-navig-active");
    displayElementQuiz();
    lastElementQuiz();
    $(".s-search__quiz-long").removeClass("display-n");
    $("#numberActiveQuiz").html(2);
    $(".s-search__quiz-title h3").html("Выбор длительности и интенсивности");
  }

  if (id == 3) {
    activeQuizElement = 2;
    activeNavQuiz();
    $(".s-search__quiz-navig:nth-child(3)").addClass("s-search__quiz-navig-active");
    displayElementQuiz();
    lastElementQuiz();
    $(".s-search__quiz-times").removeClass("display-n");
    $("#numberActiveQuiz").html(3);
    $(".s-search__quiz-title h3").html("Время проведения занятий");
  }

  if (id == 4) {
    activeQuizElement = 3;
    activeNavQuiz();
    $(".s-search__quiz-navig:nth-child(4)").addClass("s-search__quiz-navig-active");
    displayElementQuiz();
    lastElementQuiz();
    $(".s-search__quiz-stat").removeClass("display-n");
    $("#numberActiveQuiz").html(4);
    $(".s-search__quiz-title h3").html("Требования к репетитору");
  }

  if (id == 5) {
    activeQuizElement = 4;
    activeNavQuiz();
    $(".s-search__quiz-navig:nth-child(5)").addClass("s-search__quiz-navig-active");
    displayElementQuiz();
    lastElementQuiz();
    $(".s-search__quiz-student").removeClass("display-n");
    $("#numberActiveQuiz").html(5);
    $(".s-search__quiz-title h3").html("Об ученике");
  }

  if (id == 6) {
    activeQuizElement = 5;
    activeNavQuiz();
    $(".s-search__quiz-navig:nth-child(6)").addClass("s-search__quiz-navig-active");
    displayElementQuiz();
    lastElementQuiz();
    $(".s-search__quiz-price").removeClass("display-n");
    $(".s-search__quiz-btns").removeClass("display-n");
    $(".s-search__quiz-btn").addClass("display-n");
    $("#numberActiveQuiz").html(6);
    $(".s-search__quiz-title h3").html("Стоимость занятия");
  }
}

function removeTimeElement(e) {
  var valueElement = e.value;

  if ($(".s-search__quiz-time-items").length == 1) {} else {
    $("#".concat(valueElement)).remove();
  }
}

;
var eventDatesStudent = {};
var countElementDataListStudent = $(".s-schedule__list-items").length;

for (var _i12 = 1; _i12 <= countElementDataListStudent; _i12++) {
  var _element = $(".s-schedule__list-items:nth-child(".concat(_i12, ")")).text();

  eventDatesStudent[new Date("".concat(_element))] = new Date("".concat(_element));
} // $(() => {
// 	let quizOrderDataCalendarInput = $("#datepickerScheduleStudent").val();
// 	$(".s-schedule__info-list-title").text(quizOrderDataCalendarInput);
// });


$.datepicker.regional.ru = {
  closeText: "Закрыть",
  prevText: "Предыдущий",
  nextText: "Следующий",
  currentText: "Сегодня",
  monthNames: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
  monthNamesShort: ["Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек"],
  dayNames: ["воскресенье", "понедельник", "вторник", "среда", "четверг", "пятница", " суббота"],
  dayNamesShort: ["вск", "пнд", "втр", "срд", "чтв", "птн", "сбт"],
  dayNamesMin: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
  weekHeader: "Не",
  dateFormat: "dd.mm.yy",
  firstDay: 1,
  // minDate: 0,
  isRTL: false,
  showMonthAfterYear: false,
  yearSuffix: "",
  beforeShowDay: function beforeShowDay(date) {
    var highlight = eventDatesStudent[date];

    if (highlight) {
      return [true, "s-active-date", ""];
    } else {
      return [true, "", ""];
    }
  }
};
$.datepicker.setDefaults($.datepicker.regional.ru);
$("#datepickerScheduleStudent").datepicker().on("change", function () {
  $(".model-calendar").addClass("display-n");
  var quizOrderDataCalendarInput = $("#datepickerScheduleStudent").val();
  $(".s-schedule__info-list-title").text(quizOrderDataCalendarInput);
});

for (var _i13 = 1; _i13 <= $(".s-schedule__info-items").length; _i13++) {
  if (_i13 < 10) {
    $(".s-schedule__info-items:nth-child(".concat(_i13, ") .s-schedule__info-items-number")).text("0" + _i13);
  } else {
    $(".s-schedule__info-items:nth-child(".concat(_i13, ") .s-schedule__info-items-number")).text(_i13);
  }
}

$(".s-schedule__info-calendar-btn").on("click", function () {
  $(".modelScheduleTeacher").removeClass("display-n");
  $("body").css("overflow", "hidden");
});
$(".modelScheduleTeacher__wrappers-close").on("click", function () {
  $("body").css("overflow", "visible");
  $(".modelScheduleTeacher").addClass("display-n");
});
;

var _loop7 = function _loop7(_i14) {
  $(".s-teacher__info-list-items:nth-child(".concat(_i14, ")")).on("click", function () {
    $(".wrappers .s-teacher__info-chat").addClass("display-n");
    $(".wrappers .s-teacher__info-chat:nth-child(".concat(_i14 + 1, ")")).removeClass("display-n");
  });
};

for (var _i14 = 1; _i14 <= $(".s-teacher__info-list-items").length; _i14++) {
  _loop7(_i14);
}

;
$(function () {
  $(".s-found__title p").html("(" + $(".s-found__items").length + ")");
});
;