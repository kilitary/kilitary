require('./bootstrap');

function lock() {
    console.log('locked ' + new Date());
    $('#app > div:nth-child(2n)').css('display', 'none').text('sdsfg sex');
}

$(function() {
    setInterval(lock, 1000);
});
