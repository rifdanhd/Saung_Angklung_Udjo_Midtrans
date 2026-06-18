<?php

echo "SYS TEMP: " . sys_get_temp_dir() . "<br>";
echo "UPLOAD DIR INI: " . ini_get('upload_tmp_dir') . "<br>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo '<pre>';
    print_r($_FILES);
    echo '</pre>';
}
?>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="test">
    <button type="submit">Upload</button>
</form>
