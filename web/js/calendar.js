var daysInMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
var monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

// Returns the number of days in the month in a given year (January=0)
function getDaysInMonth(month, year) {
    if ((month == 1) && (year % 4 == 0) && ((year % 100 != 0) || (year % 400 == 0))) {
        return 29;
    } else {
        return daysInMonth[month];
    }
}

// Performs an action when a date is clicked
function dateClicked(day, month, year) {
    document.forms.calendar.date.value = day + '/' + month + '/' + year;

}

// Sets the displayed month
function setDisplayedMonth(month) {
    if (month < 0) {
        alert('You have reached the beginning of this calendar');
    } else if (month >= months) {
        alert('You have reached the end of this calendar');
    } else {
        for (var i = 0; i < 12; i++) {
            document.getElementById('calendarMonth' + i).style.display = 'none';
        }
        document.getElementById('calendarMonth' + month).style.display = 'block';
    }
}


