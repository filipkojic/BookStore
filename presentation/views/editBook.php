<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Edit</title>
    <link rel="stylesheet" href="/presentation/public/css/editBookForm.css">
</head>
<body>

<div class="form-container">
    <h2>Edit Book (ID: <?php echo $book->getId(); ?>)</h2>
    <hr>
    <form action="/editBook/<?php echo $book->getId(); ?>" method="POST">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
        <?php if ($name_error): ?>
            <span class="error"><?php echo $name_error; ?></span>
        <?php endif; ?>

        <label for="year">Year</label>
        <input type="text" id="year" name="year" value="<?php echo htmlspecialchars($year); ?>">
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
