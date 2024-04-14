
import Split from 'split.js'
import hljs from 'highlight.js';
window.hljs = hljs;
window.toolboxSplitter = null;

window.stageSize = 75;
window.toolboxSize = 25;
window.splitterHasBeenDragged = false;

window.init = function(){
    if(localStorage.getItem('stageSize')){
        stageSize = localStorage.getItem('stageSize');
        document.getElementById('stage').style.height = stageSize + 'px';
    }

    if(localStorage.getItem('toolboxSize')){
        toolboxSize = localStorage.getItem('toolboxSize');
        document.getElementById('stage').style.height = toolboxSize + 'px';
    }

    highlightCode();
    addSplitter();
}

window.addSplitter = function(){
    Split(['#stage', '#toolbox'], {
        direction: 'vertical',
        sizes: [parseInt(stageSize), parseInt(toolboxSize)],
        minSize: 150,
        gutterSize: 10,
        onDrag(event){
            if(event[0] && event[1]){
                stageSize = event[0];
                toolboxSize = event[1];
                splitterHasBeenDragged = true;
                localStorage.setItem('stageSize', stageSize);
                localStorage.setItem('toolboxSize', toolboxSize);
            }
        },
        gutter(event){
            return document.getElementById('gutter');
        }
    });

}

window.highlightCode = function(){
    hljs.highlightAll();
}


const pageLoadEvents = ['livewire:navigated', 'DOMContentLoaded'];

pageLoadEvents.forEach(pageLoadEvents => {
    document.addEventListener(pageLoadEvents, () => {
        init();
    });
});
