<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>
<body>

    <header>
       <?php include_once("components/navbar_fancy.php") ?>
    </header>

    <main>

        <!-- Hviser hvor mange forelesere som ikke er godkjente. -->
        <?php if (($numLecturers = sizeof($lecturers)) > 0): ?>

            <p><?php echo $numLecturers." ".($numLecturers > 1 ? "forelesere" : "foreleser") ?> venter på å bli godkjent:</p>

        <?php else: ?>
            <p>Ingen nye forelesere.</p>
        <?php endif; ?>

        <!-- Skriver ut navn og e-post til foreleserene som ikke er godkjente. -->
        <?php foreach ($lecturers as $lecturer): ?>

            <div>
                
                <p><?php echo $lecturer['navn'] ?></p>
                <p><?php echo $lecturer['epost'] ?></p>
                <form method="post">
                    <button name="authorize">Godkjenn</button>
                    <input type="hidden" name="email" value=<?php echo $lecturer['epost'] ?> />
                </form>
            </div>

        <?php endforeach; ?>
    </main>
</body>
</html>