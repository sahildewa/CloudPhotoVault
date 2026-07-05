<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

include("config/database.php");

$s3 = new S3Client([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);

$message = "";

if (isset($_POST['upload']))
{
    $fileName = $_FILES['image']['name'];
    $tempName = $_FILES['image']['tmp_name'];
    $fileSize = $_FILES['image']['size'];

    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowed = ["jpg", "jpeg", "png"];

    // Check file type
    if (!in_array($fileExtension, $allowed))
    {
        $message = "❌ Only JPG, JPEG and PNG files are allowed.";
    }
    // Check file size (5 MB)
    elseif ($fileSize > 5 * 1024 * 1024)
    {
        $message = "❌ Maximum upload size is 5 MB.";
    }
    else
    {
        // Generate unique filename
        $newFileName = uniqid("img_", true) . "." . $fileExtension;

        try
        {
            // Upload image to Amazon S3
            $s3->putObject([
                'Bucket' => 'sahil-cloudphotovault',
                'Key' => $newFileName,
                'SourceFile' => $tempName,
                'ContentType' => mime_content_type($tempName)
            ]);

            // Save filename in RDS
            $sql = "INSERT INTO images (filename, original_name)
                    VALUES ('$newFileName', '$fileName')";

            if (mysqli_query($conn, $sql))
            {
                $message = "✅ Image uploaded successfully to Amazon S3!";
            }
            else
            {
                $message = "❌ Database Error: " . mysqli_error($conn);
            }
        }
        catch (AwsException $e)
        {
            $message = "❌ S3 Upload Failed: " . $e->getAwsErrorMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>Upload Image</title>

<link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="container">

<h1>Upload Image</h1>

<?php

if($message != "")
{
    echo "<p>$message</p>";
}

?>

<form method="POST" enctype="multipart/form-data">

<input type="file" name="image" required>

<br><br>

<button class="btn" name="upload">

Upload

</button>

</form>

<br>

<a href="dashboard.php" class="btn">

Back

</a>

</div>

</body>

</html>