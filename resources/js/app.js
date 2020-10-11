let timerId;

function lock() {
    let prev = parseInt($('#flagright').css('top'));
    if(prev < -2) {
        $('#flagright').css('top', (prev + 1) + 'px');
    }

    prev = parseInt($('#flagleft').css('top'));
    if(prev < 12) {
        $('#flagleft').css('top', (prev - 1) + 'px');
    }

    clearTimeout(timerId);
    prev = randomNumber(10, 50);
    timerId = setInterval(lock, prev);
}

function randomNumber(min, max) {
    if(min > max) {
        let temp = max;
        max = min;
        min = max;
    }

    if(min <= 0) {
        return Math.floor(Math.random() * (max + Math.abs(min) + 1)) + min;
    } else {
        return Math.floor(Math.random() * max) + min;
    }
}

$(function() {
    $('#flagright').css('top', '-100px');
    timerId = setInterval(lock, 20);
});
