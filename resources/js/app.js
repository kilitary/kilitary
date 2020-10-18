var $ = require( "jquery" );

let timerId;

function lock() {
    let top = parseInt($('#flagright').css('top'));
    if(top < -31) {
        $('#flagright').css('top', (top + 1) + 'px');
    }

    let topl = parseInt($('#flagleft').css('top'));
    if(topl < 12 && rando(true, false) && topl > -116) {
        $('#flagleft').css('top', (topl - 1) + 'px');
    }

    prev = parseInt($('#flagleft').css('left'));

    if(topl > -115) {
        $('#flagleft').css('left', (prev + rando(-10, 10) + 'px'));
    }

    clearTimeout(timerId);
    timerId = setInterval(lock, rando(10, 120));
}

function rot() {
    let rotate = rando(-6, 6);//'.crysa-class').css('transform');
    $('.crysa-class').css('transform', 'rotate(' + rotate + 'deg)');
    if(rando(true, false)) {
        prev = parseInt($('.crysa-class').css('height'));
        $('.crysa-class').css('height', prev + rando(-25, 25) + 'px');
    }
}

$(function() {
    $.protip();
    $('#flagright').css('top', '-100px');
    timerId = setInterval(lock, 20);
    setInterval(rot, 600);
});

