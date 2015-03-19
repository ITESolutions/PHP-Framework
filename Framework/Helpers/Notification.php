<?php

namespace Framework\Cura\helpers;

class Notification
{
    private 
            $_id,
            $_class = "notification",
            $_msg,
            $_top;
    
    private static
            $_notifications = array();

    public function __construct($msg) {
        $this->_msg = $msg;
        $this->_top = (count(self::$_notifications) * 50) + 20;
        $this->_id = 'notif' . count(self::$_notifications);
        self::$_notifications[] = $this;
    }
    
    public function __toString() {
        ?>
<script type="text/javascript">
var msg = document.createElement('div');
msg.setAttribute('id', "<?php echo $this->_id; ?>");
msg.style.position = 'absolute';
msg.style.right = '20px';
msg.style.top = '-<?php echo $this->_top; ?>px';
msg.style.opacity = 1;
msg.style.zIndex = 100;

msg.innerHTML = '<?php echo addslashes($this->_msg); ?>';
msg.className = '<?php echo $this->_class; ?>';

var div = document.getElementById('test');
div.appendChild(msg);

$('#<?php echo $this->_id?>').animate({
        top: '<?php echo $this->_top;?>px'
    }, 500, function() {
        $('#<?php echo $this->_id; ?>').animate({
            opacity: 0
        }, 3000);
    });
</script>

<?php
return '';
    }

    public static function render() {
        foreach (self::$_notifications as $notification) {
            echo $notification;
        }
    }
}