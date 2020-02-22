
// @TODO Merge this script with moneyline.js

/**************************************************/
function isPassWord(string) {
	var string = new String(string);
	if (string.length < 6)
		return false;
    else
        return true;
}

function logout() {
	
	if(confirm('Are you sure you want to logout?'))
		{ document.location.href = 'logout.php?'}
}

/**************************************************/
function isEmail(string) {
	var string = new String(string);
    if (string.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) != -1)
        return true;
    else
        return false;
}

/**************************************************/
function test_digits(string) {
  var string = new String(string);
  for (var i=0;i < string.length;i++)
     if (isNaN(string.charAt(i)))
          return false;

 return true;
}

/**************************************************/
function replaceCarriageReturn(string,text,by) {
	var string = new String(string);
// Replaces text with by in string
    var strLength = string.length, txtLength = text.length;
    if ((strLength == 0) || (txtLength == 0)) return string;

    var i = string.indexOf(text);
    if ((!i) && (text != string.substring(0,txtLength))) return string;
    if (i == -1) return string;

    var newstr = string.substring(0,i) + by;

    if (i+txtLength < strLength)
        newstr += replaceCarriageReturn(string.substring(i+txtLength,strLength),text,by);

    return newstr;
}


function trim(strText) { 

    //strText = replaceCarriageReturn(replaceCarriageReturn(strText,'\r',''),'\n','');

	// this will get rid of leading spaces 
    while ((strText.substring(0,1) == ' ')||(strText.substring(0,2) == '\r')) 
        strText = strText.substring(1, strText.length);

    // this will get rid of trailing spaces 
    while ((strText.substring(strText.length-1,strText.length) == ' ')||(strText.substring(strText.length-2,strText.length) == '\r'))
        strText = strText.substring(0, strText.length-1);

   return strText;
} 



function replaceString(string,text,by) {
	var string = new String(string);
// Replaces text with by in string
    var strLength = string.length, txtLength = text.length;
    if ((strLength == 0) || (txtLength == 0)) return string;

    var i = string.indexOf(text);
    if ((!i) && (text != string.substring(0,txtLength))) return string;
    if (i == -1) return string;

    var newstr = string.substring(0,i) + by;

    if (i+txtLength < strLength)
        newstr += replaceCarriageReturn(string.substring(i+txtLength,strLength),text,by);

    return newstr;
}



/**************************************************/
//add zeros to amount
function add_zeros(str)
{

    var index = str.indexOf(".");
    var len = str.length;
    var first = 0;
    var last = len-1;
    var sec_last = len-2;

    if (index == -1)
      str = str+".00"

    else
      {
        if (!(index > first && index <  sec_last))
         {
           if (index == first)
            {
              str = "0" + str;
              index = str.indexOf(".");
              sec_last = str.length-2;
              if (index == sec_last)
                 str = str + "0";

            }

           else if(index == sec_last)
               str = str + "0";

           else if(index > sec_last)
             str = str + "00";
         }

      }
    return str
}

/**************************************************/

function outputMoney(number) {
    return outputDollars(Math.floor(number-0) + '') + outputCents(number - 0);
}

/**************************************************/
function outputDollars(number) {
    if (number.length <= 3)
        return (number == '' ? '0' : number);
    else {
        var mod = number.length%3;
        var output = (mod == 0 ? '' : (number.substring(0,mod)));
        for (i=0 ; i < Math.floor(number.length/3) ; i++) {
            if ((mod ==0) && (i ==0))
                output+= number.substring(mod+3*i,mod+3*i+3);
            else
                output+= ',' + number.substring(mod+3*i,mod+3*i+3);
        }
        return (output);
    }
}
/**************************************************/
function outputCents(amount) {
    amount = Math.round( ( (amount) - Math.floor(amount) ) *100);
    return (amount < 10 ? '.0' + amount : '.' + amount);
}

/**************************************************/
function DayOfWeek(month,day,year)
{

    month = parseInt(month);
    day = parseInt(day);

    var a = Math.floor((14 - month)/12);
    var y = year - a;
    var m = month + 12*a - 2;
    var d = (day + y + Math.floor(y/4) - Math.floor(y/100) +
             Math.floor(y/400) + Math.floor((31*m)/12)) % 7;

    return d;
}

