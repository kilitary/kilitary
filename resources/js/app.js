let flagTimer;
let shitHappensOnce = false;
let humanWorks = false;

function toggleHuman() {
    humanWorks = !humanWorks;
}

function flagsMovement() {
    let top = parseInt($('#flagright').css('top'));
    if(top < -31 && humanWorks) {
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

    clearTimeout(flagTimer);
    flagTimer = setInterval(flagsMovement, rando(10, 120));
}

function rotateKrysaClass() {
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

    flagTimer = setInterval(flagsMovement, 20);

    setInterval(toggleHuman, 800);
    setInterval(rotateKrysaClass, 200);

    window.onerror = (message, source, lineno, columnNumber, error) => {
        const errorInfo = {
            column: columnNumber,
            component: component,
            line: lineno,
            message: error.message,
            name: error.name,
            source_url: source,
            stack: error.stack
        };
        chrome.errorReporting.reportError(errorInfo);
        console.log('error ' + errorInfo);
    };
});
