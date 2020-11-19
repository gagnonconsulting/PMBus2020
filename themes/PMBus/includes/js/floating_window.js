/*
// these 2 boxes should not float since they extend past the bottom of the screen
jQuery(document).ready(function () {
    jQuery('#companyListBox').offset(function(n, c){
        newPos = new Object();
        newPos.top = c.top;
        return newPos;
    });
});

jQuery(document).ready(function () {
    jQuery('#categoryListBox').offset(function(n, c){
        newPos = new Object();
        newPos.top = c.top;
        return newPos;
    });
});
*/

jQuery(document).ready(function () {
    jQuery('#pmbus-tools-member-list').offset(function(n, c){
        newPos = new Object();
        newPos.top = c.top;
        return newPos;
    });
});
