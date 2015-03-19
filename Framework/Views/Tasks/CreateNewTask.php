<?php
use Framework\Cura\helpers as helpers;
?>

<form method="post">
    <div class="field">
        <label for="task_name">Task Name</label>
        <input
            type="text"
            id="task_name"
            name="task_name"
            value="<?php echo filter_input(INPUT_POST, 'task_name'); ?>"
            />
    </div>
    <div class="field">
        <label for="due">Due Date</label>
        <input
            type="date"
            id="due"
            name="due"
            value="<?php echo filter_input(INPUT_POST, 'due'); ?>"
            />
    </div>
    <div class="field">
        <label for="description">Description</label>
        <textarea
            id="description"
            name="description"><?php echo filter_input(INPUT_POST, 'description'); ?></textarea>
    </div>
    <input type="hidden" name="token" value="<?php echo helpers\Token::generate(); ?>" />
    <input type="submit" value="Save"/>
</form>

<p id="phrase"></p>

<script>
    function makePhrases() {
        var verbs = ['suck', 'spring', 'jack', 'favor', 'swipe', 'keep', 'enjoy'];
        var nouns = ['fest', 'chicken', 'boys', 'flatus', 'beef', 'hostages', 'nuts'];
        var words1 = ["24/7", "multi-Tier", "30,000 foot", "B-to-B", "win-win"];
        var words2 = ["ass-to-mouth", "Holy Fuck", "value-added", "oriented", "focused", "aligned"];
        var words3 = ["process", "solution", "tipping-point", "strategy", "vision"];
        
        var rand1 = Math.floor(Math.random() * words1.length);
        var rand2 = Math.floor(Math.random() * words2.length);
        var rand3 = Math.floor(Math.random() * words3.length);
        var rand4 = Math.floor(Math.random() * verbs.length);
        var rand5 = Math.floor(Math.random() * nouns.length);
        
        var taskName = verbs[rand4] + " " + nouns[rand5];
        var taskNameInput = document.getElementById("task_name");
        taskNameInput.value = taskName;
        console.log(taskNameInput);
        
        var phrase = words1[rand1] + " " + words2[rand2] + " " + words3[rand3];
        var phraseElement = document.getElementById("description");
        phraseElement.innerHTML = phrase;
        
    }
    
    window.onload = makePhrases;
</script>