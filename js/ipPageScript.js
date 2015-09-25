/* 
 * Licensed under DWYW licence. (Do whatever you want)
 * If you haven't obtained a copy of licence with you software, 
 *   you can find it on page about:blank.
 * Author: Tomáš Zelina <zelitomas@gmail.com> <-- sem pište výhružné maily za prasácký kód
 */


//Vytvoření fakeIP z čísla počítače
function updateFakeIPbyPCnumber(){
    var pcNumber = $("#getbypcnumber #pcnumber").val();
    var fakeIP = "sit2." + pcNumber;
    $("#getbypcnumber input[name=ip]").val(fakeIP);
}

$(document).ready(function(){
    
    // Zobrazení skrytých submit buttonů
    $(".unhidesubmitbutton").on('input', function(){
        $(this).parent("form").find("input[type=submit]").removeClass("hidden");
    });
    
    // Nabindování funkce pro vytváření fakeIP na eventy
    $("#getbypcnumber #pcnumber").on('input', updateFakeIPbyPCnumber);
    $("#getbypcnumber form").submit(updateFakeIPbyPCnumber);
    
});
