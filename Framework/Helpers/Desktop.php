<?php

namespace Framework\Cura\helpers;

use Framework\Cura\helpers as helpers;

class Desktop
{
    const
        WINDOW_PADDING = 3,
        WIN_MIN_HEIGHT = 100,
        I_BORDER_WIDTH = 1,
        O_BORDER_WIDTH = 1;

    public function __construct($title = 'untitled', $body = '') {
        ?>
<style>
    html {
        position: absolute;
    }
    
    #desktop {
        height: 100%;
        width: 100%;
        margin: 0px;
        position: absolute;
        bottom: 0px;
    }
    
    .window {
        position: absolute;
        border: 1px solid #333333;
        box-shadow: 3px 3px 5px  #333333;
        border-radius: 3px;
        top: 100px;
        left: 100px;
        margin: 0px;
        padding: <?php echo self::WINDOW_PADDING; ?>px;
    }

    .title_bar {
        
        margin: 0px;
        padding: 0px;
        width: 100%;
        display: block;
        text-align: center;
    }
    
    .window_body {
        border: 1px solid #333333;
        margin: 0px;
        padding: 0px;
        width: 100%;
        height: 100%;
        min-height: <?php echo self::WIN_MIN_HEIGHT; ?>px;
    }
    
    .drag { position: relative; }
    
    
    
</style>

<div id="desktop"></div>
<div id="debug"></div>

<script>
    
    function ExtractNumber(value) {
        var n = parseInt(value);
        return n == null || isNaN(n) ? 0 : n;
    }

    // this is simply a shortcut for the eyes and fingers
    function $(id)
    {
        return document.getElementById(id);
    }
    
    var window1 = {
        x:140,
        y:300,
        h:300,
        w:500,
        title: 'test_title',
        header: (function() {
            var titleBar = document.createElement('div');
            titleBar.id = 'title_bar';
            titleBar.className = 'title_bar';
            titleBar.innerHTML = '<?php echo addslashes($title); ?>';
            return titleBar;
        }),
        body: (function() {
            var body = document.createElement('div');
            body.className = 'window_body';
            body.innerHTML = '<?php echo addslashes($body); ?>';
            return body;
        }),
        render: (function() {

            var windowDiv = document.createElement('div');
            windowDiv.id = 'window1';
            windowDiv.className = 'window';
            windowDiv.height = window1.h+'px';
            windowDiv.width = (window1.w + <?php echo self::I_BORDER_WIDTH; ?>) + 'px';
            
            windowDiv.appendChild(window1.header());
            windowDiv.appendChild(window1.body());
            
            document.getElementById('desktop').appendChild(windowDiv);
        })
    };
  
    window.onload = function() {
        window1.render();
        $('title_bar').onmousedown = mouseDown;
        window.onmouseup = mouseUp;
    }


var _startX = 0;            // mouse starting positions
var _startY = 0;
var _offsetX = 0;           // current element offset
var _offsetY = 0;
var _dragElement;           // needs to be passed from OnMouseDown to OnMouseMove
var _oldZIndex = 0;         // we temporarily increase the z-index during drag
var _debug = $('debug');    // makes life easier



function mouseUp()
{
    //window.removeEventListener('mousemove', divMove, true);
    if (_dragElement != null)
    {
        _dragElement.style.zIndex = _oldZIndex;

        // we're done with these events until the next OnMouseDown
        document.onmousemove = null;
        document.onselectstart = null;
        _dragElement.ondragstart = null;

        // this is how we know we're not dragging      
        _dragElement = null;
        
        _debug.innerHTML = 'mouse up';
    }
}

function mouseDown(e){
    
    // IE is retarded and doesn't pass the event object
    if (e == null) 
        e = window.event; 
    
    // IE uses srcElement, others use target
    var target = e.target != null ? e.target.parentNode : e.srcElement.parentNode;

    _debug.innerHTML = target.className == 'window' 
        ? 'draggable element clicked' 
        : 'NON-draggable element clicked';

    // for IE, left click == 1
    // for Firefox, left click == 0
    if ((e.button == 1 && window.event != null || 
        e.button == 0) && 
        target.className == 'window') {
        // grab the mouse position
        _startX = e.clientX;
        _startY = e.clientY;
        
        // grab the clicked element's position
        
        
        _offsetX = ExtractNumber(target.style.left);
        console.log(target.parentNode);
        _offsetY = ExtractNumber(target.style.top);
        
        // bring the clicked element to the front while it is being dragged
        _oldZIndex = target.style.zIndex;
        target.style.zIndex = 10000;
        
        // we need to access the element in OnMouseMove
        _dragElement = target;

        // tell our code to start moving the element with the mouse
        document.onmousemove = divMove;
        
        // cancel out any text selections
        document.body.focus();

        // prevent text selection in IE
        document.onselectstart = function () { return false; };
        // prevent IE from trying to drag an image
        target.ondragstart = function() { return false; };
        
        // prevent text selection (except IE)
        return false;
    }
}




function divMove(e){
    if (e == null) 
        var e = window.event;
    // this is the actual "drag code"
    _dragElement.style.left = (_offsetX + e.clientX - _startX) + 'px';
    _dragElement.style.top = (_offsetY + e.clientY - _startY) + 'px';
    
    _debug.innerHTML = '(' + _dragElement.style.left + ', ' + 
        _dragElement.style.top + ')';  
}



</script>


<?php ;
    }
}
