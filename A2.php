<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="http://fonts.googleapis.com/css?family=Carrois+Gothic" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="A2.css">
    <title>Thanks for your order!</title>
</head>
<body>

<?php
// Define the full name variable
$fullName = filter_input(INPUT_POST, "fullname");

// Define the address variable
$address = filter_input(INPUT_POST, "address");

// Define the city variable
$city = filter_input(INPUT_POST, "city");

// Define the province variable
$province = filter_input(INPUT_POST, "province");

// Define the postal code variable
$postalCode = filter_input(INPUT_POST, "postal");

// Validate the email
$email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);

// Validate the postal code
$postalCodePattern = '/^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/'; 
$postalCodeValidated = filter_input(INPUT_POST, 'postal', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>$postalCodePattern))); 

// Validate the credit card number
$creditCardPattern = '/^\d{10}$/'; 
$creditCardNumberValidated = filter_input(INPUT_POST, 'cardnumber', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>$creditCardPattern))); 

// Define the quantity fields
$quantity1 = filter_input(INPUT_POST, 'qty1', FILTER_VALIDATE_INT); 
$quantity2 = filter_input(INPUT_POST, 'qty2', FILTER_VALIDATE_INT); 
$quantity3 = filter_input(INPUT_POST, 'qty3', FILTER_VALIDATE_INT); 
$quantity4 = filter_input(INPUT_POST, 'qty4', FILTER_VALIDATE_INT); 
$quantity5 = filter_input(INPUT_POST, 'qty5', FILTER_VALIDATE_INT);

// Calculate the total sum
$quantityFields = [
    'iMac' => ['quantity' => $quantity1, 'price' => 1899.99],
    'Razer Mouse' => ['quantity' => $quantity2, 'price' => 79.99],
    'WD HDD' => ['quantity' => $quantity3, 'price' => 179.99],
    'Nexus' => ['quantity' => $quantity4, 'price' => 249.99],
    'Drums' => ['quantity' => $quantity5, 'price' => 119.99],
];

$totalCost = 0;

foreach ($quantityFields as $productName => $item) {
    $quantity = $item['quantity'];
    if ($quantity !== false && $quantity !== null && $quantity >= 0) {
        $totalCost += intval($quantity) * $item['price'];
    }
}

?>

<div class="invoice">
    <?php if($fullName): ?>
        <h1><?= "Thanks for your order $fullName." ?></h1>
    <?php else: ?>
        <h1>Invalid full name.</h1>
    <?php endif ?>

    <h2><?= "Here's a summary of your order:" ?></h2>

    <table class="ainfo">
        <tbody>
            <tr>
                <td colspan="2">Address Information</td>
            </tr>
            <tr>
                <td>Address:</td>
                <?php if($address): ?>
                    <td><?= $address ?></td>
                <?php else: ?>
                    <td>Invalid address.</td>
                <?php endif ?>
            </tr>
            <tr>
                <td>City:</td>
                <?php if($city): ?>
                    <td><?= $city ?></td>
                <?php else: ?>
                    <td>Invalid city.</td>
                <?php endif ?>
            </tr>
            <tr>
                <td>Province:</td>
                <?php if($province): ?>
                    <td><?= $province ?></td>
                <?php else: ?>
                    <td>Invalid province.</td>
                <?php endif ?>
            </tr>
            <tr>
                <td>Postal Code:</td>
                <?php if($postalCode): ?>
                    <td><?= $postalCode ?></td>
                <?php else: ?>
                    <td>Invalid postal code.</td>
                <?php endif ?>
            </tr>
            <tr>
                <td>Email:</td>
                <?php if($email): ?>
                    <td><?= $email ?></td>
                <?php else: ?>
                    <td>Invalid email.</td>
                <?php endif ?>
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <td colspan="3" class="full-width">Order Information</td>
            </tr>
    <tr>
        <td class="bold">Quantity</td>
        <td class="bold">Description</td>
        <td class="bold">Cost</td>
    </tr>
</thead>
<tbody>
    <?php foreach ($quantityFields as $productName => $item): ?>
        <?php if ($item['quantity'] > 0): ?>
            <tr>
                <td><?= $item['quantity'] ?></td>
                <td><?= $productName ?></td>
                <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
            </tr>
        <?php endif ?>
    <?php endforeach; ?>
</tbody>
<tfoot>
    <tr>
        <td colspan="2" class="bold">Total Cost</td>
        <td>$<?= number_format($totalCost, 2) ?></td>
    </tr>
</tfoot>

