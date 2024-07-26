<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Create</title>
    <link rel="stylesheet" href="/src/Presentation/Public/css/bookForm.css">
</head>
<body>

<div class="form-container">
    <h2>Book Create</h2>
    <hr>
    <form action="/addBook" method="POST">
        <input type="hidden" name="authorId" value="<?php echo htmlspecialchars($authorId); ?>" />
        <input type="hidden" name="formSubmitted" value="1" />
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" maxlength="250">
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
