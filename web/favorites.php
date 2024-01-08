<!DOCTYPE html>
<html>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// Start the session
session_start();

// Get the user ID from the session
if (isset($_SESSION['user_id'])) {
    $userID = $_SESSION['user_id'];
} else {
    // User ID not available, handle the error or redirect to login
    // For simplicity, I'm setting it to a default value of 0
    $userID = 0;
}

// Search query
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $minPrice = $_GET['min_price'];
    $maxPrice = $_GET['max_price'];

    $sql = "SELECT anuncios.*
                FROM anuncios
                JOIN favorites ON anuncios.id = favorites.itemid
                WHERE favorites.userid = $userID
                AND (anuncios.titulo LIKE '%$search%' OR anuncios.valor = '$search')";

    if (!empty($minPrice) && !empty($maxPrice)) {
        $sql .= " AND anuncios.valor >= '$minPrice' AND anuncios.valor <= '$maxPrice'";
    }
} else {
    $sql = "SELECT anuncios.*
                FROM anuncios
                JOIN favorites ON anuncios.id = favorites.itemid
                WHERE favorites.userid = $userID";

    if (!empty($_GET['min_price']) && !empty($_GET['max_price'])) {
        $minPrice = $_GET['min_price'];
        $maxPrice = $_GET['max_price'];
        $sql .= " AND anuncios.valor >= '$minPrice' AND anuncios.valor <= '$maxPrice'";
    }
}

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<head>
    <title>OpenMarket Favoritos</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" type="text/css" href="css/jquery-ui1.css">
    <!--fonts-->
    <link href='//fonts.googleapis.com/css?family=Ubuntu+Condensed' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    <meta charset="UTF-8">
    <!-- isto é para poder usar acentuação -->
    <!--//fonts-->
</head>
<style>
    .remove-container {
        text-align: right;
        margin-top: 10px;
    }

    .remove-text {
        display: inline-block;
        margin-right: 10px;
    }

    .remove-button {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        font-size: 16px;
    }
    .already-favorite {
    background: black;
    color: white;
    cursor: not-allowed;
}

</style>

<body>
    <div class="header">
        <div class="container">
            <div class="logo">
                <a href="index_after_login.html"><span>Open</span>Market</a>
            </div>
            <div class="header-right">
                <a class="account" href="login.html">Minha Conta</a>
                <a class="account" href="contact.html">Contacte-nos</a>
            </div>
        </div>
        <div class="banner text-center">
            <div class="container">
                <h1>Venda e anuncie <span class="segment-heading"> tudo online </span> com o OpenMarket</h1>
                <p></p>
                <a href="post-ad.html">Coloque Aqui o Seu Artigo</a>
            </div>
        </div>
        <!-- Mobiles -->
        <div class="total-ads main-grid-border">
            <div class="container">
                <ol class="breadcrumb" style="margin-bottom: 5px;">
                    <li><a href="index_after_login.html">Inicio</a></li>
                    <li class="active">Favoritos</li>
                </ol>
                <div class="ads-grid">
                    <div class="side-bar col-md-3">
                        <div class="search-hotel">
                            <h3 class="sear-head">Nome do artigo</h3>
                            <form method="GET" action="mobiles.php">
                                <input type="text" name="search" placeholder="Nome do produto..." required="">
                                <input type="submit" value=" " style="background-color: red;">
                            </form>
                        </div>
                        <div class="range">
                            <h3 class="sear-head">Insira o intervalo de preço</h3>
                            <br>
                            <form method="GET" action="mobiles.php">
                                <input type="text" name="min_price" placeholder="min" />
                                <br>
                                <input type="text" name="max_price" placeholder="max" />
                                <br>
                                <input type="submit" name="submit" value="Pesquisar" style="background-color: red; color: white;">
                            </form>
                        </div>
                    </div>
                    <div class="ads-display col-md-9">
                        <div class="wrapper">
                            <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
                                <ul id="myTab" class="nav nav-tabs nav-tabs-responsive" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">
                                            <span class="text">Todos os anuncios</span>
                                        </a>
                                    </li>
                                </ul>
                                <div id="myTabContent" class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="home" aria-labelledby="home-tab">
                                        <div>
                                            <div id="container">
                                                <div class="sort">
                                                </div>
                                                <div class="clearfix"></div>
                                                <ul class="list">
                                                    <?php
                                                    if (mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $id = $row['id'];
                                                            $sql_image = "SELECT * FROM fotos WHERE anuncio_id = $id";
                                                            $result_2 = mysqli_query($conn, $sql_image);
                                                            $row_image = mysqli_fetch_assoc($result_2);
                                                            // Retrieve the favorites information for the current item
                                                            $favoritesSql = "SELECT * FROM favorites WHERE itemId = '{$row['id']}' AND userid = '$userID'";
                                                            $favoritesResult = mysqli_query($conn, $favoritesSql);

                                                            // Check if the item is in favorites for the current user
                                                            $isFavorite = (mysqli_num_rows($favoritesResult) > 0);
                                                    ?>
                                                            <a href="single.php?id=<?php echo $row['id']; ?>">
                                                                <li>
                                                                    <div class="image-container">
                                                                        <img src="<?php echo $row_image['photo_capa'] ?>" title="" alt="" />
                                                                    </div>
                                                                    <section class="list-left">
                                                                        <h5 class="title"><?php echo $row['titulo'] ?></h5>
                                                                        <span class="adprice"><?php echo $row['valor'] ?>€</span>
                                                                    </section>
                                                                    <section class="list-right">
                                                                        <span class="cityname"><?php echo $row['cidade'] ?></span>
                                                                        <span class="cityname"><?php echo $row['created_at'] ?></span>
                                                                    </section>
                                                                    <div class="clearfix"></div>
                                                                    <?php
                                                                    // Add the Remove button with trash glyphicon
                                                                    echo '
                                                                        <div class="remove-container">
                                                                            <span class="remove-text">Remover dos favoritos</span>
                                                                            <a href="API_remove_from_favorites.php?id=' . $row['id'] . '">
                                                                                <button class="' . ($isFavorite ? 'already-favorite' : 'remove-button') . '">
                                                                                    <span class="glyphicon glyphicon-trash"></span>
                                                                                </button>
                                                                            </a>
                                                                        </div>';
                                                                    ?>
                                                                </li>

                                                            </a>
                                                    <?php
                                                        }
                                                    } else {
                                                        echo "<li>No results found.</li>";
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--//Mobiles-->
    <!--footer section start-->
    <footer>
        <div class="footer-bottom text-center">
            <div class="container">
                <div class="footer-logo">
                    <a href="index.html"><span>Open</span>Market</a>
                </div>
                <div class="footer-social-icons">
                    <ul>
                        <li><a class="facebook" href="#"><span>Facebook</span></a></li>
                        <li><a class="twitter" href="#"><span>Twitter</span></a></li>
                        <li><a class="googleplus" href="#"><span>Google+</span></a></li>
                    </ul>
                </div>
                <div class="copyrights">
                    <p> © 2019 OpenMarket. | Concluido por Alexandre Rodrigues</a></p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </footer>
    <!--footer section end-->
</body>

</html>