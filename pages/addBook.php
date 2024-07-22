<?php
$title_error = $year_error = "";
$title = $year = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["title"])) {
        $title_error = "* This field is required";
    } elseif (strlen($_POST["title"]) > 250) {
        $title_error = "* Title must be less than 250 characters";
    } else {
        $title = htmlspecialchars($_POST["title"]);
    }

    if (empty($_POST["year"])) {
        $year_error = "* This field is required";
    } elseif (!is_numeric($_POST["year"]) || $_POST["year"] <= -5000 || $_POST["year"] >= 1000000 || $_POST["year"] == 0) {
        $year_error = "* Year must be a number between -5000 and 999999, and cannot be 0";
    } else {
        $year = htmlspecialchars($_POST["year"]);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Create</title>
    <link rel="stylesheet" href="../css/bookForm.css">
</head>
<body>

<div class="form-container">
    <h2>Book Create</h2>
    <hr>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" value="<?php echo $title; ?>" maxlength="250">
        <?php if ($title_error): ?>
            <span class="error"><?php echo $title_error; ?></span>
        <?php endif; ?>

        <label for="year">Year</label>
        <input type="text" id="year" name="year" value="<?php echo $year; ?>">
        <?php if ($year_error): ?>
            <span class="error"><?php echo $year_error; ?></span>
        <?php endif; ?>

        <div class="button-container">
            <button type="submit">Save</button>
        </div>
    </form>
</div>

</body>
</html>
