/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function delayAction() {
    $("body").append("<button >Action</button>");
}
$(document).ready(function () {
    setTimeout("delayAction()",10);
}) ;  