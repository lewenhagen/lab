<form>
    
<p>
    <label>Course:</br>
    <select name="course">
        <option value="htmlphp" <?= isSelected("htmlphp", $course) ?>>htmlphp</option>
        <option value="javascript1" <?= isSelected("javascript1", $course) ?>>javascript1</option>
        <option value="linux" <?= isSelected("linux", $course) ?>>linux</option>
        <option value="oophp" <?= isSelected("oophp", $course) ?>>oophp</option>
        <option value="oopython" <?= isSelected("oopython", $course) ?>>oopython</option>
        <option value="python" <?= isSelected("python", $course) ?>>python</option>
        <option value="webgl" <?= isSelected("webgl", $course) ?>>webgl</option>
        <option value="dbjs" <?= isSelected("dbjs", $course) ?>>dbjs</option>
    </select></label>
</p>

<p>
    <label>Lab:</br>
    <select name="lab">
        <option value="lab1" <?= isSelected("lab1", $lab) ?>>Lab 1</option>
        <option value="lab2" <?= isSelected("lab2", $lab) ?>>Lab 2</option>
        <option value="lab3" <?= isSelected("lab3", $lab) ?>>Lab 3</option>
        <option value="lab4" <?= isSelected("lab4", $lab) ?>>Lab 4</option>
        <option value="lab5" <?= isSelected("lab5", $lab) ?>>Lab 5</option>
        <option value="lab6" <?= isSelected("lab6", $lab) ?>>Lab 6</option>
        <option value="sql1" <?= isSelected("sql1", $lab) ?>>SQL 1</option>
        <option value="sql2" <?= isSelected("sql2", $lab) ?>>SQL 2</option>
        <option value="bash1" <?= isSelected("bash1", $lab) ?>>Bash 1</option>
        <option value="bash2" <?= isSelected("bash2", $lab) ?>>Bash 2</option>
        <option value="javascript1" <?= isSelected("javascript1", $lab) ?>>JavaScript 1</option>
        <option value="node1" <?= isSelected("node1", $lab) ?>>Node 1</option>
        <option value="node2" <?= isSelected("node2", $lab) ?>>Node 2</option>
        <option value="node3" <?= isSelected("node3", $lab) ?>>Node 3</option>
        <option value="labtest" <?= isSelected("labtest", $lab) ?>>Lab Test</option>
    </select></label>
</p>

<p>
    <label>Acronym:<br>
        <input type="text" name="acronym" placeholder="Enter acronym" value="<?= $acronym ?>">
    </label>
</p>

<p>
    <input type="submit" name="doGenerate" value="Submit">
</p>

</form>