/**************************************************/
function getWeekend(day)
{
  var daysofweek = new Array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');

  if (day == 0 || day == 6)
   {
      if (day == 0)
        return daysofweek[0];
     else
        return daysofweek[6];
   }
  else
   return -1;

}

/**************************************************/
function datePosition(m1,d1,y1,m2,d2,y2,flag)
{
  if (m1 < 10 && m1.len < 2)
    m1 = "0" + m1;

  if (m2 < 10 && m2.len < 2)
    m2 = "0" + m2;

  if (d1 < 10 && d1.len < 2)
    d1 = "0" + d1;

  if (d2 < 10 && d2.len < 2)
    d2 = "0" + d2;

  /*
     type 5 : 05/29/1997

     'flag' determines if we are comparing date1 with todays date or not
     Returns -1 if the date1 is behind date2
     Returns 0 if the date1 is equal to date2
     Returns 1 if the date1 is ahead of date2

     Added Y2K checking.  (Works for any century cross over)
  */

    //date format needs to be "mm/dd/yyyy"
    dateString1 = m1 + "/" + d1 + "/" + y1;

    var now = getDateTime();//new Date();
    var date2 = null;

    if (flag==1)
      {
        var dateString2 = m2 + "/" + d2 + "/" + y2;
        date2 = new Date(dateString2.substring(6,10),
                            dateString2.substring(0,2)-1,
                            dateString2.substring(3,5));
      }


    else
      date2 = new Date(now.getFullYear(),now.getMonth(),now.getDate());

		var time = getDateTime(); // new Date()
		var hours = time.getHours();
		if (hours > _cutOffTime) {
			var days = 1;
			date2 = addWorkingDays(date2,days);
		}

	  var date1 = new Date(dateString1.substring(6,10),
                            dateString1.substring(0,2)-1,
                            dateString1.substring(3,5));

    if (date1 < date2)
       return -1;

    else if (date1 > date2)
       return 1;

    else
      return 0;

}
/**************************************************/
function y2k(number)
{
  return (number < 1000) ? number + 1900 : number;
}

/**************************************************/
function isValidDate (day,month,year)
{
  // checks if date passed is valid
    var today = new Date();
    year = ((!year) ? y2k(today.getFullYear()):year);
    month = ((!month) ? today.getMonth():(month-1));
    if (!day) return false
    var test = new Date(year,month,day);
    if ( (y2k(test.getFullYear()) == year) &&
         (month == test.getMonth()) &&
         (day == test.getDate()) )
        return true;
    else
        return false
}

/**************************************************/
function isSOValidDate (day, month, year, today_day, today_month, today_year) {
	if(!isValidDate(day,month,year))
		return false;

	if (today_day == "" || today_month == "" || today_year == "")	{
		var today = new Date();
		today_year = y2k(today.getFullYear());
		today_month = today.getMonth();
		today_day = today.getDate()+1;
	}
    var _today = new Date(today_year, today_month, today_day);
	var _passed = new Date(year, month-1, day);

    if (_today.getTime() <= _passed.getTime())
        return true;
    else
        return false
}

