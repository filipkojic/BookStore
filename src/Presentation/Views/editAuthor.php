<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Author</title>
    <link rel="stylesheet" href="/src/Presentation/Public/css/editAuthorForm.css">
</head>
<body>

<div class="form-container">
    <h2>Edit Author</h2>
    <hr>
    <form action="/editAuthor/<?php echo $author->getId(); ?>" method="POST">
        <label for="firstName">First name</label>
        <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($firstName); ?>">
        <?php if ($firstNameError): ?>
            <span class="error"><?php echo $firstNameError; ?></span>
        <?php endif; ?>

        <label for="lastName">Last name</label>
        <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($lastName); ?>">
        <?php if ($lastNameError): ?>
            <span class="error"><?php echo $lastNameError; ?></span>
        <?php endif; ?>

        <div class="button-container">
            <button type="submit">Save</button>
        </div>
    </form>
</div>

</body>
</html>
