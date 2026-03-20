<!-- javascript to toggle sidebar -->
<script>
function toggleSidebar() {
    document.body.classList.toggle("sidebar-open");
}
</script>

<style>
body {
    margin: 0;
}

#sidebar-content {
    position: fixed;
    z-index: 20;
    left: 0;
    top: 0;
    width: 320px;
    height: 100vh;
    overflow-y: auto;
    border-right: 1px solid #ddd;
    padding: 70px 20px 20px 20px;
    box-sizing: border-box;
    background-color: #fff8ed;
    transform: translateX(-100%);
    visibility: hidden;
    pointer-events: none;
    transition: transform 0.35s cubic-bezier(0.22, 0.61, 0.36, 1), visibility 0s linear 0.35s;
}

body.sidebar-open #sidebar-content {
    transform: translateX(0);
    visibility: visible;
    pointer-events: auto;
    transition: transform 0.35s cubic-bezier(0.22, 0.61, 0.36, 1), visibility 0s linear 0s;
}

#sidebar-content ~ * {
    transition: transform 0.35s cubic-bezier(0.22, 0.61, 0.36, 1);
}

body.sidebar-open #sidebar-content ~ * {
    transform: translateX(320px);
}

@media (max-width: 640px) {
    #sidebar-content {
        width: 100vw;
    }

    body.sidebar-open #sidebar-content ~ * {
        transform: translateX(0);
    }
}

#navbar {
    display: flex;
    justify-content: space-between;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 40;
    padding: 10px 20px;
    box-sizing: border-box;
    background-color: transparent;
}

#navbar-left, #navbar-center, #navbar-right {
    display: flex;
    gap: 20px;
}

#navbar-left {
    position: relative;
    z-index: 30;
}

#navbar-left button {
    position: relative;
    z-index: 31;
    background: transparent;
    border: none;
    padding: 0;
    cursor: pointer;
}

#navbar-left button img {
    width: 24px;
    height: 14px;
    display: block;
}

#navbar-center {
    flex: 1;
    justify-content: center;
}
</style>

<?php

echo ('<div id="navbar">');

echo ('<div id="navbar-left">');
/* button to open sidebar */
echo ('<button class="navbar-toggle-button" onclick="toggleSidebar()"><img src="images/content/sidebar-toggle.png" alt="Toggle sidebar"></button>');
echo ('</div>');

echo ('<div id="navbar-center">');
/* link to homepage */
echo ('<a href="homepage.php">Home</a>');

/* link to products */
echo ('<a href="displayproducts.php">Products</a>');
echo ('</div>');

echo ('<div id="navbar-right">');
/* shows no. of items in cart */
if (isset($_SESSION["item"])){
    $total = 0;
    foreach ($_SESSION["item"] as $item){
        $stmt = $conn->prepare("SELECT * FROM tblproducts WHERE productid=:productid");
        $stmt->bindParam(':productid', $item["item"]);
        $stmt->execute();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $total = $total+($item["qty"]);
            }
        }
    
    echo('<a href="viewcart.php"><img src="images/content/cart-icon.png" style="vertical-align: middle;" width="28" height="28"> '.$total.'</a>');
} else {
    echo('<a href="viewcart.php"><img src="images/content/cart-icon.png" style="vertical-align: middle;" width="28" height="28"> 0</a>');
}
echo ('</div>');

echo ('</div>');

echo ('<div id="sidebar-content">');
include_once("sidebar.php");
echo ('</div>');


