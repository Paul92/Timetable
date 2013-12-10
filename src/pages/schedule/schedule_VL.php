<?php
if (isset($data['errors'])) {
    foreach ($data['errors'] as $error) {
        echo $error, '</br>';
    }
}
?>
<form method="POST">

<table>
<tr><td>Day name</td><td>Start hour</td>

<?php
while($day = mysqli_fetch_array($data['schedule'])){
    echo '<tr>';
    echo '<td><b>'.$day['dayName'].'</b></td>';
    echo '<td><input type="text" name="'.$day['dayName'].'_startHour" value="'.$day['startHour'].'"/></td>';
    echo '</tr>';
}
?>

</table>
<label for="slotLength" name="slotLengthLabel">Slot length:</label>
<input type="text" name="slotSize" size=3 value="<?php echo $data['slotSize']; ?>"/>
<input type="submit" name="reset" value="Reset"/>
<input type="submit" name="submit" value="Submit"/>
</form>

