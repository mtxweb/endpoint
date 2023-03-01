<?php
if(isset($_POST['type']))
{
    switch($_POST['type'])
    {
        case 'make':
        $url = $_POST['url'];
        $id = $_POST['id'];
        $r = exec("yt-dlp -f 'ba' --add-metadata --embed-thumbnail -x --audio-format mp3 $url -o '/var/www/html/endpoint/mp3/download/$id.mp3'");
        echo 1; 
        break;

        case 'delete':
        if(file_exists('download/' . $_POST['id']))
        {
            unlink('download/' . $_POST['id']);
        }
        break;
    }
}

?>