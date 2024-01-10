<?php

$myDB = new mysqli('localhost', 'root', '', 'firsttry');

if ($myDB->connect_error) {
    die('Connect Error (' . $myDB->connect_errno . ') ' . $myDB->connect_error);
}

$sql1 = "SELECT * FROM student ORDER BY studentID";
$result = $myDB->query($sql1);

?>

<table cellSpacing="2" cellpadding="6" align="center" border="1">
    <tr>
        <td colspan="4">
            <h3 align="center">Current Students</h3>
        </td>
    </tr>

    <tr>
        <td align="center">ID</td>
        <td align="center">Name</td>
        <td align="center">Email</td>
    </tr>

    <?php

    WHILE ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>";
        // echo stripslashes($row["title"]);
        echo stripslashes($row["studentID"]);
        echo "</td><td align='center'>";
        echo $row["name"];
        echo "</td><td>";
        echo $row["email"];
        echo "</td>";
        echo "</tr>";
    }

    ?>
</table>

</body>
</html>