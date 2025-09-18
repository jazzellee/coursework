<?php
include_once("connection.php");

if (
    isset($_POST["userid"], $_POST["bookid"], $_POST["isbn"], $_POST["borrowdate"], $_POST["status"])
) {
    array_map("htmlspecialchars", $_POST);

    switch ($_POST["paid"]) {
        case "Unpaid":
            $paid = 0;
            break;
        case "Paid":
            $paid = 1;
            break;
        default:
            $paid = null;
    }

    switch ($_POST["status"]) {
        case "Preparing":
            $status = 0;
            break;
        case "Dispatched":
            $status = 1;
            break;
        case "Out for Delivery":
            $status = 2;
            break;
        case "Delivered":
            $status = 3;
            break;
        default:
            $status = null;
    }
    


    if ($paid !== null) {
            $stmt = $conn->prepare("INSERT INTO tblorders(userid, bookid, isbn, borrowdate, duedate, status)
                VALUES (:userid, :bookid, :isbn, :borrowdate, :duedate, :status)");
            
        //try {
            $stmt->bindParam(':userid', $_POST["userid"]);
            $stmt->bindParam(':bookid', $_POST["bookid"]);
			$stmt->bindParam(':isbn', $_POST["isbn"]);
            $stmt->bindParam(':borrowdate', $borrowdate);
            $stmt->bindParam(':duedate', $duedate);
            $stmt->bindParam(':status', $status);

            $stmt->execute();

            
         //   header('Location: users.php');
         //   exit();
       // } catch (PDOException $e) {
            
        //    error_log("Database error: " . $e->getMessage());
         //   echo "An error occurred. Please try again later.";
        //}
    
    } else {
        echo "Please select loan status.";
    }
} else {
    echo "Incomplete form submission.";
}

$conn = null;
?>