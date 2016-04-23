// PAGE: process.php
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46 && charCode != 8)
     return false;
    else {
        var len = document.getElementById("txt_tax_base").value.length;
        var index = document.getElementById("txt_tax_base").value.indexOf('.');

        if (index > 0 && charCode == 46) {
            return false;
        }
        if (index > 0){
            var CharAfterdot = (len + 1) - index;
            if (CharAfterdot > 3) {
                if(charCode == 8){
                    return true;
                }
                else{
                    return false;
                }
            }
        }   
    }
    return true;
}