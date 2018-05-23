<?php
    $data['file'] = $_FILES;

    move_uploaded_file(justifiactif, ./img);
    echo json_encode($data);
?>