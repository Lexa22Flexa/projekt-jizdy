<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $this->renderSection("titulek"); ?>
    <?= $this->include("Layout/css"); ?>
</head>
<body>
    <div class="container">
        <?= $this->include("Layout/navbar"); ?>
        <?= $this->renderSection("content"); ?>
    </div>
</body>
</html>