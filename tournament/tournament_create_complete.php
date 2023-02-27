<?php
session_start();

include '../includes/verify_login.php';
include '../includes/verify_stripe.php';

// Create a product in stripe, product name should be tournament name
require_once("D:\home\site/vendor/stripe-php/init.php"); // Replace with the correct path to your Stripe API library

$stripe = new \Stripe\StripeClient('sk_test_51HMmoLF7Rh0QhVJAi7DlBltAvSppNdpnEkTZo7pcd2fxbF5yCFUcAHVbjpvnXKJGdpa8Qf4jRvMJfPvTvCEOvNBW00fFAWPecn');

$image = array($_SESSION['urls']);

// create a product in stripe for an onboarded account: $_SESSION['stripeConnectedID']
$product = $stripe->products->create([
    'name' => $_SESSION['tournament_name'],
    'description' => $_SESSION['tournament_description'],
    'images' => $image,
    'metadata' => [
        'club_id' => $_SESSION['club_id'],
        'min_skill_level' => $_SESSION['min_skill_level'],
        'max_skill_level' => $_SESSION['max_skill_level'],
        'address' => $_SESSION['address'],
        'tournament_prices' => json_encode($_SESSION['tournament_prices']),
        'selected_format' => $_SESSION['selected_format'],
        'mens_doubles' => $_SESSION['mens_doubles'],
        'womens_doubles' => $_SESSION['womens_doubles'],
        'mixed_doubles' => $_SESSION['mixed_doubles'],
        'mens_singles' => $_SESSION['mens_singles'],
        'womens_singles' => $_SESSION['womens_singles'],
        'mens_skinny_singles' => $_SESSION['mens_skinny_singles'],
        'womens_skinny_singles' => $_SESSION['womens_skinny_singles'],
        'prizes' => json_encode($_SESSION['prizes']),
    ],
], [
    'stripe_account' => $_SESSION['stripeConnectedID']
]);

$prices = $_SESSION['tournament_prices'];

foreach ($prices as $key => $price_arr) {
    $price = $price_arr['price'];
    $quantity = $_SESSION['tournament_details'][$key]['detail'];
    // make sure price and quantity are numbers
    $price = floatval($price);
    $quantity = intval($quantity);
    // convert price to cents and make it an integer
    $price = intval($price * 100);
    $price_obj = $stripe->prices->create([
        'unit_amount' => $price,
        'currency' => 'usd',
        'product' => $product->id,
        'metadata' => [
            // price details
            'quantity' => $quantity,
        ],
    ], [
        'stripe_account' => $_SESSION['stripeConnectedID']
    ]);
}





?>