/**************************************************/
function makeArray(n) {
this.length = n;
return this;
}
//
// global declarations and initialization
//
function init () {
theDate         = new Date();
today           = new Date();
currMonth       = today.getMonth();
msPerDay        = 24*60*60*1000;
cookieString    = "dispMonth="+currMonth+";";
document.cookie = cookieString;
startOfString   = document.cookie.indexOf("dispMonth");
countbegin      = document.cookie.indexOf("=",startOfString) + 1;
countend        = document.cookie.indexOf(";",countbegin);
if (countend == -1) {
countend = document.cookie.length;
}
dispMonth     = eval ("document.cookie.substring(countbegin,countend)");
firstOfMonth  = new Date(today.getYear(),dispMonth,1);
monthName     = new makeArray(12);
monthName[1]  = "January";
monthName[2]  = "February";
monthName[3]  = "March";
monthName[4]  = "April";
monthName[5]  = "May";
monthName[6]  = "June";
monthName[7]  = "July";
monthName[8]  = "August";
monthName[9]  = "September";
monthName[10] = "October";
monthName[11] = "November";
monthName[12] = "December";
}
//
// entry point
//
function openCalendar (monthFldName, dateFldname, yearFldname, formNumber) {
init();
formNum  = formNumber;
//NQF: begin
//added to accept LHS variable of this type : arr(x)
for (var j=0; j< document.forms[formNum].length ; j++) {
if ( document.forms[formNum].elements[j].name.toLowerCase() == monthFldName.toLowerCase()) {
monthFld = "elements["+j+"]";
}
if ( document.forms[formNum].elements[j].name.toLowerCase() == dateFldname.toLowerCase() ) {
dateFld = "elements["+j+"]";
}
if ( document.forms[formNum].elements[j].name.toLowerCase() == yearFldname.toLowerCase() ) {
yearFld = "elements["+j+"]";
}

}
//NQF: end
windowOptions  = "toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=no,copyhistory=yes,width=210,height=250";
calendarWindow = this.open("","calendarWindow",windowOptions);
calendarWindow.callingForm = this;
redraw();
}
//
// repaint the calendar
//
function redraw() {
calendarWindow.callingForm = this;
//Y2K Browser compatibility issues. getYear() function works for IE.. but had to be
//altered to appear correctly for Netscape.
if (navigator.appName =='Netscape' ) {
newYear = today.getYear();
newYear = 1900 + newYear;
}
else {  newYear = today.getYear();
}
firstOfMonth = new Date(newYear,dispMonth,1);
//End Y2K Browser fix.
calendarWindow.document.open();
calTitle = "<TITLE>Please choose a date:</TITLE>";
calendarWindow.document.write(calTitle);
drawCalendar(firstOfMonth);
calendarWindow.document.write(htmlBuffer);
calendarWindow.document.close();
calendarWindow.callingForm = this;
calendarWindow.focus();
}
//
// fill the calling forms date and month
//
function fillDate(filler,year) {
var m = monthNum-1;
var d = filler-1;
var y = year;
eval("document.forms[" + formNum + "]." + monthFld + ".selectedIndex=" + m);
eval("document.forms[" + formNum + "]." + dateFld  + ".selectedIndex=" + d);
eval("document.forms[" + formNum + "]." + yearFld  + ".selectedIndex=" + y);

}
//
// set the month
//
function changeMonth (increment) {
nextMonth = dispMonth;
if (increment == 1) {
nextMonth++ ;
} else {
nextMonth-- ;
}

date1 = new Date();
curr_year = date1.getFullYear();

if ( (nextMonth < currMonth) || (year - curr_year == 1+1))
{
  nextMonth = currMonth;
}
dispMonth = nextMonth;
document.cookie="dispMonth="+nextMonth;
redraw();
}
//
// generate the calendar document
//
function drawCalendar (theDate) {
monthNum = theDate.getMonth() + 1;
htmlBuffer  = "<HTML>";
htmlBuffer += "<BODY topmargin=0 leftmargin=0 marginwidth=0 marginheight=0>";
htmlBuffer += "<TABLE align=center border=0 cellspacing=0 cellpadding=0 bordercolor=yellow>";
htmlBuffer += "<TR>";
htmlBuffer += "<TD>";
htmlBuffer += "<CENTER><br>";
htmlBuffer += "<FORM action=\"\" method=\"post\">";
htmlBuffer += "<TABLE BORDER=1 WIDTH=200 cellspacing=0 cellpadding=0>";
htmlBuffer += "<TR ALIGN=CENTER>";
htmlBuffer += "<TD COLSPAN=2><INPUT TYPE=BUTTON NAME=monthDn value=\"<<\" onClick=callingForm.changeMonth(-1)>";
htmlBuffer += "</TD>";
htmlBuffer += "<TD COLSPAN=3> ";
htmlBuffer += "<font color=BLUE><b>";
htmlBuffer += monthName[monthNum];
// getYear returns the year in year - 1900
// this causes ugly display
var tempYear = theDate.getYear()
if ( tempYear <= 1900 ) {
tempYear += 1900;
}
htmlBuffer += " " + tempYear;
htmlBuffer += "</b></font>";
htmlBuffer += "</TD>";
htmlBuffer += "<TD COLSPAN=2><INPUT TYPE=BUTTON NAME=monthUp value=\">>\" onClick=callingForm.changeMonth(1)>";
htmlBuffer += "</TD>";
htmlBuffer += "</TR>";
htmlBuffer += "</TABLE>"
htmlBuffer += "<TABLE BORDER=1 WIDTH=200 cellspacing=0 cellpadding=0>";
htmlBuffer += "<TR ALIGN=CENTER>";
htmlBuffer += "<TD><b><font color=#000000>S</font></b></TD><TD><b><font color=#000000>M</font></b></TD><TD><b><font color=#000000>T</font></b></TD><TD><b><font color=#000000>W</font></b></TD><TD><b><font color=#000000>T</font></b></TD><TD><b><font color=#000000>F</font></b></TD><TD><b><font color=#000000>S</font></b></TD>";
htmlBuffer += "</TR>";
drawBody(theDate);
htmlBuffer += "</TABLE>";
htmlBuffer += "<TABLE BORDER=0 WIDTH=200 cellspacing=0 cellpadding=0>";
htmlBuffer += "<TR ALIGN=CENTER>";
htmlBuffer += "<TD colspan=7>";
htmlBuffer += "<center><INPUT TYPE=IMAGE SRC=\"images/close.gif\" onclick=\"javascript:window.close()\"></center>";
htmlBuffer += "</TD>";
htmlBuffer += "</TR>";
htmlBuffer += "</TABLE>";
htmlBuffer += "</FORM>";
htmlBuffer += "</TD>";
htmlBuffer += "</TR>";
htmlBuffer += "</TABLE>";
htmlBuffer += "</BODY></HTML>";
}
//
// generate the calendar body
//
function drawBody (theDate)
{
  thisMonth = theDate.getMonth();
  thisDate  = theDate.getDate();
  firstSunday(theDate);
  for (w=0; w<6; w++)
    {
      htmlBuffer += "<TR>";
      for (d=0; d<7; d++) {
  date = theDate.getDate();
  year = theDate.getYear();

  temp = new Date();
  current_year = temp.getFullYear();

  year_index = year - current_year;

 htmlBuffer   += "<TD ALIGN=CENTER>";
// skip previous month
if (theDate.getMonth() != thisMonth)
{
   htmlBuffer += "<BR>";
}
else
 {
   htmlBuffer += "<INPUT TYPE=BUTTON NAME=";
   htmlBuffer += date;
   htmlBuffer += " VALUE=";
   if ( date < 10 ) {
   htmlBuffer += "0";
   }
  htmlBuffer += date;
    htmlBuffer += " onClick=\"callingForm.fillDate(" + date + "," + year_index + ")\">"; 
 // htmlBuffer += " onClick=\"callingForm.fillDate(" + date + "," + year_index + ");callingForm.changeDays(0, callingForm.document.dateform);\">";
}
// increment the date
newTime = theDate.getTime() + msPerDay;
theDate.setTime(newTime);
// check for DST
if (theDate.getHours() != 23)
   {
     theDate.setTime(newTime + 3600000);
   }
 htmlBuffer += "</TD>";
}

  htmlBuffer += "</TR>";
 }

}
//
// reset the startdate to get the
// previous sunday before the current date
// so that the drawing can begin from a sunday
//
function firstSunday (fromDate) {
while (fromDate.getDay() != 0) {
newTime = fromDate.getTime() - msPerDay;
fromDate.setTime(newTime);
}
}


