<?php
include_once("../objects/DatabaseHandler.php");
include("../Stripe/lib/StripeObject.php");
include("../Stripe/lib/Error/Base.php");
include("../Stripe/lib/Error/InvalidRequest.php");
include("../Stripe/lib/ApiOperations/Request.php");
include("../Stripe/lib/ApiOperations/Create.php");
include("../Stripe/lib/ApiOperations/Retrieve.php");
include("../Stripe/lib/ApiResource.php");
include("../Stripe/lib/ApiOperations/All.php");
include("../Stripe/lib/ApiOperations/Delete.php");
include("../Stripe/lib/ApiOperations/NestedResource.php");
include("../Stripe/lib/ApiOperations/Update.php");
include("../Stripe/lib/AccountLink.php");
include("../Stripe/lib/AlipayAccount.php");
include("../Stripe/lib/ApplePayDomain.php");
include("../Stripe/lib/ApplicationFee.php");
include("../Stripe/lib/SingletonApiResource.php");
include("../Stripe/lib/BalanceTransaction.php");
include("../Stripe/lib/BankAccount.php");
include("../Stripe/lib/BitcoinReceiver.php");
include("../Stripe/lib/BitcoinTransaction.php");
include("../Stripe/lib/Card.php");
include("../Stripe/lib/Charge.php");
include("../Stripe/lib/CountrySpec.php");
include("../Stripe/lib/Coupon.php");
include("../Stripe/lib/CreditNote.php");
include("../Stripe/lib/Customer.php");
include("../Stripe/lib/Discount.php");
include("../Stripe/lib/Dispute.php");
include("../Stripe/lib/EphemeralKey.php");
include("../Stripe/lib/Event.php");
include("../Stripe/lib/ExchangeRate.php");
include("../Stripe/lib/ApplicationFeeRefund.php");
include("../Stripe/lib/File.php");
include("../Stripe/lib/FileLink.php");
include("../Stripe/lib/Invoice.php");
include("../Stripe/lib/InvoiceItem.php");
include("../Stripe/lib/InvoiceLineItem.php");
include("../Stripe/lib/Issuing/Card.php");
include("../Stripe/lib/Issuing/CardDetails.php");
include("../Stripe/lib/Issuing/Cardholder.php");
include("../Stripe/lib/Issuing/Dispute.php");
include("../Stripe/lib/Issuing/Transaction.php");
include("../Stripe/lib/LoginLink.php");
include("../Stripe/lib/Order.php");
include("../Stripe/lib/OrderItem.php");
include("../Stripe/lib/OrderReturn.php");
include("../Stripe/lib/PaymentIntent.php");
include("../Stripe/lib/PaymentMethod.php");
include("../Stripe/lib/Payout.php");
include("../Stripe/lib/Person.php");
include("../Stripe/lib/Product.php");
include("../Stripe/lib/Plan.php");
include("../Stripe/lib/Radar/ValueList.php");
include("../Stripe/lib/Radar/ValueListItem.php");
include("../Stripe/lib/Recipient.php");
include("../Stripe/lib/RecipientTransfer.php");
include("../Stripe/lib/Refund.php");
include("../Stripe/lib/Reporting/ReportRun.php");
include("../Stripe/lib/Reporting/ReportType.php");
include("../Stripe/lib/Review.php");
include("../Stripe/lib/SKU.php");
include("../Stripe/lib/Sigma/ScheduledQueryRun.php");
include("../Stripe/lib/Source.php");
include("../Stripe/lib/SourceTransaction.php");
include("../Stripe/lib/Subscription.php");
include("../Stripe/lib/SubscriptionItem.php");
include("../Stripe/lib/SubscriptionSchedule.php");
include("../Stripe/lib/SubscriptionScheduleRevision.php");
include("../Stripe/lib/TaxId.php");
include("../Stripe/lib/TaxRate.php");
include("../Stripe/lib/ThreeDSecure.php");
include("../Stripe/lib/Terminal/ConnectionToken.php");
include("../Stripe/lib/Terminal/Location.php");
include("../Stripe/lib/Terminal/Reader.php");
include("../Stripe/lib/Token.php");
include("../Stripe/lib/TopUp.php");
include("../Stripe/lib/Transfer.php");
include("../Stripe/lib/TransferReversal.php");
include("../Stripe/lib/UsageRecord.php");
include("../Stripe/lib/UsageRecordSummary.php");
include("../Stripe/lib/WebhookEndpoint.php");
include("../Stripe/lib/Util/Set.php");
include("../Stripe/lib/Issuing/Authorization.php");
include("../Stripe/lib/IssuerFraudRecord.php");
include("../Stripe/lib/Balance.php");
include("../Stripe/lib/Account.php");
include("../Stripe/lib/Collection.php");
include("../Stripe/lib/Stripe.php");
include("../Stripe/lib/Util/RandomGenerator.php");
include("../Stripe/lib/Util/Util.php");
include("../Stripe/lib/Util/CaseInsensitiveArray.php");
include("../Stripe/lib/HttpClient/ClientInterface.php");
include("../Stripe/lib/HttpClient/CurlClient.php");
include("../Stripe/lib/Util/RequestOptions.php");
include("../Stripe/lib/Util/LoggerInterface.php");
include("../Stripe/lib/Util/DefaultLogger.php");
include("../Stripe/lib/ApiResponse.php");
include("../Stripe/lib/ApiRequestor.php");
include("../Stripe/lib/Checkout/Session.php");
include("../Stripe/lib/WebhookSignature.php");
include("../Stripe/lib/Webhook.php");

\Stripe\Stripe::setApiKey("sk_test_lvBpRxI1ZuzvY2fSRsU9Ppfb");
$endpoint_secret = "whsec_6ef12KlHIWAYI7ATu44ETSx6tdpyFNhh";

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$event = null;

try {
    $event = \Stripe\Webhook::constructEvent(
        $payload, $sig_header, $endpoint_secret
    );
} catch(\UnexpectedValueException $e) {
    // Invalid payload
    http_response_code(400);
    exit();
} catch(\Stripe\Error\SignatureVerification $e) {
    // Invalid signature
    http_response_code(400);
    exit();
}

// Handle the event
switch ($event->type) {
    case 'checkout.session.completed':
        $data = $event->data;
        if($data->object->client_reference_id != null){
            $databaseHandler = new DatabaseHandler();
            $user_data = explode(",", $data->object->client_reference_id);
            $user_id = $user_data[0];
            $shipping = $user_data[1];
            if(isset($user_data[2])){
                $coupon = $user_data[2];
                $result = $databaseHandler->completeTransaction($user_id, "Stripe", $shipping, $coupon);
            }else{
                $result = $databaseHandler->completeTransaction($user_id, "Stripe", $shipping, null);
            }
            echo $result;
        }else{
            print_r($event);
            echo "No client reference id";
        }
        break;
        // ... handle other event types
    default:
        // Unexpected event type
        print_r($event);
        http_response_code(400);
        exit();
}

http_response_code(200);
?>