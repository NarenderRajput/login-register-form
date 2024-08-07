<?php

function upload_file()
{
    if (!isset($_FILES["photo"]) || ($_FILES["photo"]["error"]) > 0) {
        //$_SESSION["errors"]["photoErr"] = "file is missing";
        return false;
    } else {
        $target_dir = "../uploads/";
        $imageFileType = strtolower(pathinfo($target_dir . basename($_FILES["photo"]["name"]), PATHINFO_EXTENSION));
        $file_name = time() . '.' . $imageFileType;
        $target_file = $target_dir . $file_name;


        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check === false) {
            $_SESSION["errors"]["photoErr"] = "Something went wrong  Uploading photo";
        }

        if (file_exists($target_file)) {
            $_SESSION["errors"]["photoErr"] = "File already exist";
        }

        if ($_FILES["photo"]["size"] > 500000) {
            $_SESSION["errors"]["photoErr"] = "File size too large";
        }

        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" &&
            $imageFileType != "gif"
        ) {
            $_SESSION["errors"]["photoErr"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }

        if (!isset($_SESSION["errors"]["photoErr"])) {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                //$data = "photo =" . "'$file_name'";
                return $file_name;
            } else {
                $_SESSION["errors"]["photoErr"] = "Sorry, there was an error uploading your file.";
            }
        }
    }
    return false;
}
