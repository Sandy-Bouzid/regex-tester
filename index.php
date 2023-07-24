<?php
@$regex = $_POST["regex"];
@$string = $_POST["string"];
@$reset = $_POST["reset"];
@$case = $_POST["case"];

$message = "";
$messageColor = "";
$highlightedString = "";

if (isset($regex) && isset($string)) {
    $i = $case === "on" ? "i" : "";

    if (preg_match_all("/{$regex}/{$i}", $string, $matches)) {
        $message = "Yes";
        $messageColor = "success";

        $wordsToHighlight = array_unique($matches[0], $flags = SORT_STRING);
        $highlightedString = preg_replace('/' . implode('|', $wordsToHighlight) . '/i', '<span style="color:red;"><b>$0</b></span>', $string);
    } else {
        $message = "No";
        $messageColor = "warning";
    }
}

if (isset($reset)) {
    $regex = "";
    $string = "";
    $reset = "";
    $message = "";
    $highlightedString = "";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Regex Tester</title>
</head>

<body>
    <div class="container">
        <h1>Regex Tester</h1>
        <form action="" method="post">
            <section>
                <h2>Regular expression to test</h2>
                <span>/</span> <input type="text" name="regex" value="<?= $regex ?>" /> <span>/</span>
                <input type="checkbox" name="case" id="case">
                <label for="case">Ignore case</label>
            </section>
            <section>
                <h2>String to test</h2>
                <textarea name="string" id="" cols="50" rows="5"><?= $string ?></textarea>
            </section>
            <input type="submit" value="Check" class="button check">
            <input type="submit" name="reset" value="Reset" class="button reset">
        </form>
        <section>
            <?php 
            if ($string) : ?>
                <p class="message">Match : <span class="<?= $messageColor ?>"><?= $message ?></span></p>
                <p class="message"><?= $highlightedString ?></p>
            <?php endif; ?>
        </section>
    </div>
</body>

</html>