<?php
	$connect = mysqli_connect('localhost','root','','project');

	$showquery1 = mysqli_query($connect, "select * from product");
	$showquery3 = mysqli_query($connect, "select * from product where status='On Sale'");
	
	$showquery2 = mysqli_query($connect, "select * from product where status='Featured Category'");
	
	if(isset($_POST["add_to_cart"]))
{
	if(isset($_SESSION["shopping_cart"]))
	{
		$item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
		if(!in_array($_GET["id"], $item_array_id))
		{
		$count = count($_SESSION["shopping_cart"]);
		$item_array = array(
		'item_id'		=>	$_GET["id"],
		'item_name'		=>	$_POST["hidden_name"],
		'item_price'		=>	$_POST["hidden_price"],
		'item_quantity'		=>	$_POST["quantity"]
		);
		$_SESSION["shopping_cart"][$count] = $item_array;
		}
		else
		{
		echo '<script>alert("Item Already Added")</script>';
		}
	}
	else
	{
		$item_array = array(
		'item_id'		=>	$_GET["id"],
		'item_name'		=>	$_POST["hidden_name"],
		'item_price'		=>	$_POST["hidden_price"],
		'item_quantity'		=>	$_POST["quantity"]
		);
		$_SESSION["shopping_cart"][0] = $item_array;
	}
}
 
if(isset($_GET["action"]))
{
	if($_GET["action"] == "delete")
	{
		foreach($_SESSION["shopping_cart"] as $keys => $values)
		{
		if($values["item_id"] == $_GET["id"])
		{
		unset($_SESSION["shopping_cart"][$keys]);
		echo '<script>alert("Item Removed")</script>';
		echo '<script>window.location="sample.php"</script>';
		}
		}
	}
}

	
	
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Home</title>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	
	<style>
