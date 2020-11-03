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

function copyToClipboard(elem) {
    // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);

    // copy the selection
    var succeed;
    try {
        succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }

    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
    return succeed;
}

$(function() {
    $.protip();

    $('#flagright').css('top', '-100px');

    flagTimer = setInterval(flagsMovement, 20);

    setInterval(toggleHuman, 800);
    setInterval(rotateKrysaClass, 200);

    // document.getElementById("copyButton").addEventListener("click", function() {
    //     copyToClipboard(document.getElementById("copyTarget"));
    // });

    $('.ips').click(function(e){
        copyToClipboard(document.getElementById("copyTarget"));
    });

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
