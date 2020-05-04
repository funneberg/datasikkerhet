<!DOCTYPE html>
<html lang="no">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>

<body>

    <header>
        <?php include_once("components/navbar_fancy.php") ?>
    </header>

    <main>

        
        <h1><?php echo $course['emnekode']." ".$course['emnenavn'] ?></h1>
        <p><?php echo $course['navn'] ?></p>
        <p><?php echo $course['epost'] ?></p>
        <img style="width:150px" src="./bilder/<?php echo $course['bilde'] ?>" />

        <div class="card">
            <!-- Forelesere kan ikke sende henvendelser. -->
            <?php if (!isset($_SESSION['lecturer'])): ?>

                <form method="post">
                    <textarea placeholder="Send en henvendelse" rows="10" cols="10" name="inquiry"></textarea>
                    <button class="button is-primary" name="sendInquiry">Send</button>
                </form>

            <?php endif; ?>
        </div>

        <!-- Henvendelser -->
        <?php foreach ($inquiries as $inquiry): ?>
            <div class="container">
                <div id="meldingCard" class="card">

                <div style="border-left: 2px solid; padding: 10px; margin: 10px">

                    <header class="card-header">
                        
                        <p class="card-header-title"><?php echo $inquiry['henvendelse'] ?>

                    </header>

                    <div class="card-content">

                        <div class="content">

                            <!-- Man kan ikke rapportere sine egne henvendelser. -->
                            <?php if ($_SESSION['user'] != $inquiry['avsender_student'] && $_SESSION['user'] != $inquiry['avsender_gjest']): ?>

                                <form method="post">
                                    <button class="button is-primary" name="reportInquiry">Rapporter</button>
                                    <input type="hidden" name="id" value=<?php echo $inquiry['id'] ?> />
                                </form>

                            <?php endif; ?>

                            <form method="post">
                                <textarea name="comment" cols="30" rows="5"></textarea>
                                <button class="button is-primary" name="sendComment">Svar</button>
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

                                    <footer class="card-footer">

                                        <!-- Man kan ikke rapportere sine egne kommentarer. -->
                                        <?php if ($_SESSION['user'] != $inquiry['avsender_student'] && $_SESSION['user'] != $inquiry['avsender_gjest']): ?>

                                            <form method="post">
                                                <button class="button is-primary" name="reportComment">Rapporter</button>
                                                <input type="hidden" name="id" value=<?php echo $comment['id'] ?> />
                                            </form>

                                        <?php endif; ?>
                                    </footer>

                                </div>

                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
            </div>
            </div
        <?php endforeach; ?>
    </main>
</body>
</html>