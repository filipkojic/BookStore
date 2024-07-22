<?php
$author_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$author_name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete'])) {

    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Author</title>
    <link rel="stylesheet" href="../css/deleteAuthor.css">
</head>
<body>

<div class="dialog-container">
    <div class="dialog">
        <div class="dialog-header">
            <h2>Delete Author</h2>
        </div>
        <div class="dialog-body">
            <p>You are about to delete the author '<strong><?php echo $author_name; ?></strong>'. If you proceed with this action, the application will permanently delete all books related to this author.</p>
        </div>
        <div class="dialog-footer">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $author_id . '&name=' . urlencode($author_name); ?>" method="POST">
                <button type="submit" name="confirm_delete" class="delete-button">Delete</button>
                <button type="button" class="cancel-button" onclick="window.history.back();">Cancel</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
