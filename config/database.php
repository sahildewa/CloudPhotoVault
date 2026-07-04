<?php

$conn = mysqli_connect(
    "couldvault-db.cexucy2800ca.us-east-1.rds.amazonaws.com",
    "sahil",
    "sahil9870",
    "coulddatabase"
);

if (!$conn)
{
    die("Connection failed: " . mysqli_connect_error());
}

?>