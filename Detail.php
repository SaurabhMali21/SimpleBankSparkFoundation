<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Detail</title>
    <link rel="stylesheet" href="b.css">
    <link rel="stylesheet" type="text/css" href="tab.css">
</head>
<body>
<div align="right">
    <a href="index.php" class="btn">Home</a>
    </div>
    
        <h1> Customers </h1>
        <div>
            <table>
                <tr>
                    <th class="text-center">Account no</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Balance</th>
                </tr>
                <?php
                    include 'config.php';
                    $sql = "SELECT Account, Name, Balance FROM users ";
                    $query = mysqli_query($conn,$sql);

                    if($query-> num_rows > 0){
                        while($row = $query-> fetch_assoc()){
                            echo "<tr><td>" . $row["Account"]. "</td><td>" . $row["Name"] . "</td><td>"
                            . $row["Balance"]. "</td></tr>";
                        }
                        echo "</table>";
                    }
                    else{
                        echo "No Result Found";
                    }
                    $conn-> close();
                ?>
            </table>
        </div>
</body>
</html>
        