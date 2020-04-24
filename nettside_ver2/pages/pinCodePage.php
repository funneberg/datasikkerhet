<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <h1><?php echo $course['emnekode']." ".$course['emnenavn'] ?></h1>
        <?php include_once("components/navbar_simple.php") ?>
    </header>
    <main>
        <form method="post">
            <p>PIN-kode:</p>
            <input type="number" name="PIN" />
            <button name="submitPin">Send</button>
        <form>

        <!-- Skriver ut en tilbakemelding hvis PIN-koden er feil. -->
        <?php if (isset($_POST['PIN'])): ?>
            <p>Feil PIN-kode.</p>
        <?php endif; ?>
    </main>
</body>
</html>