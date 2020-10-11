let timerId;

function lock() {
    let prev = parseInt($('#flagright').css('top'));
    if(prev < -31) {
        $('#flagright').css('top', (prev + 1) + 'px');
    }

    prev = parseInt($('#flagleft').css('top'));
    if(prev < 12) {
        $('#flagleft').css('top', (prev - 1) + 'px');
    }

    prev = parseInt($('#flagleft').css('left'));

    $('#flagleft').css('left', (prev + rando(-10, 10) + 'px'));

    clearTimeout(timerId);
    prev = rando(10, 120);
    timerId = setInterval(lock, prev);
}

function rot() {
    let rotate = rando(-6, 10);//'.crysa-class').css('transform');
    $('.crysa-class').css('transform', 'rotate(' + rotate + 'deg)');
}

$(function() {
    $.protip();
    $('#flagright').css('top', '-100px');
    timerId = setInterval(lock, 20);
    setInterval(rot, 600);
});
