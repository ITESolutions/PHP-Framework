
<style type="text/css">
body {
    background: black;
    color: #FFFFFF;
}

#c {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    width: 100%;
    height: 100%;
}

#v {
    display: none;
}

#overlay {
    position: absolute;
    top: 0px;
    left: 0px;
    height: 100%;
    width: 100%;
    z-index: 10;
}

form#login {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 300px;
    height: 180px;
    margin-left: -225px;
    margin-top: -150px;
    background-color: rgba(33,33,33,.6);
    padding: 30px;
    border: 1px solid #FFFFFF;
    box-shadow: 5px 5px #333;
}

form#login label, form#login input {
    vertical-align: middle;
    font-size: 12pt !important;
    padding: 10px !important;
    margin: 10px !important;
}

.field label, .field input {
}

.field input {
    background-color: #FFFFFF;
    box-shadow: inset 2px 2px 4px #333;
    border-radius: 1em;
    padding: 3px 0px 3px 6px;;
}
input {
    
}

</style>

<canvas id=c></canvas>
<video id=v autoplay="true" loop="true">
    <source src="/video/bg1.webm" type="video/webm" >
    <source src="/video/bg1.mp4" type="video/mp4" >
</video>

<form id="login" method="post">
    <div class="field">
        <label for="username">Username: </label>
        <input
            type="text"
            id="username"
            name="username"
            autocomplete="off"
            placeholder="Who are you?"/>
    </div>
    <div class="field">
        <label for="password">Password: </label>
        <input
            type="password"
            id="password"
            name="password"
            autocomplete="off"
            placeholder="Secret"
            onkeyup="if (event.keyCode == 13) { this.form.submit(); return false; }"/>
    </div>
    <span class='field'><a href='/register'>Register</a></span>
    <input type="hidden" name="token" value="<?php echo Framework\Cura\helpers\Token::generate(); ?>" />
</form>    

<script>
document.addEventListener('DOMContentLoaded', function(){
    var v = document.getElementById('v');
    var canvas = document.getElementById('c');
    //var canvas = document.createElement('canvas');
    var context = canvas.getContext('2d');

    //var cw = Math.floor(canvas.clientWidth / 50);
    //var ch = Math.floor(canvas.clientHeight / 50);
    
    var cw = canvas.clientWidth;
    var ch = canvas.clientHeight;
    canvas.width = cw;
    canvas.height = ch;

    v.addEventListener('play', function(){
        draw(this,context,cw,ch);
    },false);

},false);

function draw(v,c,w,h) {
    if(v.paused || v.ended) return false;
    c.drawImage(v,0,0,w,h);
    setTimeout(draw,20,v,c,w,h);
}


</script>