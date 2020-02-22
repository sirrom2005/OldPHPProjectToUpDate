<blockquote>
Create your survey with the simple form below.
</blockquote>
<form action="?action=manage-survey" method="post" name="frm" class="formStyle">
    <p>
    	<label for="question">Enter your question</label>
        <input autocomplete="off" class="textbox" type="text" placeholder="enter your question" name="question" id="question" required />
    </p>
    <hr />
    <p>
    	<label for="answer1">Answer</label>
        <input autocomplete="off" class="textbox" type="text" placeholder="enter answer option here" name="answer1" id="answer1" required />
    </p>
    <p>
    	<label for="answer2">Answer</label>
        <input autocomplete="off" class="textbox" type="text" placeholder="enter answer option here" name="answer2" id="answer2" />
    </p>
    <p>
    	<label for="answer3">Answer</label>
        <input autocomplete="off" class="textbox" type="text" placeholder="enter answer option here" name="answer3" id="answer3" />
    </p>
    <!--p>
    	<label for="answer4">Answer</label>
        <input autocomplete="off" class="textbox" type="text" placeholder="enter answer option here" name="answer4" id="answer4" />
    </p>
    <p>
    	<label for="answer5">Answer</label>
        <input autocomplete="off" class="textbox" type="text" placeholder="enter answer option here" name="answer5" id="answer5" />
    </p-->
    <hr />
    <p>
    	<label for="answer1">A short description/purpose of this servey<small>(optional)</small></label>
        <textarea placeholder="short survey description"></textarea>
    </p>
    <input type="submit" value="<?php _t('done');?>" class="btn" /><input type="reset" value="<?php _t('reset');?>" class="btn" />
</form>
<p>&nbsp;</p>
<hr />