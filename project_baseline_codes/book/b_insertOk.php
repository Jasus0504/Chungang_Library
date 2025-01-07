<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include '../dbconn.php';

$b_name = $_POST['b_name'];
$b_author = $_POST['b_author'];
$b_genre = $_POST['b_genre'];
$b_location = $_POST['b_location'];

if (isset($_FILES['b_image']) && $_FILES['b_image']['error'] === UPLOAD_ERR_OK) {
    $allowed = ['jpg', 'jpeg', 'png'];
    $fileInfo = pathinfo($_FILES['b_image']['name']);
    $ext = strtolower($fileInfo['extension']);

    if (in_array($ext, $allowed)) {
        $newFilename = uniqid("book_", true) . '.' . $ext;
        $destination = '/Applications/XAMPP/xamppfiles/htdocs/project_baseline_codes/Images/' . $newFilename;
        $destination2 = '/project_baseline_codes/Images/' . $newFilename;

        if (move_uploaded_file($_FILES['b_image']['tmp_name'], $destination)) {
            $img = ($ext === "jpg" || $ext === "jpeg") ? imagecreatefromjpeg($destination) : imagecreatefrompng($destination);
            $width = imagesx($img);
            $height = imagesy($img);
            $newWidth = 500;
            $newHeight = floor($height * ($newWidth / $width));
            $tmpImg = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($tmpImg, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagejpeg($tmpImg, $destination, 90);

            imagedestroy($img);
            imagedestroy($tmpImg);

            $sql = "INSERT INTO book_list (b_name, b_author, b_genre, b_location, b_image, r_date) VALUES (?, ?, ?, ?, ?, NULL)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("sssss", $b_name, $b_author, $b_genre, $b_location, $destination);
            $stmt->execute();
            $last_id = $con->insert_id;
            $stmt->close();

            // 가져온 ID를 사용하여 b_image를 업데이트
            if ($last_id) {
            $update_sql = "UPDATE book_list SET b_image = ? WHERE b_num = ?";
            $update_stmt = $con->prepare($update_sql);
            $update_stmt->bind_param("si", $destination2, $last_id);
            $update_stmt->execute();
            $update_stmt->close();
            }
          

            echo "<script>location.href='../main.php';</script>";
        } else {
            echo "Error: Failed to save the file.";
        }
    } else {
        echo "Error: Invalid file type.";
    }
} else {
    echo "Error: No file uploaded. Error Code: " . $_FILES['b_image']['error'];
}

mysqli_close($con);
?>
