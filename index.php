<!DOCTYPE HTML>
<html>
<head>
    <title>Problem Solving PHP</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="sudoku">
    <div class="inline">
        <h3>SUDOKU</h3>
        <?php
        require('./sudoku.php');
        $sudoku = new sudoku();

        if (!empty($_POST)) {
            echo "<form>";
            $sudoku->checkSolution();
            echo "<br>";
            echo '<input type="submit" value="Reset">';
            echo '</form>';



        } else {
            echo "<form method=\"post\">";
            $sudoku = new fourdoku();
            $sudoku->generate();
            $sudoku->print();
            echo "<br>";
            echo "<input type=\"submit\">";
            echo "</form>";
        }
        ?>
    </div>
</div>
</body>
</html>