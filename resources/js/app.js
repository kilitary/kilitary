function lock() {
    let prev = parseInt($('#flagright').css('top'));
    if(prev < -2) {
        $('#flagright').css('top', (prev + 1) + 'px');
    }

    prev = parseInt($('#flagleft').css('top'));
    if(prev < 12) {
        $('#flagleft').css('top', (prev - 1) + 'px');
    }
}

$(function() {
    $('#flagright').css('top', '-100px');
    setInterval(lock, 10);
});
