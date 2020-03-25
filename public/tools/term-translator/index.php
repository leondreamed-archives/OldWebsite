<h1>Term Translator</h1>
<div class="text-content">
<form action="process.php" method="post">
Words To Translate: <textarea placeholder="Enter search terms here!" name="wordsToTranslate" accept-charset="UTF-8"></textarea><br />
Word Separator: <input type="text" name="sep" placeholder="Newline By Default" /><br />
Print Separator: <input type="text" name="printsep" placeholder="' | ' By Default" /><br />
<input type="radio" name="toOrFrom" value="from" checked />From English
<input type="radio" name="toOrFrom" value="to" />To English<br />

Language To/From English:
<select name="language">
    <option value="french" default="default">French</option>
    <option value="german">German</option>
    <option value="spanish">Spanish</option>
    <option value="portuguese">Portuguese</option>
</select><br />

<input type="checkbox" name="group" value="group" />Group Together<br />
<input type="checkbox" name="phrases" value="phrases" />Show Phrases<br />
<input type="checkbox" name="examples" value="examples" />Show Examples<br />
<input type="checkbox" name="recurse" value="recurse" />Recursive Translation<br />
<input type="checkbox" name="showUseOnBothSides" value="showUseOnBothSides" />Show Use on Both Sides<br />
<input type="checkbox" name="showPOSOnBothSides" value="showPOSOnBothSides" />Show Part of Speech on Both Sides<br />
<input type="checkbox" name="logObj" value="logObj" />Log Translation Object in Console<br />
<input type="checkbox" name="showLanguageLabel" value="showLanguageLabel" />Show Language Label<br />
<input type="submit" />
</form>

<p style="font-size: 30px"><strong>Note:</strong> These translations come from Collins Dictionary, and if you find inconsistencies between this program and this dictionary, please inform me at <a href="mailto:leonzalion@gmail.com">leonzalion@gmail.com</a></p>
</div>