<!--BEGIN
//Cut-N-Paste JavaScript from ISN Toolbox
//copyright 1998, Infohiway, Inc.  Restricted use is hereby granted (commercial and personal OK) so long
// as this code is not *directly* sold and the copyright notice is buried somewhere deep in your HTML document.

var min_year = 2000; // defines lowest year in year menu
var max_year = 2001; // defines highest year in the year menu

// make this false to prevent the weekday element from being displayed
var weekday_showing = true;

// make this true to make dayofweek return a number (0-6)
var dayofweek_returned_as_number = false;

// make this true to make month return a number (0-11)
var month_returned_as_number = false;

if (min_year <= 400)
 alert("Minimum year must be higher than 400 for this algorithm to work.");

function changeDays(numb,date_form) {
 mth = date_form.month.selectedIndex;
 sel = date_form.year.selectedIndex;
 yr = date_form.year.options[sel].text;
 if (numb != 1) {
  numDays = numDaysIn(mth,yr);
  date_form.day.options.length = numDays;
  for (i=27;i<numDays;i++) {
   date_form.day.options[i].text = i+1;
  }
 }
 day = date_form.day.selectedIndex+1;
 if (weekday_showing)
   {
      var index =  getWeekDay(mth,day,yr);
      date_form.dayofweek.options.length = 2;
      date_form.dayofweek.options[1].text = weekdays[index];
      date_form.dayofweek.options[1].selected = true;
   }
}
function numDaysIn(mth,yr) {
 if (mth==3 || mth==5 || mth==8 || mth==10) return 30;
 else if ((mth==1) && leapYear(yr)) return 29;
 else if (mth==1) return 28;
 else return 31;
}
function leapYear(yr) {
 if (((yr % 4 == 0) && yr % 100 != 0) || yr % 400 == 0)
  return true;
 else
  return false;
}
function arr() {
 this.length=arr.arguments.length;
 for (n=0;n<arr.arguments.length;n++) {
  this[n] = arr.arguments[n];
 }
}

