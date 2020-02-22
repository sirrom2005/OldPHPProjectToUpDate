function float_to_int(s)

{var i;
    var result = 0;

    s = s+' ';
    for (i = 0; i < s.length; i++)
    {
        // Check that current character is number.
        var c = s.charAt(i);
        if (c != '.')
          result = result+c;
        else
          return result * 1;
    }
    return result * 1;
}

function dollars_to_words(money){

  var ones_words;
  var teens_words;
  var tens_words;
  var index=0;
  var mon=0;
  var sMoney;

 ones_words = ['','One','Two','Three','Four','Five','Six','Seven','Eight',
                      'Nine','Ten'];
 teens_words = ['','Eleven','Twelve','Thirteen','Fourteen','Fifteen',
                      'Sixteen','Seventeen','Eighteen','Nineteen'];
 tens_words = ['','Ten','Twenty','Thirty','Forty','Fifty','Sixty','Seventy',
                      'Eighty','Ninety'];

 if (money == 0){
   sMoney = "Zero";
 }
 if (money >= 1000000.0){
   mon = float_to_int(money/1000000);
       if ((money - mon * 1000000) > 100 || (money - mon * 1000000) == 0)
          sMoney = dollars_to_words(mon)+' Million '+dollars_to_words(money - mon * 1000000);
       else
          sMoney = dollars_to_words(mon)+' Million and '+dollars_to_words(money - mon * 1000000);
 }
 else
   if (money >= 1000.0){
     mon = float_to_int(money/1000);
   //  mon = Math.round(money/1000);
     if (( money -  mon * 1000) > 100 || (money - mon * 1000) == 0)
       sMoney = dollars_to_words(mon)+' Thousand '+dollars_to_words( money -  mon * 1000);
     else
       sMoney = dollars_to_words( mon)+' Thousand and '+dollars_to_words( money -  mon * 1000);
   }
   else
     if (money >= 100.0){
       s = money/100;
       mon = float_to_int(s);
    //   mon = Math.round(s);
       if ((money -  mon * 100) > 100 || ( money -  mon * 100) == 0)
          sMoney = dollars_to_words( mon)+' Hundred '+dollars_to_words( money -  mon * 100);
       else
          sMoney = dollars_to_words( mon)+' Hundred and '+dollars_to_words( money -  mon * 100);
     }
     else
       if ( money > 10.0 &&  money < 20.0){
         mon =  float_to_int(money/10);
     //      mon = Math.round(money/10);
         sMoney =  teens_words[money -  mon * 10];
       }
       else
         if (money >= 20.0){
           mon = float_to_int(money/10);
        //   mon = Math.round(money/10);
           if ((money -  mon * 10) == 0)
              sMoney =  tens_words[mon];
           else
              sMoney =  tens_words[mon]+' '+dollars_to_words(money -  mon * 10);
         }
         else
           if (money >= 0){
           //  mon = float_to_int(money);
             mon = Math.round(money);
             sMoney =  ones_words[mon];
          }
  return (sMoney);
}

function cents_to_words(money){
  var ones_words;
  var teens_words;
  var tens_words;
  var index=0;
  var mon=0;
  var sMoney;

 ones_words = ['','One','Two','Three','Four','Five','Six','Seven','Eight',
                      'Nine','Ten'];
 teens_words = ['','Eleven','Twelve','Thirteen','Fourteen','Fifteen',
                      'Sixteen','Seventeen','Eighteen','Nineteen'];
 tens_words = ['','Ten','Twenty','Thirty','Forty','Fifty','Sixty','Seventy',
                      'Eighty','Ninety'];

if (money == 0){
   sMoney = "Zero";
 }
 if ( money > 10 &&  money < 20){
   mon =  float_to_int(money/10);
   sMoney =  teens_words[money -  mon * 10];
 }
  else
    if (money >= 20){
      mon = float_to_int(money/10);
      if ((money -  mon * 10) == 0)
        sMoney =  tens_words[mon];
      else
        sMoney =  tens_words[mon]+' '+cents_to_words(money -  mon * 10);
      }
      else
       if (money >= 0){
         mon = float_to_int(money);
         sMoney =  ones_words[mon];
       }
  return (sMoney);

}


function money_to_words(form){
	
 var
   dollars = 0;
   cents = 0;
 var amount = trim(form.amount.value.split(',').join(''));
 var _Currency = document.getElementById("CurrType").value;

 dollars = float_to_int(amount);
 cents =  Math.round((amount - dollars) * 100.00);
 
 //if (float_to_int(amount) > float_to_int(form.available_balance.value))
   //alert("Warning!: Amount entered is greater than available balance");

	if (cents == ' ' && dollars > 0) {
		if (trim(_Currency) == 'EUR') {
			form.amount_in_words.value = dollars_to_words(amount)+' Euro(s)';
		} else {
			form.amount_in_words.value = dollars_to_words(amount)+' Dollar(s)';
		}
	} else {
		if (dollars > 0) {
			if (trim(_Currency) == 'EUR') {
				form.amount_in_words.value = dollars_to_words(dollars)+' Euro(s) and '+cents_to_words(cents)+' Cents.';
			} else {
				form.amount_in_words.value = dollars_to_words(dollars)+' Dollar(s) and '+cents_to_words(cents)+' Cents.';
			}
		} else {
			if (trim(_Currency) == 'EUR') {
				form.amount_in_words.value = cents_to_words(cents)+' Cent(s).';
			} else {
				form.amount_in_words.value = cents_to_words(cents)+' Cent(s).';
			}
		}
	}
 return;
}

function money_to_words2(amount, _Currency){

/**
 *  Nov 18, 2010 - Wendell Lawrence
 *  Modified to accept the currency and the amount and return a string value
 */

var   dollars = 0;
var   cents = 0;

    if (!amount) {
        return "";
    }
// var amount = trim(form.amount.value.split(',').join(''));
// var _Currency = document.getElementById("CurrType").value;


 dollars = float_to_int(amount);
 cents =  Math.round((amount - dollars) * 100.00);

 //if (float_to_int(amount) > float_to_int(form.available_balance.value))
   //alert("Warning!: Amount entered is greater than available balance");

	if (cents == ' ' && dollars > 0) {
		if (trim(_Currency) == 'EUR') {
			return  dollars_to_words(amount)+' Euro(s)';
		} else {
			return  dollars_to_words(amount)+' Dollar(s)';
		}
	} else {
		if (dollars > 0) {
			if (trim(_Currency) == 'EUR') {
				return  dollars_to_words(dollars)+' Euro(s) and '+cents_to_words(cents)+' Cents.';
			} else {
				return dollars_to_words(dollars)+' Dollar(s) and '+cents_to_words(cents)+' Cents.';
			}
		} else {
			if (trim(_Currency) == 'EUR') {
				return cents_to_words(cents)+' Cent(s).';
			} else {
				return cents_to_words(cents)+' Cent(s).';
			}
		}
	}
 return null;
}

