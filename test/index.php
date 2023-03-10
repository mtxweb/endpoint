<?php
if(isset($_POST['type']) AND $_POST['type'] == 'test')
{
    echo json_encode($_POST);
}
?>