input[type=number]{
    width: 50px;
	</style>
	
</head>
	<body>
		<div class="top-nav-bar">
			<div class="search-box">
				<img src="logo.jpg" alt="" class="logo">
				<input type="text" name="search" class="form-control">
				<span class="input-group-text"><i class="fa fa-search"></i></span>
			</div>
			<div class="menu-bar">
				<ul>
					<li><a href="#"><i class="fa fa-shopping-basket"></i>cart</a></li>
					<li><a href="login1.php">Login</a></li>
					<li><a href="signup1.php">Sign up</a></li>
				</ul>
			</div>
		</div>
		<section class="header">
			<div class="side-menu">
				<ul>
					<li><a href="engineering.php">Engineering</a></li>
					<li><a href="medical.php">Medical</a> </li>
					<li><a href="programming.php">Programming</a></li>
					<li><a href="islamic.php">Islamic</a></li>
					<li><a href="politics.php">Politics</a><li>
						
				</ul>
			</div>
			<div class="slider">
				<div id="slider" class="carousel slide carousel-fade" data-ride="carousel">
  <div class="carousel-inner">
	<div class="carousel-item active">
      <img src="slide200.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="slide210.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="slide300.jpg" class="d-block w-100" alt="...">
    </div>
  </div>
 <ol class="carousel-indicators">
      <li data-target="#slider" data-slide-to="0" class="active"></li>
      <li data-target="#slider" data-slide-to="1"></li>
      <li data-target="#slider" data-slide-to="2"></li>
      
    </ol>
</div>
			</div>
		</section>
		
		<section class="featured-categories">
			<div class="container">
				<div class="row">
				
				<?php
				
				while($d = mysqli_fetch_assoc($showquery2))
				{
					echo "<div class='col-md-4'>
					<a href='".$d["name"].".php'><img src='img/".$d["name"].".jpg'/></a></div>";
				}
			
				?></div></div></section>
				
				<!-----
				<div class="col-md-4">
					<img src="img/book1.jpg">
				</div>
				<div class="col-md-4">
					<img src="img/book2.jpeg">
				</div>
				<div class="col-md-4">
					<img src="img/book3.jpg">
				</div>
				</div>
			</div>
		</section>
		---->
		<section class="on-sale">
			<div class="container">
				<div class="title-box">
					<h2>On Sale</h2>
				</div>
				<div class="row">
				<?php
				
		if(mysqli_num_rows($showquery3) > 0)
		{
		while($row = mysqli_fetch_array($showquery3))
		{
		?>
		<div class="col-md-3">
		<form method="post" action="cart.php?action=add&id=<?php echo $row["id"]; ?>">
		<div style="border:3px solid #5cb85c; background-color:whitesmoke; border-radius:5px; padding:16px;" align="center">
		
		<?php echo"<img src='img/".$row["name"].".jpg' class='img-responsive' width='100%' height=70%/> <br/>";?>
		<p>Name: <?php echo $row["name"]; ?></p>
		<p><?php echo "Author Name: ".$row["author_name"]; ?></p>
 
		<h4 class="text-danger">TK: <?php echo $row["price"]; ?></h4>
 
		<input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" />
 
		<input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />
 
		<input type="number" name="quantity" value="1"/> &nbsp &nbsp <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />
 
		</div>
		</form>
		</div>
		<?php
		}
		}
			
				?></div>
				</div> </section>
				<!----
				<div class="row">
				<div class="col-md-3">
					<div class="product-top">
						<a href="singleproduct.html"><img src="img/book4.jpg"></a>
						<h3>Name</h3>
						<h5>Tk: 320.00</h5>
						<div class="overlay-right">
						<button type="button" class="btn btn-secondary" title="Quick  Shop">
						<i class="fa fa-eye"></i>
						</button>
						<button type="button" class="btn btn-secondary" title="Add to whitelist">
						<i class="fa fa-heart-o"></i>
						</button>
						<button type="button" class="btn btn-secondary" title="Add to cart">
						<i class="fa fa-shopping-cart"></i>
						</button>
						</div>
					</div>
					<div class="product-bottom text-center">
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star-half-o"></i>
					
					</div>
				</div>
				<div class="col-md-3">
					<div class="product-top">
						<a href="singleproduct.html"><img src="img/book5.jpg"></a>
						<div class="overlay-right">
						<button type="button" class="btn btn-secondary" title="Quick  Shop">
						<i class="fa fa-eye"></i>
						</button>
						<button type="button" class="btn btn-secondary" title="Add to whitelist">
						<i class="fa fa-heart-o"></i>
						</button>
						<button type="button" class="btn btn-secondary" title="Add to cart">
						<i class="fa fa-shopping-cart"></i>
						</button>
						</div>
					</div>
					<div class="product-bottom text-center">
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<h3>Name</h3>
					<h5>Tk: 520.00</h5>
					</div>
					</div>
				<div class="col-md-3">
					<div class="product-top">
						<a href="singleproduct.html"><img src="img/book1.jpg"></a>
						<div class="overlay-right">
						<button type="button" class="btn btn-secondary" title="Quick  Shop">
						<i class="fa fa-eye"></i>
						</button>
						<button type="button" class="btn btn-secondary" title="Add to whitelist">
						<i class="fa fa-heart-o"></i>
						</button>
						<button type="button" class="btn btn-secondary" title="Add to cart">
						<i class="fa fa-shopping-cart"></i>
						</button>
						</div>
					</div>
					<div class="product-bottom text-center">
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<h3>Name</h3>
					<h5>Tk: 180.00</h5>
					</div>
					</div>
					<div class="col-md-3">
					<div class="product-top">
						<a href="singleproduct.html"><img src="img/book2.jpeg"></a>
						<div class="overlay-right">
						<button type="button" class="btn btn-secondary" title="Quick  Shop">
						<i class="fa fa-eye"></i>
						</button>
						<button type="button" class="btn btn-secondary" title="Add to whitelist">
						<i class="fa fa-heart-o"></i>
						</button>
						<button type="button" class="btn btn-secondary" title="Add to cart">
						<i class="fa fa-shopping-cart"></i>
						</button>
						</div>
					</div>
					<div class="product-bottom text-center">
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<h3>Name</h3>
					<h5>Tk: 180.00</h5>
					</div>
					</div>
				</div>
			</div>
		</section>
		---->
		<!--------New Products---------->
		<section class="new-products">
			<div class="container">
				<div class="title-box">
					<h2>New Arrivals</h2>
				</div>
				
				<div class="row">
				<?php
				
				while($d = mysqli_fetch_assoc($showquery2))
				{
					echo "<div class='col-md-3'>
					<a href='".$d["name"].".php'><img src='img/".$d["name"].".jpg' width='100%' height=70%'/></a><p valign='center' align='center'>Name: <b>".$d["name"]."</b><br/>Author Name: <b>".$d["name"]."</b><br/> Price: <b>".$d["price"]."</b><br/><button type='submit' name='submit' class='btn btn-success loginFormElement'>Add to Cart</button></p></div>";
				}
			
				?></div>
				</div> </section>
				<!-----
				<div class="row">
				<div class="col-md-3">
					<div class="product-top">
						<a href="singleproduct.html"><img src="img/book4.jpg"></a>
						<div class="overlay-right">
						<button type="button" class="btn btn-secondary" title="Quick  Shop">
						<i class="fa fa-eye"></i>
						</button>
						<button type="button" class="btn btn-secondary" title="Add to whitelist">
						<i class="fa fa-heart-o"></i>
						</button>
						<button type="button" class="btn btn-secondary" title="Add to cart">
						<i class="fa fa-shopping-cart"></i>
						</button>
						</div>
					</div>
					<div class="product-bottom text-center">
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star-half-o"></i>
					<h3>Name</h3>
					<h5>Tk: 320.00</h5>
					</div>
				</div>
				<div class="col-md-3">
					<div class="product-top">
						<a href="singleproduct.html"><img src="img/book5.jpg"></a>
						<div class="overlay-right">
						<button type="button" class="btn btn-secondary" title="Quick  Shop">
						<i class="fa fa-eye"></i>
						</button>
						<button type="button" class="btn btn-secondary" title="Add to whitelist">
						<i class="fa fa-heart-o"></i>
						</button>
						<button type="button" class="btn btn-secondary" title="Add to cart">
						<i class="fa fa-shopping-cart"></i>
						</button>
						</div>
					</div>
					<div class="product-bottom text-center">
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<h3>Name</h3>
					<h5>Tk: 520.00</h5>
					</div>
					</div>
				<div class="col-md-3">
					<div class="product-top">
						<a href="singleproduct.html"><img src="img/book1.jpg"></a>
						<div class="overlay-right">
						<button type="button" class="btn btn-secondary" title="Quick  Shop">
						<i class="fa fa-eye"></i>
						</button>
						<button type="button" class="btn btn-secondary" title="Add to whitelist">
						<i class="fa fa-heart-o"></i>
						</button>
						<button type="button" class="btn btn-secondary" title="Add to cart">
						<i class="fa fa-shopping-cart"></i>
						</button>
						</div>
					</div>
					<div class="product-bottom text-center">
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<h3>Name</h3>
					<h5>Tk: 180.00</h5>
					</div>
					</div>
<div class="col-md-3">
					<div class="product-top">
						<a href="singleproduct.html"><img src="img/book4.jpg"></a>
						<div class="overlay-right">
						<button type="button" class="btn btn-secondary" title="Quick  Shop">
						<i class="fa fa-eye"></i>
						</button>
						<button type="button" class="btn btn-secondary" title="Add to whitelist">
						<i class="fa fa-heart-o"></i>
						</button>
						<button type="button" class="btn btn-secondary" title="Add to cart">
						<i class="fa fa-shopping-cart"></i>
						</button>
						</div>
					</div>
					<div class="product-bottom text-center">
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<h3>Name</h3>
					<h5>Tk: 180.00</h5>
					</div>
					</div>
				</div>
			</div>
			</section>
			---->
			<!----footer---->
			<section class="footer">
				<div class="container text-center">
				<div class="row">
					<div class="col-md-3">
						<h1>Useful Links</h1>
						<p>Privacy Policy<p>
						<p>Terms of use</p>
						<p>Return policy</p>
						<p>Discount coupons</p>
					</div>
					<div class="col-md-3">
						<h1>Company</h1>
						<p>About us<p>
						<p>Contact us</p>
						<p>Career</p>
						<p>Affiliate</p>
					</div>
					<div class="col-md-3">
						<h1>Support</h1>
						<p>Oreder track</p>
						<p>Find my product</p>
						<p>Guide<p>
						<p>Help desk</p>
					</div>
					<div class="col-md-3">
						<h1>Follow us on</h1>
						<p><i class="fa fa-facebook-official"></i> Facebook<p>
						<p><i class="fa fa-youtube-play"></i> youtube</p>
						<p><i class="fa fa-linkedin"></i> Linked in</p>
						<p><i class="fa fa-twitter"></i> Twitter</p>
					</div>
				</div>
				<hr>
				<p class="copy-right">	&copy Web Technologies Project</p>
				</div>
			</section>
		
		</body>
</html>