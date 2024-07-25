<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Edit</title>
    <link rel="stylesheet" href="/Presentation/Public/css/editBookForm.css">
</head>
<body>

<div class="form-container">
    <h2>Edit Book (ID: <?php echo $book->getId(); ?>)</h2>
    <hr>
    <form action="/editBook/<?php echo $book->getId(); ?>" method="POST">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
        <?php if ($nameError): ?>
            <span class="error"><?php echo $nameError; ?></span>
        <?php endif; ?>

        <label for="year">Year</label>
        <input type="text" id="year" name="year" value="<?php echo htmlspecialchars($year); ?>">
        <?php if ($yearError): ?>
            <span class="error"><?php echo $yearError; ?></span>
        <?php endif; ?>

        <div class="button-container">
            <button type="submit">Save</button>
        </div>
    </form>
</div>

</body>
</html>