weekdays = new arr("Sun","Mon","Tues","Wed", "Thur","Fri","Sat");
// *** comment out the one you don't want to use ***
//weekdays = new arr("Sunday","Monday","Tuesday",
//"Wednesday","Thursday","Friday","Saturday");

months = new arr("Jan.","Feb.","Mar.","Apr.","May",
 "June","July","Aug.","Sep.","Oct.","Nov.","Dec.");
// *** comment out the one you don't want to use ***
//months = new arr("January","February","March","April","May",
// "June","July","August","September","October","November","December");

var cur = new Date();

function getWeekDay(mth,day,yr) {
 first_day = firstDayOfYear(yr);
 for (num=0;num<mth;num++) {
  first_day += numDaysIn(num,yr);
 }
 first_day += day-1;
 return first_day%7;
}
function firstDayOfYear(yr) {
 diff = yr - 401;
 return parseInt((1 + diff + (diff / 4) - (diff / 100) + (diff / 400)) % 7);
}
// fixes a Netscape 2 and 3 bug
function getFullYear(d) { // d is a date object
 yr = d.getYear();
 if (yr < 1000)
  yr+=1900;
 return yr;
}

function addWorkingDays(myDate,days) {
	//myDate = starting date, days = no. working days to add.
	var temp_date = new Date();
	var i = 0;
	var days_to_add = 0;

		while (i < (days)){
			temp_date = new Date(myDate.getTime() + (days_to_add*24*60*60*1000));
			//0 = Sunday, 6 = Saturday, if the date not equals a weekend day then increase by 1

			if ((temp_date.getDay() != 0) && (temp_date.getDay() != 6)){
				i+=1;
			}
			days_to_add += 1;
		}

	return new Date(myDate.getTime() + days_to_add*24*60*60*1000);
}

function IsNumeric(nVal){
	if (trim(nVal) == "")
		return false;

	if(isNumber(nVal) == false)
		return false;

	nVal = (isEmptyNumber(nVal)) ?  '0' :  nVal;
	nVal = parseInt(stripAllChars(nVal, ','));

	if(isNaN(nVal))
		return false;

	if (nVal <= 0)
		return false;

	return true;
}

function isNumber(sText) {
   var ValidChars = "0123456789.";
   var IsNumber=true;
   var Char;
 
   for (i = 0; i < sText.length && IsNumber == true; i++) { 
      Char = sText.charAt(i); 
      if (ValidChars.indexOf(Char) == -1) {
         IsNumber = false;
      }
   }

   return IsNumber;
}

function isEmptyNumber(s) {   
	return ((s == null) || (s.length == 0))
}

function stripAllChars(s, bag) {   
	var i;
    var returnString = "";

    for (i = 0; i < s.length; i++)
    {   
        // Check that current character isn't whitespace.
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1) 
			returnString += c;
    }
    return returnString;
}


