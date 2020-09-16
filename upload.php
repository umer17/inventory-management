<?php
// Check if the form was submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if file was uploaded without errors
    if(isset($_FILES["excel"]) && $_FILES["excel"]["error"] == 0){
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $allowedExts = array("xlsx","xls","xlt","xla");
        $mimes=array("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet","	
        application/vnd.ms-excel","application/vnd.ms-excel","application/vnd.ms-excel");
        $filename = $_FILES["excel"]["name"];
        $filetype = $_FILES["excel"]["type"];
        $filesize = $_FILES["excel"]["size"];
    
        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!in_array($ext, $allowedExts)) die("Error: Please select a valid file format.");
    
        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
    
        // Verify MYME type of the file
        if(in_array($filetype, $mimes)){
            // Check whether file exists before uploading it
           
                move_uploaded_file($_FILES["excel"]["tmp_name"], "upload/" . "inventory.".$ext);
                echo "Your file was uploaded successfully.";
            
        } else{
            echo "Error: There was a problem uploading your file. Please try again."; 
        }
    } else{
        echo "Error: " . $_FILES["excel"]["error"];
    }
}
?>