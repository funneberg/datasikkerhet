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
        <p><?php echo $course['navn'] ?></p>
        <p><?php echo $course['epost'] ?></p>
        <img style="width:150px" src="./bilder/<?php echo $course['bilde'] ?>" />

        <!-- Forelesere kan ikke sende henvendelser. -->
        <?php if (!(isset($_SESSION['foreleser']))): ?>
            <form method="post">
                <textarea name="inquiry" cols="30" rows="5"></textarea>
                <button name="sendInquiry">Send</button>
            </form>
        <?php endif; ?>

        <!-- Henvendelser -->
        <?php foreach ($inquiries as $inquiry): ?>
            <div style="border-left: 2px solid; padding: 10px; margin: 10px">
                <p><?php echo $inquiry['henvendelse'] ?>

                <!-- Man kan ikke rapportere sine egne henvendelser. -->
                <?php if (!isset($_SESSION['email']) || $_SESSION['email'] != $inquiry['avsender']): ?>
                    <form method="post">
                        <button name="reportInquiry">Rapporter</button>
                        <input type="hidden" name="id" value=<?php echo $inquiry['id'] ?> />
                    </form>
                <?php endif; ?>

                <form method="post">
                    <textarea name="comment" cols="30" rows="5"></textarea>
                    <button name="sendComment">Svar</button>
                    <input type="hidden" name="id" value=<?php echo $inquiry['id'] ?> />
                </form>

                <!-- Viser svar fra foreleser. -->
                <?php if (isset($inquiry['svar'])): ?>
                    <div style="border-left: 2px solid; padding: 10px; margin-bottom: 10px">
                        <p>Svar fra <?php echo $course['navn'] ?>:</p>
                        <p><?php echo $inquiry['svar'] ?>
                    </div>
                <?php endif; ?>

                <p>Kommentarer (<?php echo sizeof($inquiry['comments']) ?>):</p>

                <!-- Kommentarer til en henveldelse. -->
                <?php foreach ($inquiry['comments'] as $comment): ?>

                    <div style="border-left: 2px solid; padding: 10px; margin-bottom: 10px">
                        <p><?php echo $comment['kommentar'] ?></p>

                        <!-- Man kan ikke rapportere sine egne kommentarer. -->
                        <?php if (!isset($_SESSION['email']) || $_SESSION['email'] != $comment['avsender']): ?>
                            <form method="post">
                                <button name="reportComment">Rapporter</button>
                                <input type="hidden" name="id" value=<?php echo $comment['id'] ?> />
                            </form>
                        <?php endif; ?>

                    </div>

                <?php endforeach; ?>

            </div>
        <?php endforeach; ?>
    </main>
</body>
</html>