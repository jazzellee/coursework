<?php
include_once("connection.php");

if (
    isset($_POST["userid"], $_POST["bookid"], $_POST["isbn"], $_POST["borrowdate"], $_POST["status"])
) {
    array_map("htmlspecialchars", $_POST);

print_r($_POST);
$borrowdate = $_POST["borrowdate"]; // Assuming it's a valid date string

// Create a DateTime object from the borrowdate
$borrowdate_obj = new DateTime($borrowdate);

// Add 14 days
$borrowdate_obj->add(new DateInterval("P14D"));

// Get the due date and format it to only show the date (Y-m-d)
$duedate = $borrowdate_obj->format("Y-m-d");

echo $duedate; // Display the due date

    switch ($_POST["status"]) {
        case "On Loan":
            $status = 0;
            break;
        case "Returned":
            $status = 1;
            break;
        default:
            $status = null;
    }
    


    if ($status !== null) {

       
            $stmt = $conn->prepare("INSERT INTO tblloans(userid, bookid, isbn, borrowdate, duedate, status)
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