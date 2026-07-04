<?php

include("config/database.php");

$result = mysqli_query($conn, "SELECT * FROM images ORDER BY uploaded_at DESC");

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>Gallery</title>

<link rel="stylesheet" href="css/style.css">

<style>

.gallery{
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 20px;
}
.card img{
    width: 180px;
    height: 180px;
    object-fit: cover;
    border-radius: 10px;
    display: block;
    margin: 0 auto;
}

</style>

</head>

<body>

<div class="container">

<h1>Gallery</h1>

<div class="gallery">

<?php

while($row = mysqli_fetch_assoc($result))
{

?>

<div class="card">

<img src="https://sahil-cloudphotovault.s3.us-east-1.amazonaws.com/<?php echo $row['filename']; ?>" alt="<?php echo $row['original_name']; ?>">

<p><?php echo $row['original_name']; ?></p>

</div>

<?php

}

?>

</div>

<br>

<a href="dashboard.php" class="btn">Back to Dashboard</a>

</div>

</body>

</html>