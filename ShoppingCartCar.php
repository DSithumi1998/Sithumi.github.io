<?php
    session_start();
	//db connection
    $con = mysqli_connect("localhost","root","","customer_website");
	
	
	//post the data to db
    if (isset($_POST["add"])){
        if (isset($_SESSION["ShoppingCartCar"])){
            $item_array_id = array_column($_SESSION["ShoppingCartCar"],"product_id");
            if (!in_array($_GET["ID"],$item_array_id)){
                $count = count($_SESSION["ShoppingCartCar"]);
                $item_array = array(
                    'product_id' => $_GET["ID"],
                    'item_name' => $_POST["hidden_name"],
                    'product_price' => $_POST["hidden_price"],
                    'item_quantity' => $_POST["quantity"],
                );
                $_SESSION["ShoppingCartCar"][$count] = $item_array;
                header('Location:ShoppingCartCar.php');
            }else{
                echo "Product is already Added to Cart";
                header('Location:ShoppingCartCar.php');
            }
        }else{
            $item_array = array(
                'product_id' => $_GET["ID"],
                'item_name' => $_POST["hidden_name"],
                'product_price' => $_POST["hidden_price"],
                'item_quantity' => $_POST["quantity"],
            );
            $_SESSION["ShoppingCartCar"][0] = $item_array;
        }
    }
	
	//delete product
    if (isset($_GET["action"])){
        if ($_GET["action"] == "delete"){
            foreach ($_SESSION["ShoppingCartCar"] as $keys => $value){
                if ($value["product_id"] == $_GET["ID"]){
                    unset($_SESSION["ShoppingCartCar"][$keys]);
                    echo "Product has been Removed...!";
                    header('Location:ShoppingCartCar.php');
                }
            }
        }
    }
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shopping Cart</title>
    
	
    <link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <style>
        @import url('https://fonts.googleapis.com/css?family=Titillium+Web');

        *{
            font-family: 'Titillium Web', sans-serif;
        }
        .products{
            border: 1px solid #eaeaec;
            margin: -1px 19px 3px -1px;
            padding: 10px;
            text-align: center;
            background-color: #efefef;
        }
        table, th, tr{
            text-align: center;
        }
        .title2{
            text-align: center;
            color: #66afe9;
            background-color: #efefef;
            padding: 2%;
        }
        h2{
            text-align: center;
            color: #66afe9;
            background-color: #efefef;
            padding: 2%;
        }
        table th{
            background-color: #efefef;
        }
		
		
a{
	text-decoration:none;
	display:inline-block;
	padding:8px 16px;
}

a:hover{
	background-color:#000;
	color:#09F;
}

.prev{
	background-color:#f1f1f1;
	color:#09F;
}


    </style>
</head>
<body>

<a href="HomePage.html"><img src="NewBack.jpg" width="30" height="30" /></a>

    <div class="container" style="width: 65%">
        <h2><b>Shopping Cart</b></h2>
        <h3>Car Decorations</h3>
        
        <?php
		
			//get the data from db
            $query = "SELECT * FROM carDecos";
            $result = mysqli_query($con,$query);
            if(mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_array($result)) {

                    ?>
                    <div class="col-md-3">

                        <form method="post" action="ShoppingCartCar.php?action=add&ID=<?php echo $row["Product ID"]; ?>">

                            <div class="products">
                                <img src="<?php echo $row["Image"]; ?>" class="img-responsive">
                                <h5 class="text-info"><?php echo $row["Product Name"]; ?></h5>
                                <h5 class="text-danger">Rs <?php echo $row["Price"]; ?></h5>
                                <input type="text" name="quantity" class="form-control" value="1">
                                <input type="hidden" name="hidden_name" value="<?php echo $row["Product Name"]; ?>">
                                <input type="hidden" name="hidden_price" value="<?php echo $row["Price"]; ?>">
                                <input type="submit" name="add" style="margin-top: 5px;" class="btn btn-success"
                                       value="Add to Cart">
                            </div>
                        </form>
                    </div>
                    <?php
                }
            }
        ?>

        <div style="clear: both"></div>
        <h2 class="title2">Shopping Cart Details</h2>
        <div class="table-responsive">
            <table width="100%" height="131" class=" table alert-dark">
            <tr>
                <th width="30%">Product Name</th>
                <th width="10%">Quantity</th>
                <th width="13%">Price Details</th>
                <th width="10%">Total Price</th>
                <th width="17%">Remove Item</th>
            </tr>

            <?php
                if(!empty($_SESSION["ShoppingCartCar"])){
                    $total = 0;
                    foreach ($_SESSION["ShoppingCartCar"] as $key => $value) {
                        ?>
                        <tr>
                            <td><?php echo $value["item_name"]; ?></td>
                            <td><?php echo $value["item_quantity"]; ?></td>
                            <td>Rs <?php echo $value["product_price"]; ?></td>
                            <td>
                                Rs <?php echo number_format($value["item_quantity"] * $value["product_price"], 2); ?></td>
                            <td><a href="ShoppingCartCar.php?action=delete&ID=<?php echo $value["product_id"]; ?>"><span
                                        class="text-danger">Remove Item</span></a></td>

                        </tr>
                        <?php
                        $total = $total + ($value["item_quantity"] * $value["product_price"]);
                    }
                        ?>
                        <tr>
                            <td colspan="3" align="right">Total</td>
                            <th align="right">Rs <?php echo number_format($total, 2); ?></th>
                            <td>
                            <a href="https://www.paypal.com/signin?returnUri=https%3A%2F%2Fwww.paypal.com%2Fmyaccount&state=%2F"><img src="paypalImage.jpg" height="50" width="100"></a>
                            </td>
                        </tr>
                        <?php
                    }
                ?>
            </table>
        </div>

    </div>


</body>
</html>