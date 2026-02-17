<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Zane Ābele">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PHP un DB</title>
    <link rel="stylesheet" href="stils.css">
    <?php require_once 'funkcijas.php'; ?>
</head>
<body>
    <header>
        <h1>PHP un DB</h1>
        <p>Personu informācijas sistēma</p>
    </header>
    <main>
        <section class="menu-block">
            <h2>Personu saraksts</h2>
            <?php echo menu(); ?>
        </section>
        <section class="content-block">
            <h2>Informācija par personu</h2>
            <?php echo content(); ?>
        </section>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?>, Zane Ābele.</p>
        <p>Programmēšanas ieskaites darbs Nr.3</p>
    </footer>
</body>
</html>