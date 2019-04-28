// This functions fills in all the calendar data.  It is called when the program starts and when the month is changed.
function fillInCalendar(){
    updateCalendarDates();
    var monthToFillIn = {};
    var previousMonthIndex;
    month_data.forEach(function(month, i){
        if(month.year == data.calendar.year && month.month_index == data.calendar.month){
            monthToFillIn = month;
            previousMonthIndex = i - 1;
        }
    });
    
    let days = document.getElementsByTagName("td");
    let currentMonthCount = 1;
    let previousMonthCount = month_data[previousMonthIndex].amount_of_days - monthToFillIn.starting_day + 1;
    let nextMonthCount = 1;
    
    cleanCells();
    for(let i = 0; i < days.length; i++){
        
        // Filling current month.
        if(monthToFillIn.starting_day <= i && currentMonthCount <= monthToFillIn.amount_of_days){
            fillPartialMonthData(days[i], currentMonthCount, monthToFillIn, "current");
            currentMonthCount++;
            
        // Filling previous month.
        } else if(currentMonthCount <= monthToFillIn.amount_of_days){
            fillPartialMonthData(days[i], previousMonthCount, month_data[previousMonthIndex], "previous");
            previousMonthCount++;
            
        // Filling next month.
        } else {
            fillPartialMonthData(days[i], nextMonthCount, month_data[previousMonthIndex + 2], "next");
            nextMonthCount++;
        }
    }
    changeColor();
}


function fillPartialMonthData(day, count, monthObject, month){
    day.innerHTML = count;
    if(month == "current"){
        if(count == data.current_date.date && calenderMonthIsCurrentMonth()){
            day.setAttribute("id", "current-day");
        }
    } else {
        day.classList.add("color");
        if(month == "previous" && count == monthObject.amount_of_days){
            day.classList.add("prev-month-last-day");
        }
    }
    
    uid = getUID(monthObject.month_index, monthObject.year, count);
    day.setAttribute("data-uid", uid);
    appendSpriteToCellAndTooltip(uid, day);
}




// Thus function generates a unique id based on a month, year and day.
function getUID(month, year, day){
    if(month == 12){
        month = 0;
        year++;
    }
    return month.toString() + year.toString() + day.toString();
}



function appendSpriteToCellAndTooltip(uid, elem){
    for(let i = 0; i < post_its.length; i++){
        if(uid == post_its[i].id){
            elem.innerHTML += `<img src='images/note${post_its[i].note_num}.png' alt='A post-it note'>`;
            elem.classList.add("tooltip");
            elem.innerHTML += `<span>${post_its[i].note}</span>`;
        }
    }
}



// This function is used to determine whether the calendar month is also the current month.
// It's needed to know if the program should set a #current-day when running fillInCalendar()
function calenderMonthIsCurrentMonth(){
    if(data.current_date.year == data.calendar.year && data.current_date.month == data.calendar.month){
        return true;
    } else {
        return false;
    }
}



// This function is used to remove all unnecessary cell attributes. IE: color, prev-month-last-day.
function cleanCells(){
    removeCurrentDayId();
    var tableCells = document.getElementsByTagName("td");
    for(let i = 0; i < tableCells.length; i++){
        removeClass(tableCells[i], "color");
        removeClass(tableCells[i], "prev-month-last-day");
        removeClass(tableCells[i], "tooltip");
        removeAttribute(tableCells[i], "style");
    }
}



// When the calendar is updated the current-day id will persist. This code removes it.  Is called in cleanCell()
function removeCurrentDayId(){
    if(document.getElementById("current-day")){
        document.getElementById("current-day").removeAttribute("id", "");
    }
}



// This function takes the calendar data and increases the month by 1.
function nextMonth(){
    if(data.calendar.month != 11 || data.calendar.year == 2018){
        data.calendar.month++;
    }
    if(data.calendar.month >= 12){
        data.calendar.month = 0;
        data.calendar.year++;
    }
    fillInCalendar();
}



// This function takes the calendar data and decreases the month by 1.
function previousMonth(){
    if(data.calendar.month != 11 || data.calendar.year == 2019){
        data.calendar.month--;
    }
    if(data.calendar.month <= -1){
        data.calendar.month = 11;
        data.calendar.year--;
    }
    fillInCalendar();
}



// This triggers the nextMonth() and previousMonth() with arrow keys.
document.onkeydown = function(e) {
    switch (e.keyCode) {
        case 37: previousMonth(); break;
        case 39: nextMonth(); break;
    }
};