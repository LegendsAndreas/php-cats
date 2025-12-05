const SegmentPattern = {
    COMMENT: 'CC',
    HTML   : 'BB',
}

document.addEventListener('DOMContentLoaded', () => {
    colorSegment(SegmentPattern.COMMENT, 'comment');
    colorSegment(SegmentPattern.HTML, 'html-content');
});

function colorSegment(pattern, className) {
    const description = document.querySelector('.js-color-segments');
    if (!description) {
        console.log('js-color-segments element not found.');
        return;
    }

    let flags;
    if (pattern === SegmentPattern.COMMENT) {
        flags = 'g';
    } else {
        flags = 'gs';
    }

    description.innerHTML = description.innerHTML.replace(new RegExp(pattern + '(.*)' + pattern, flags), (match, matchContent) => {
        return `<span class="${className}">${matchContent}</span>`;
    });
}

function breakWhiteSpaces(button) {
    button.classList.toggle('active');

    const preElements = document.querySelectorAll('.js-break-white-spaces');
    preElements.forEach(pre => {
        pre.style.whiteSpace = button.classList.contains('active') ? 'break-spaces' : '';
    });
}
