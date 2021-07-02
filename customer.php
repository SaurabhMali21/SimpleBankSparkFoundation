<?php
include 'config.php';

    if(isset($_POST['submit']))
    {
        $from = $_GET['Account'];
        $to = $_POST['to'];
        $amount = $_POST['amount'];

        $sql = "SELECT * from users where Account=$from";
        $query = mysqli_query($conn,$sql);
        $sql1 = mysqli_fetch_array($query); 

        $sql = "SELECT * from users where Account=$to";
        $query = mysqli_query($conn,$sql);
        $sql2 = mysqli_fetch_array($query);



        
        if (($amount)<0)
    {
            echo '<script type="text/javascript">';
            echo ' alert("Oops! Negative values cannot be transferred")';
            echo '</script>';
        }


    
        
        else if($amount > $sql1['Balance']) 
        {
            
            echo '<script type="text/javascript">';
            echo ' alert("Bad Luck! Insufficient Balance")'; 
            echo '</script>';
        }
        


    
        else if($amount == 0){

            echo "<script type='text/javascript'>";
            echo "alert('Oops! Zero value cannot be transferred')";
            echo "</script>";
        }


        else {
            
                    
                    $newbalance = $sql1['Balance'] - $amount;
                    $sql = "UPDATE users set Balance=$newbalance where Account=$from";
                    mysqli_query($conn,$sql);
                

                    
                    $newbalance = $sql2['Balance'] + $amount;
                    $sql = "UPDATE users set Balance=$newbalance where Account=$to";
                    mysqli_query($conn,$sql);
                    
                    $Sender = $sql1['Name'];
                    $Receiver = $sql2['Name'];
                    $sql = "INSERT INTO transaction(`Sender`, `Receiver`, `Balance`) VALUES ('$Sender','$Receiver','$amount')";
                    $query=mysqli_query($conn,$sql);

                    if($query){
                        echo "<script> alert('Transaction Successful');
                                        window.location='transfer.php';
                            </script>";
                        
                    }

                    $newbalance= 0;
                    $amount =0;
            }
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="table.css">

    <style type="text/css">
    	
		button{
			border:none !important;
			background: #d9d9d9 !important;
		}
	    button:hover{
			background-color:#777E8B !important;
			transform: scale(1.1) !important;
			color:white !important;
		}

    </style>
</head>

<body>
<div align="right">
    <a href="index.php" class="btn">Home</a>
    </div>

	<div class="container">
        <h2 class="text-center pt-4">Transaction</h2>
            <?php
                include 'config.php';
                $sid=$_GET['Account'];
                $sql = "SELECT * FROM  users where Account=$sid";
                $result=mysqli_query($conn,$sql);
                if(!$result)
                {
                    echo "Error : ".$sql."<br>".mysqli_error($conn);
                }
                else{
                $rows = mysqli_fetch_assoc($result);
                }
            ?>
            <form method="post" name="tcredit" class="tabletext" ><br>
<br>
        <div>
            <table class="table table-striped table-condensed table-bordered">
                <tr>
                    <th class="text-center">Account no</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Balance</th>
                </tr>
                <tr>
                    <td class="py-2"><?php echo $rows['Account'] ?></td>
                    <td class="py-2"><?php echo $rows['Name'] ?></td>
                    <td class="py-2"><?php echo $rows['Balance'] ?></td>
                </tr>
            </table>
        </div>
        <br><br><br>
        <label>Transfer To:</label>
        <select name="to" class="form-control" required>
            <option value="" disabled selected>Choose</option>
            <?php
                include 'config.php';
                $sid=$_GET['Account'];
                $sql = "SELECT * FROM users where Account!= $sid";
                $result=mysqli_query($conn,$sql);
                if(!$result)
                {
                    echo "Error ".$sql."<br>".mysqli_error($conn);
                }
                while($rows = mysqli_fetch_assoc($result)) {
            ?>
                <option class="table" value="<?php echo $rows['Account'];?>" >
                
                    <?php echo $rows['Name'] ;?> (Balance: 
                    <?php echo $rows['Balance'] ;?> ) 
               
                </option>
            <?php 
                } 
            ?>
            <div>
        </select>
        <br>
        <br>
            <label>Amount:</label>
            <input type="number" class="form-control" name="amount" required>   
            <br><br>
                <div class="text-center" >
            <button class="btn mt-3" name="submit" type="submit" id="myBtn">Transfer</button>
            </div>
        </form>
    </div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>