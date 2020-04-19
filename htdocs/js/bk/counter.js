var counter = (function() {
    var max_len = 1000;
    var count = 0;

    return {
        increment: function() {
            count += 1;
        },
        decrement: function() {
            count -= 1;
        }
    };
}());

document.getElementById('context').addEventListener('keyup', function() {
    document.getElementById('counter_context').innerHTML = 1000 - this.value.length;
}, false);
