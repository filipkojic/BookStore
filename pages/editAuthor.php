<?php
session_start();

if (!isset($_SESSION['authors'])) {
    header("Location: ../index.php");
    exit();
}

$author_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$author = null;

foreach ($_SESSION['authors'] as $a) {
    if ($a['id'] == $author_id) {
        $author = $a;
        break;
    }
}

if (!$author) {
    header("Location: ../index.php");
    exit();
}

$first_name_error = $last_name_error = "";
$first_name = $author['first_name'];
$last_name = $author['last_name'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["first_name"])) {
        $first_name_error = "* This field is required";
    } elseif (strlen($_POST["first_name"]) > 100) {
        $first_name_error = "* First name must be less than 100 characters";
    } else {
        $first_name = htmlspecialchars($_POST["first_name"]);
    }

    if (empty($_POST["last_name"])) {
        $last_name_error = "* This field is required";
    } elseif (strlen($_POST["last_name"]) > 100) {
        $last_name_error = "* Last name must be less than 100 characters";
    } else {
        $last_name = htmlspecialchars($_POST["last_name"]);
    }

    if (empty($first_name_error) && empty($last_name_error)) {
        foreach ($_SESSION['authors'] as &$a) {
            if ($a['id'] == $author_id) {
                $a['first_name'] = $first_name;
                $a['last_name'] = $last_name;
                break;
            }
        }
        unset($a);

        header("Location: ../index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Author</title>
    <link rel="stylesheet" href="../css/authorForm.css">
</head>
<body>

<div class="form-container">
    <h2>Edit Author</h2>
    <hr>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $author_id; ?>" method="POST">
        <label for="first_name">First name</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo $first_name; ?>">
        <?php if ($first_name_error): ?>
            <span class="error"><?php echo $first_name_error; ?></span>
        <?php endif; ?>

        <label for="last_name">Last name</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>">
        <?php if ($last_name_error): ?>
            <span class="error"><?php echo $last_name_error; ?></span>
        <?php endif; ?>

        <div class="button-container">
            <button type="submit">Save</button>
        </div>
    </form>
</div>

</body>
</html>
