<?php
//fetch datas from the url
if(isset($_GET["transaction_id"]) AND isset($_GET["status"])  AND isset($_GET["tx_ref"])){
    $trans_id = htmlspecialchars($_GET['transaction_id']);
    $trans_status = htmlspecialchars($_GET['status']);
    $trans_ref = htmlspecialchars($_GET['tx_ref']);

    //Verify Endpoint
    $url = "https://api.flutterwave.com/v3/transactions/".$trans_id."/verify";

    //Create cURL session
    $curl = curl_init($url);

    //Turn off SSL checker
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

    //Decide the request that you want
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    
    //Set the API headers
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer FLWSECK_TEST-327372e04bc3fa192ba248b7cbe8ecb4-X",
        "Content-Type: Application/json"
    ]);

    //Run cURL
    $run = curl_exec($curl);

    //Check for erros
    $error = curl_error($curl);
    if($error){
        die("Curl returned some errors: " . $error);
    }
   $result = json_decode($run);

//so now we want to fetch informations
//->we are accesssing informations in an array as object via using json_decode
  $status = $result->data->status;
  $message = $result->message;
  $id = $result->data->id;
  $reference =  $result->data->tx_ref;
  $amount =  $result->data->amount;
  $charged_amount = $result->data->charged_amount;
  $fullName =  $result->data->customer->name;
  $email =  $result->data->customer->email;
  $phone =  $result->data->customer->phone_number;
  //you can echo each out to check the results

  if(($status != $trans_status) OR ($trans_id != $id)){
     header("Location: index.php");
     exit;
  }else{
  }
  curl_close($curl);

}else{
    header("Location: index.php");
     exit; 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DONATION VERIFICATION PAGE</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <h1>Rave Verification Page!</h1>
   <hr>
   <div class="container verify">
    <table>
    <tr>
       <th>Full Name</th>
       <th>Phone Number</th>
       <th>Email</th>
       <th>Transaction Status</th>
       <th>Reference</th>
       <th>Transaction Id</th>
       <th>Amount</th>
       <th>Charged Amount</th>
       </tr>
       <tr>
            <td><?php echo $fullName; ?></td>
            <td><?php echo $phone; ?></td>
            <td><?php echo $email; ?></td>
            <td><?php echo $status; ?></td>
            <td><?php echo $reference; ?></td>
            <td><?php echo $id; ?></td>
            <td><?php echo $amount; ?></td>
            <td><?php echo $charged_amount; ?></td>
       </tr>
    </table>
   </div> 
</body>
</html>