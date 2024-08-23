<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *     @OA\Schema(
 *         schema="Charge",
 *         type="object",
 *         title="Charge",
 *         @OA\Property(
 *             property="id",
 *             type="string",
 *             example="ch_3PqqvTP8I0NoxkS31D0FtiCs"
 *         ),
 *         @OA\Property(
 *             property="object",
 *             type="string",
 *             example="charge"
 *         ),
 *         @OA\Property(
 *             property="amount",
 *             type="integer",
 *             example=600
 *         ),
 *         @OA\Property(
 *             property="amount_captured",
 *             type="integer",
 *             example=600
 *         ),
 *         @OA\Property(
 *             property="amount_refunded",
 *             type="integer",
 *             example=0
 *         ),
 *         @OA\Property(
 *             property="balance_transaction",
 *             type="string",
 *             example="txn_3PqqvTP8I0NoxkS31qf31fF6"
 *         ),
 *         @OA\Property(
 *             property="billing_details",
 *             type="object",
 *             @OA\Property(
 *                 property="address",
 *                 type="object",
 *                 @OA\Property(property="city", type="string", nullable=true, example=null),
 *                 @OA\Property(property="country", type="string", nullable=true, example=null),
 *                 @OA\Property(property="line1", type="string", nullable=true, example=null),
 *                 @OA\Property(property="line2", type="string", nullable=true, example=null),
 *                 @OA\Property(property="postal_code", type="string", nullable=true, example=null),
 *                 @OA\Property(property="state", type="string", nullable=true, example=null)
 *             ),
 *             @OA\Property(property="email", type="string", nullable=true, example=null),
 *             @OA\Property(property="name", type="string", nullable=true, example=null),
 *             @OA\Property(property="phone", type="string", nullable=true, example=null)
 *         ),
 *         @OA\Property(
 *             property="calculated_statement_descriptor",
 *             type="string",
 *             example="VLADYSLAV BONDARENKO"
 *         ),
 *         @OA\Property(
 *             property="captured",
 *             type="boolean",
 *             example=true
 *         ),
 *         @OA\Property(
 *             property="created",
 *             type="integer",
 *             example=1724394287
 *         ),
 *         @OA\Property(
 *             property="currency",
 *             type="string",
 *             example="usd"
 *         ),
 *         @OA\Property(
 *             property="description",
 *             type="string",
 *             example="first payment using"
 *         ),
 *         @OA\Property(
 *             property="outcome",
 *             type="object",
 *             @OA\Property(property="network_status", type="string", example="approved_by_network"),
 *             @OA\Property(property="risk_level", type="string", example="normal"),
 *             @OA\Property(property="risk_score", type="integer", example=14),
 *             @OA\Property(property="seller_message", type="string", example="Payment complete."),
 *             @OA\Property(property="type", type="string", example="authorized")
 *         ),
 *         @OA\Property(
 *             property="payment_method_details",
 *             type="object",
 *             @OA\Property(
 *                 property="card",
 *                 type="object",
 *                 @OA\Property(property="amount_authorized", type="integer", example=600),
 *                 @OA\Property(property="brand", type="string", example="visa"),
 *                 @OA\Property(
 *                     property="checks",
 *                     type="object",
 *                     @OA\Property(property="address_line1_check", type="string", nullable=true, example=null),
 *                     @OA\Property(property="address_postal_code_check", type="string", nullable=true, example=null),
 *                     @OA\Property(property="cvc_check", type="string", example="pass")
 *                 ),
 *                 @OA\Property(property="country", type="string", example="US"),
 *                 @OA\Property(property="exp_month", type="integer", example=8),
 *                 @OA\Property(property="exp_year", type="integer", example=2025),
 *                 @OA\Property(
 *                     property="extended_authorization",
 *                     type="object",
 *                     @OA\Property(property="status", type="string", example="disabled")
 *                 ),
 *                 @OA\Property(property="fingerprint", type="string", example="dzohzE5PNyA8ymkX"),
 *                 @OA\Property(property="funding", type="string", example="credit"),
 *                 @OA\Property(
 *                     property="incremental_authorization",
 *                     type="object",
 *                     @OA\Property(property="status", type="string", example="unavailable")
 *                 ),
 *                 @OA\Property(property="last4", type="string", example="4242"),
 *                 @OA\Property(
 *                     property="multicapture",
 *                     type="object",
 *                     @OA\Property(property="status", type="string", example="unavailable")
 *                 ),
 *                 @OA\Property(property="network", type="string", example="visa"),
 *                 @OA\Property(
 *                     property="network_token",
 *                     type="object",
 *                     @OA\Property(property="used", type="boolean", example=false)
 *                 ),
 *                 @OA\Property(
 *                     property="overcapture",
 *                     type="object",
 *                     @OA\Property(property="maximum_amount_capturable", type="integer", example=600),
 *                     @OA\Property(property="status", type="string", example="unavailable")
 *                 ),
 *                 @OA\Property(property="three_d_secure", type="string", nullable=true, example=null),
 *                 @OA\Property(property="wallet", type="string", nullable=true, example=null)
 *             ),
 *             @OA\Property(property="type", type="string", example="card")
 *         ),
 *         @OA\Property(
 *             property="receipt_url",
 *             type="string",
 *             example="https://pay.stripe.com/receipts/payment/CAcaFwoVYWNjdF8xUG1yUklQOEkwTm94a1MzKK_WoLYGMgaaCbcTT2k6LBaOOTpwai34YEGstJI4QGB6kmzBdASHqijnpzz-Bhk6k2V6rTYsKfhINwrH"
 *         ),
 *         @OA\Property(
 *             property="status",
 *             type="string",
 *             example="succeeded"
 *         ),
 *         @OA\Property(
 *             property="source",
 *             type="object",
 *             @OA\Property(property="id", type="string", example="card_1PqqvTP8I0NoxkS3RvT2NS6X"),
 *             @OA\Property(property="object", type="string", example="card"),
 *             @OA\Property(property="address_city", type="string", nullable=true, example=null),
 *             @OA\Property(property="address_country", type="string", nullable=true, example=null),
 *             @OA\Property(property="address_line1", type="string", nullable=true, example=null),
 *             @OA\Property(property="address_line1_check", type="string", nullable=true, example=null),
 *             @OA\Property(property="address_line2", type="string", nullable=true, example=null),
 *             @OA\Property(property="address_state", type="string", nullable=true, example=null),
 *             @OA\Property(property="address_zip", type="string", nullable=true, example=null),
 *             @OA\Property(property="address_zip_check", type="string", nullable=true, example=null),
 *             @OA\Property(property="brand", type="string", example="Visa"),
 *             @OA\Property(property="country", type="string", example="US"),
 *             @OA\Property(property="customer", type="string", nullable=true, example=null),
 *             @OA\Property(property="cvc_check", type="string", example="pass"),
 *             @OA\Property(property="dynamic_last4", type="string", nullable=true, example=null),
 *             @OA\Property(property="exp_month", type="integer", example=8),
 *             @OA\Property(property="exp_year", type="integer", example=2025),
 *             @OA\Property(property="fingerprint", type="string", example="dzohzE5PNyA8ymkX"),
 *             @OA\Property(property="funding", type="string", example="credit"),
 *             @OA\Property(property="last4", type="string", example="4242"),
 *             @OA\Property(property="metadata", type="array", @OA\Items(type="string")),
 *             @OA\Property(property="name", type="string", nullable=true, example=null),
 *             @OA\Property(property="tokenization_method", type="string", nullable=true, example=null),
 *             @OA\Property(property="wallet", type="string", nullable=true, example=null)
 *         ),
 *         @OA\Property(
 *             property="source_transfer",
 *             type="string",
 *             nullable=true,
 *             example=null
 *         ),
 *         @OA\Property(
 *             property="transfer_data",
 *             type="object",
 *             nullable=true,
 *             @OA\Property(property="amount", type="integer", example=0),
 *             @OA\Property(property="destination", type="string", nullable=true, example=null)
 *         ),
 *         @OA\Property(
 *             property="transfer_group",
 *             type="string",
 *             nullable=true,
 *             example=null
 *         )
 *     )
 */

class Payment extends Model
{
    use HasFactory;
}
