<?php

function getMessages() {
    $file = 'messages.json';
    if (!file_exists($file)) {
        touch($file);
    }

    //Open the File Stream
    $handle = fopen($file, 'r+');

    //Lock File, error if unable to lock
    if(flock($handle, LOCK_EX)) {
        $size = filesize($file);
        $content = $size === 0 ? 0 : fread($handle, $size); //Get Current Hit Count

        $messages = json_decode($content, true);
        $updated_content = json_encode($messages);
        print_r($messages);

        ftruncate($handle, 0); //Truncate the file to 0
        rewind($handle); //Set write pointer to beginning of file
        fwrite($handle, $updated_content); //Write the updated file content

        flock($handle, LOCK_UN); //Unlock File
    } else {
        echo "Could not Lock File!";
    }

    //Close Stream
    fclose($handle);
}


