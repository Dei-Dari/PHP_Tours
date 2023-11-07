<?php
$mysql = connect();
echo '<form action="index.php?page=6" method="post" enctype="multipart/form-data" class="inputgroup">';
echo '<select name="userid" placeholder="user to admin">';
$sel = 'SELECT * FROM users WHERE roleid=2 ORDER BY login';
$res = mysqli_query($mysql, $sel);
while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
    echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
}
mysqli_free_result($res);
echo '</select>';
echo '<input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>';
echo '<input type="file" name="file" accept="image/*">';
echo '<input type="submit" name="addadmin" value="Add" class="btn btn-sm btn-info">';
echo '</form>';
if (isset($_POST['addadmin'])) {
    $userid = $_POST['userid'];
    $fn = $_FILES['file']['tmp_name'];
    $file = fopen($fn, 'rb');
    $img = fread($file, filesize($fn));
    fclose($file);
    $img = addslashes($img);
    $ins = 'UPDATE users SET avatar="' . $img . '", roleid=1 WHERE id =' . $userid;
    mysqli_query($mysql, $ins);
}
$sel = 'SELECT * FROM users WHERE roleid=1 ORDER BY login';
$res = mysqli_query($mysql, $sel);
echo '<table class="table table-striped">';
while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
    echo '<tr>';
    echo '<td>' . $row[0] . '</td>';
    echo '<td>' . $row[1] . '</td>';
    echo '<td>' . $row[3] . '</td>';
    $img = base64_encode($row[6]);
    echo '<td><img height="100px" src="data:image/jpeg; base64,' . $img . '"/></td>';
}
mysqli_free_result($res);
echo '</table>';