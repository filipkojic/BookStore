<?php
session_start();

$author_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$author_name = '';

foreach ($_SESSION['authors'] as $author) {
    if ($author['id'] == $author_id) {
        $author_name = htmlspecialchars($author['first_name'] . ' ' . $author['last_name']);
        break;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete'])) {
    foreach ($_SESSION['authors'] as $key => $author) {
        if ($author['id'] == $author_id) {
            unset($_SESSION['authors'][$key]);
            break;
        }
    }

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
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $author_id; ?>" method="POST">
                <button type="submit" name="confirm_delete" class="delete-button">Delete</button>
                <button type="button" class="cancel-button" onclick="window.history.back();">Cancel</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
