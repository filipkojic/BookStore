<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Author</title>
    <link rel="stylesheet" href="/presentation/public/css/editAuthorForm.css">
</head>
<body>

<div class="form-container">
    <h2>Edit Author</h2>
    <hr>
    <form action="/editAuthor/<?php echo $author->getId(); ?>" method="POST">
        <label for="first_name">First name</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>">
        <?php if ($first_name_error): ?>
            <span class="error"><?php echo $first_name_error; ?></span>
        <?php endif; ?>

        <label for="last_name">Last name</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>">
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
