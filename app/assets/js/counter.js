"use strict";

var elem_context = document.getElementById('js-context');

elem_context.addEventListener('keyup', function() {
    countStrLen(this);
}, false);

window.addEventListener('load', function() {
    countStrLen(elem_context);
}, false);

function countStrLen(target){
  document.getElementById('js-counter_context').innerHTML = 1000 - target.value.length;
}