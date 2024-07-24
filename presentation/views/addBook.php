<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Create</title>
    <link rel="stylesheet" href="./presentation/public/css/bookForm.css">
</head>
<body>

<div class="form-container">
    <h2>Book Create</h2>
    <hr>
    <form action="/addBook" method="POST">
        <input type="hidden" name="author_id" value="<?php echo htmlspecialchars($author_id); ?>" />
        <input type="hidden" name="form_submitted" value="1" />
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" maxlength="250">
        <?php if ($name_error): ?>
            <span class="error"><?php echo $name_error; ?></span>
        <?php endif; ?>

        <label for="year">Year</label>
        <input type="text" id="year" name="year" value="<?php echo htmlspecialchars($year); ?>">
        <?php if ($year_error): ?>
            <span class="error"><?php echo $year_error; ?></span>
        <?php endif; ?>

        <input type="hidden" name="author_id" value="<?php echo $author_id; ?>">

        <div class="button-container">
            <button type="submit">Save</button>
        </div>
    </form>
</div>

</body>
</html>
