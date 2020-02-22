/**
 * Moneyline scripts
 * 
 */



Raxan.ready(function(){
    
    // Flashbar Show/Close events
    $('#flashbar').bind('showmsg',function(){
        $(this).expose({    // excpose flash bar
            color:  '#420000',
            loadSpeed: 'fast',
            closeOnEsc:  false,
            closeOnClick: false
        });
    });
    $('#flashbar').bind('closemsg',function(){
        $.mask.close(); // remove mask
    });

    // Session timeout
    $('#timeoutmsg .ok').click(function(){
        if (logoutTimer) clearTimeout(logoutTimer); // clear auto logout timer
        $('#timeoutmsg .ok img').show();
        $(this).blur();
        toggleTitle(false);
        $.ajax({
            url:'refresh.php',
            complete: function(data) {
                setTimeout(sessionTimeout, Raxan.getVar('timeoutMinutes') * 60000);
                if (data.responseText=='OK') {
                    $('#timeoutmsg').animate({
                        top:'-500px'
                    }).expose({api:true}).close();
                    $('body').css('overflow','auto');
                }
                else {
                    window.location='error.php?vu=NOACCESS';
                }
            }
        });
    })
    if (Raxan.getVar('timeoutMinutes'))
        setTimeout(sessionTimeout, Raxan.getVar('timeoutMinutes') * 60000);
    
});


/**
 * Numeric functions
 * ----------------------
 */



/**
 * Check if value is empty
 * @return boolean
 */
function isEmpty(v) {
    return ((v == null) || (v.length == 0));
}

/**
 * Check if value is numeric
 * @return boolean
 */
function isNumeric(v) {
    var str = (v + '').replace(/[0123456789.]+/,'');

    if (trim(v) == "") return false;
    if(str=='') return false;

    v = (isEmpty(v)) ?  '0' :  v;
    v = parseInt((v+'').replace(/\,/,''));

    return isNaN(v) || v <= 0 ? false : true;
}

/**
 * Output money format
 */
function outputMoney(number) {
    return outputDollars(Math.floor(number-0) + '') + outputCents(number - 0);
}

// Output formated dollars
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
// Output formated cents
function outputCents(amount) {
    amount = Math.round( ( (amount) - Math.floor(amount) ) *100);
    return (amount < 10 ? '.0' + amount : '.' + amount);
}

/**
 * Remove trailing and leadin whitespaces and carriage return characters
 * @return string
 */
function trim(v) {
    var str = v + '';
    return str.replace(/^([\n\r\s])+|([\n\r\s])+$/g,'')
}

/**
 * Return a numeric value
 * @return float
 */
function val(v) {
    v = (isEmpty(v)) ?  '0' :  v;
    v = parseFloat((v+'').replace(/\,/,''));
    return isNaN(v) ? 0 : v;
}

/**
 * Validate amount
 * @return boolean
 */
function validatAmount(value,balance) {

    if(trim(value) == '' || isNaN(value)){
        alert('Please enter a valid amount');
        return false
    } 
    else if (parseFloat(trim(value), 10) <= 0) {
        alert('Please enter an amount greater than zero');
        return false
    }
    else if (parseFloat(trim(value), 10) > parseFloat(trim(balance)))	{
        alert('Amount entered is more than available balance which is: [' +FormatVal(balance,2)+ ']' );
        return false
    }
    else {
        return true;
    }

}



/**
 * Limit text box
 * ---------------------------------------------
 */
function limitTextbox(elm,limit) {
    elm = $(elm);
    if (elm.length) {
        elm.attr('maxlength',limit);
        if (elm[0].tagName.toLowerCase()=='textarea') {
            elm.keypress(function(){
                if (this.value.length > limit) {
                    this.value = this.value.substr(0,limit);
                }
            });
        }
    }

}

/**
 * Get datetime
 */
function getDateTime() {
    var hr = Raxan.getVar('srvHour');
    var min = Raxan.getVar('srvMinute');
    var sec = Raxan.getVar('srvSecond');
    if (!this.loaded) {
        var dt = new Date(Raxan.getVar('srvDatetimeStr'));
        dt.setHours(hr);
        dt.setMinutes(min);
        dt.setSeconds(sec);

        this.dt = dt;
        setInterval(function(){
            var s = dt.getSeconds() + 2;
            dt.setSeconds(s);
        }, 2000);
        this.loaded = true;
    }
    return this.dt;
}

/**
 * Toggle document title
 */
function toggleTitle(state) {
    if (state===false && this.title)  {
        clearTimeout(this.timer);
        document.title = this.title;
    }
    else if (state===true){
        var toggle = true,title = document.title;
        this.title = title;
        this.timer =  setInterval(function(){
            if (toggle) document.title = '..........';
            else document.title = title;
            toggle = !toggle;
        }, 1000);
    }
}

/**
 * Session Timeout Warning
 * -----------------------------------
 */
var logoutTimer = 0;
function sessionTimeout() {
    $('body').css('overflow','hidden');
    $('#timeoutmsg .ok img').hide();
    $('#timeoutmsg').animate({
        top:'0'
    }).expose({
        api:true,
        closeOnEsc:false,
        closeOnClick:false,
        color:'#222',
        loadSpeed:'fast'
    }).load();
    toggleTitle(true);

    // auto logout after 2 minutes
    logoutTimer = setTimeout(function(){
        window.location = 'logout.php'; 
    },2 * 60000);
}

