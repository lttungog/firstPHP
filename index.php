<?php

$myDB = new mysqli('localhost', 'root', '', 'firsttry');

if ($myDB->connect_error) {
    die('Connect Error (' . $myDB->connect_errno . ') ' . $myDB->connect_error);
}

$sql = "SELECT * FROM books WHERE available = 1 ORDER BY title";
$result = $myDB->query($sql);

?>

<table cellSpacing="2" cellpadding="6" align="center" border="1">
    <tr>
        <td colspan="4">
            <h3 align="center">These Books are currently available</h3>
        </td>
    </tr>

    <tr>
        <td align="center">Title</td>
        <td align="center">Year Published</td>
        <td align="center">ISBN</td>
    </tr>

    <?php

    WHILE ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>";
        // echo stripslashes($row["title"]);
        echo stripslashes($row["title"]);
        echo "</td><td align='center'>";
        echo $row["pub_year"];
        echo "</td><td>";
        echo $row["ISBN"];
        echo "</td>";
        echo "</tr>";
    }

    ?>
</table>

</body>
</html>