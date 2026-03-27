<?php
function formatPhoneNumber(string $phoneNumber, string $separator): string
{
    // removing all non-numeric characters
    $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
    // checking if the phone number is valid
    if (strlen($phoneNumber) !== 10) {
        throw new Exception('Invalid phone number');
    }
    // formatting the phone number
    return implode($separator, str_split($phoneNumber, 3));
}
?>
<html>

<body>
    <form method="post">
        <input type="text" name="phoneNumber" placeholder="Phone Number">
        <input type="text" name="separator" placeholder="Separator">
        <button type="submit">Format Phone Number</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $phoneNumber = $_POST['phoneNumber'];
        $separator = $_POST['separator'];
        try {
            echo formatPhoneNumber($phoneNumber, $separator);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    ?>
</body>

</html>