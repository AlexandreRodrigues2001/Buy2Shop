<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "buy2shop";
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

// Retrieve ad details based on the ID parameter
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$sql = "SELECT * FROM anuncios WHERE id = '$id'";
	$sql_photos = "SELECT * FROM fotos WHERE anuncio_id = '$id'";
	$result = mysqli_query($conn, $sql);
	$result_photos = mysqli_query($conn, $sql_photos);
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Buy2shop</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
	<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="css/font-awesome.min.css" />
	<!--fonts-->
	<link href='//fonts.googleapis.com/css?family=Ubuntu+Condensed' rel='stylesheet' type='text/css'>
	<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
	<meta charset="UTF-8"> <!-- isto é para poder usar acentuação -->
	<!--//fonts-->
</head>
<style>
	#addToFavoritesBtn {
		background-color: red;
	}

	#addToFavoritesBtn.clicked {
		background-color: black;
		color: white;
	}

	#addToFavoritesBtn.clicked .glyphicon-star {
		color: white;
	}
</style>
<body>
	<div class="header">
		<div class="container">
			<div class="logo">
				<a href="index_after_login.html">
					<img src="images/logo_buy2shop.jpeg" width="300" height="70">
				</a>
			</div>
			<div class="header-right">
				<a class="account" href="account.html">Minha conta</a>
				<a class="account" href="contact.html">Contacte-nos</a>
			</div>
		</div>
	</div>
	<div class="main-banner banner text-center">
		<div class="container">
			<h1>A sua fonte confiável <span class="segment-heading"> de peças usadas , </span> Buy2Shop</h1>
			<p></p>
			<a href="post-ad.html">Coloque aqui o seu artigo</a>
		</div>
	</div>
	<!--single-page-->
	<div class="single-page main-grid-border">
		<div class="container">
			<ol class="breadcrumb" style="margin-bottom: 5px;">
				<li><a href="index_after_login.html">categorias</a></li>
				<li class="active">Anúncio</li>
			</ol>
			<div class="product-desc">
				<?php
				if (mysqli_num_rows($result) > 0) {
					$ad = mysqli_fetch_assoc($result);
					$ad_photos = mysqli_fetch_assoc($result_photos);
					// Display ad details
				?>
					<div class="col-md-7 product-view">
						<h2><?php echo $ad['titulo'] ?></h2>
						<p> <i class="glyphicon glyphicon-map-marker"></i><a href="#"><?php echo $ad['cidade'] ?></a> | Adicionado a <?php echo $ad['created_at'] ?></p>
						<div class="flexslider">
							<ul class="slides">
								<?php
								// Retrieve image URLs from the database
								$imageUrls = array($ad_photos['photo_capa'], $ad_photos['photo_1'], $ad_photos['photo_2']);
								foreach ($imageUrls as $imageUrl) {
								?>
									<li data-thumb="<?php echo $imageUrl ?>">
										<img src="<?php echo $imageUrl ?>" />
									</li>
								<?php
								}
								?>
							</ul>
						</div>
						<!-- FlexSlider -->
						<script defer src="js/jquery.flexslider.js"></script>
						<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />
						<script>
							// Can also be used with $(document).ready()
							$(window).load(function() {
								$('.flexslider').flexslider({
									animation: "slide",
									controlNav: "thumbnails"
								});
							});
						</script>
						<!-- //FlexSlider -->
						<div class="product-details">
							<p><strong>Descrição: </strong><?php echo $ad['descricao'] ?></p>
						</div>
					</div>
					<div class="col-md-5 product-details-grid">
						<div class="item-price">
							<div class="product-price">
								<p class="p-price">Preço</p>
								<h3 class="rate"><?php echo $ad['valor'] ?> €</h3>
								<div class="clearfix"></div>
							</div>
							<div class="itemtype">
								<p class="p-price">Categoria</p>
								<h4><?php echo $ad['categoria'] ?></h4>
								<div class="clearfix"></div>
							</div>
							<div class="condition">
								<p class="p-price">Add aos favoritos:</p>
								<button type="button" id="addToFavoritesBtn" class="btn btn-default" onclick="addToFavorites()">
									<span class="glyphicon glyphicon-star" id="starIcon"></span>
								</button>

								<div class="clearfix"></div>
							</div>
						</div>
						<div class="interested text-center">
							<h4 style="color: red;">Interessado no anúncio?<small style="color: white;"> Contacta o vendedor!</small></h4>
							<p style="color: white;"><i class="glyphicon glyphicon-earphone" style="background-color: red;"></i><?php echo $ad['telemovel'] ?></p>
						</div>

					</div>
					<div class="clearfix"></div>
				<?php
				} else {
					echo "Ad not found.";
				}
				?>
			</div>
		</div>
	</div>
	<!--//single-page-->
	<!--footer section start-->
	<footer>
		</div>
		<div class="footer-bottom text-center">
			<div class="container">
				<div class="footer-logo">
					<a href="index_after_login.html">
						<img src="images/logo_footer.jpeg" width="300" height="80">
					</a>

				</div>
				<div class="footer-social-icons">
					<ul>
						<li><a class="facebook" href="#"><span>Facebook</span></a></li>
						<li><a class="twitter" href="#"><span>Twitter</span></a></li>
						<li><a class="googleplus" href="#"><span>Google+</span></a></li>
					</ul>
				</div>
				<div class="copyrights">
					<p> © 2023 Buy2Shop. | Concluido por Alexandre Rodrigues e Cláudia Fernandes</a></p>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</footer>
	<!--footer section end-->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-select.js"></script>
	<script>
		$(window).load(function() {
			$('.flexslider').flexslider({
				animation: "slide",
				controlNav: "thumbnails"
			});
		});
	</script>
	<script>
		function addToFavorites() {
			var itemId = <?php echo $ad['id']; ?>;
			var addToFavoritesBtn = document.getElementById('addToFavoritesBtn');

			fetch('API_add-to-favorites.php', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json'
					},
					body: JSON.stringify({
						itemId: itemId
					}),
				})
				.then(response => {
					if (response.ok) {
						console.log('Item added to favorites');
						addToFavoritesBtn.classList.add('clicked');
						// Disable the button after successfully adding to favorites
						addToFavoritesBtn.disabled = true;
					} else {
						console.error('Error adding item to favorites');
					}
				})
				.catch(error => {
					console.error('Error:', error);
				});
		}
	</script>



</body>

</html>