
var submitted=false;
var lastname='';
var firstname='';
var email='';
var pay='';

var cssClassAttr =  document.all?'className':'class' ;

String.prototype.trim = function() { return this.replace(/^\s+|\s+$/g, ""); };

function checkRadioField(entry,group,num) {
    checkRadio = false ;
    var i=1;
    for (i=1;i<=num;i++) {
        var id = group+'_'+i ;
        //alert('Check radio '+id);
      
        var radioObj = document.getElementById(id) ;
	var radioLength = radioObj.length;
	if (radioLength == undefined) {
            if (radioObj.checked) {
                checkRadio = true ;
	        //alert('Radio value '+id+' = *'+radioObj.value+'*');
            }
        }
	for (var j = 0; j < radioLength; j++) {
	    if (radioObj[j].checked) {
                checkRadio = true ;
	        //alert('Radio value '+id+' value '+j+'= *'+radioObj[j].value+'*');
	    }
	}
    }
    if ( checkRadio ) {
        document.getElementById(entry+'_box').setAttribute(cssClassAttr,'errorbox-good');
    } else {
        document.getElementById(entry+'_box').setAttribute(cssClassAttr,'errorbox-bad');
    }
    //alert('Radio group '+group+' = *'+checkRadio+'*');
    return checkRadio ;
}

function checkEmail(id) {
    var textField = document.getElementById(id);

    text = textField.value.trim();
    checkText = checkTextField(id);
    if ( !checkText ) {
        document.getElementById(id+'_box').setAttribute(cssClassAttr,'errorbox-bad');
        return false ;
    }

    var emailRex = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+)\.+([a-zA-Z0-9]{2,4})+$/;
    //alert('Email entry '+id+' = *'+emailRex.test(text)+'*');
    if (!emailRex.test(text)) {
        document.getElementById(id+'_box').setAttribute(cssClassAttr,'errorbox-bad');
        return false ;
    }
    document.getElementById(id+'_box').setAttribute(cssClassAttr,'errorbox-good');
    return true ;
}

function checkTextField(id) {
    var textField = document.getElementById(id);
    var text = textField.value.trim() ;
    //alert('Text entry '+id+' = *'+text+'*');
    if ( text.length == 0 ) {
        document.getElementById(id+'_box').setAttribute(cssClassAttr,'errorbox-bad');
        return false ;
    }
    document.getElementById(id+'_box').setAttribute(cssClassAttr,'errorbox-good');
    return true;
}

function showValues() {
    var str = '' ;
    str += 'submitted='+submitted+'\n';
    str += 'lastname='+lastname+'\n';
    str += 'firstname='+firstname+'\n';
    str += 'email='+email+'\n';
    str += 'pay='+pay+'\n';
    alert(str);
}

function gFormSubmit() {
    var formValidation = true ;	
    lastname=document.getElementById('entry_0').value;
    firstname=document.getElementById('entry_1').value;
    email=document.getElementById('entry_4').value;
    if (document.getElementById('group_7_1').checked) {
        pay='CarteBleue';
    } else if ( document.getElementById('group_7_2').checked ) {
        pay='Cheque';
    } else if ( document.getElementById('group_7_3').checked ) {
        pay='Attente';
    }
    formValidation = checkTextField('entry_0') && formValidation ;
    formValidation = checkTextField('entry_1') && formValidation ;
    formValidation = checkTextField('entry_2') && formValidation ;
    formValidation = checkTextField('entry_3') && formValidation ;
    formValidation = checkEmail('entry_4') && formValidation ;
    formValidation = checkRadioField('entry_5','group_5',5) && formValidation;
    formValidation = checkTextField('entry_6') && formValidation ;
    formValidation = checkRadioField('entry_7','group_7',3) && formValidation;
    //showValues()
    if ( formValidation ) {
        submitted=true;
        var oForm = document.forms['ss-form'];
        oForm.submit();
    }
}

function gFormConfirmURL() {
    var url = ''
    if ( pay=='CarteBleue' ) {
        url = 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=WLATMQ7R2PZNJ'
    } else if ( pay=='Cheque' ) {
        url = 'http://agile-grenoble.org/2010/inscription_cheque';
    } else {
        url = 'http://agile-grenoble.org/2010/inscription_liste_attente';
    }
    //alert('GoTo='+url);
    return url;
}
