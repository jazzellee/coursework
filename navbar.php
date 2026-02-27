<!-- javascript to toggle sidebar -->
<script>
function toggleSidebar() {
    var sidebar = document.getElementById("sidebar-content");
    var main = document.getElementById("main-content");
    if (sidebar.style.display === "none" || sidebar.style.display === "") {
        sidebar.style.display = "block";
        var sidebarWidth = window.innerWidth < 640 ? window.innerWidth : 320;
        main.style.marginLeft = sidebarWidth + "px";
    } else {
        sidebar.style.display = "none";
        main.style.marginLeft = "0";
    }
}
</script>

<style>
body {
    margin: 0;
    padding: 0;
}
#sidebar-content {
    position: fixed;
    left: 0;
    top: 0;
    width: 320px;
    height: 100vh;
    overflow-y: auto;
    border-right: 1px solid #ddd;
    padding: 20px;
    box-sizing: border-box;
}
@media (max-width: 640px) {
    #sidebar-content {
        width: 100vw;
    }
}
#main-content {
    transition: margin-left 0.3s;
}
#navbar {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    position: relative;
    z-index: 10;
}
#navbar-left, #navbar-center, #navbar-right {
    display: flex;
    gap: 20px;
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
echo ('<button onclick="toggleSidebar()">=</button>');
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
                $total=$total+($item["qty"]);
            }
        }
    
    echo '<a href="viewcart.php">Cart: '.$total.'</a>';
} else {
    echo '<a href="viewcart.php">Cart: 0</a>';
}
echo ('</div>');

echo ('</div>');

echo ('<div id="sidebar-content" style="display:none;">');
include_once("sidebar.php");
echo ('</div>');

echo ('<div id="main-content">');

