let timerId;

function lock() {
    let prev = parseInt($('#flagright').css('top'));
    if(prev < -31) {
        $('#flagright').css('top', (prev + 1) + 'px');
    }

    prev = parseInt($('#flagleft').css('top'));
    if(prev < 12 && rando(true, false)) {
        $('#flagleft').css('top', (prev - 1) + 'px');
    }

    prev = parseInt($('#flagleft').css('left'));

    $('#flagleft').css('left', (prev + rando(-10, 10) + 'px'));

    $('#flagleft').css('left', (prev + rando(-10, 10) + 'px'));
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
