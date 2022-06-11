<?php
if(isset($_POST['donate'])) {
    $fullname=htmlspecialchars($_POST['fullname']);
    $email=htmlspecialchars($_POST['email']);
    $phone=htmlspecialchars($_POST['phone']);
    $amount=htmlspecialchars($_POST['amount']);


//Integrate the endpoint from the flutterwave standard page
$endpoint = "https://api.flutterwave.com/v3/payments";

//Get datas from users
$get_datas=[
    "tx_ref"=>uniqid().uniqid().uniqid(),
    "Currency"=>"NGN",
    "Amount"=>$amount,
    "Donators"=> [
        "name"=>$fullname,
        "email"=>$email,
        "phone"=>$phone
    ],
    "Customizations"=> [
        "title"=>"Donations to the less priviledged!!!",
        "description"=>"A page to collection donations to support less privilegde"
    ],
    "meta"=> [
        "purpose" => "To help the poor!",
        "address" => "Ife city,Osun state"
    ],
    "redirected_url"=>"http://localhost/flutterwave/verify.php"
];


//curl init
$set=curl_init();

//turn off the ssl checking
curl_setopt($set, CURLOPT_SSL_VERIFYPEER, 0);

//Turn on the cURL post method
curl_setopt($set, CURLOPT_POST, 1);

//json_encode will take the informations as an array
curl_setopt($set, CURLOPT_POSTFIELDS, json_encode($get_datas));

//Make it reurn data
curl_setopt($set, CURLOPT_RETURNTRANSFER, true);

//Set the connection timeout
curl_setopt($set, CURLOPT_CONNECTTIMEOUT, 200);

//Set the headers from endpoint
//we login to our dashboard
curl_setopt($set, CURLOPT_HTTPHEADER, array(
   "Authorization: Bearer FLWSECK_TEST-327372e04bc3fa192ba248b7cbe8ecb4-X",
   "Content-Type: Application/json",
   "Cache-Control: no-cahe"
));

//Execute the cURL session
$execute = curl_exec($set);

//covert the datas to object
$result = json_decode($execute);

header("Location: ". $result);

//Close the cURL session
curl_close($set);

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DONATION PAGE</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <nav>
                <header>DW</header>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <div class="edit-donate-list"><li><a href="#">Donate</a></li></div>
                </ul>
            </nav>
        </div>

       <div class="form-container">
        <div class="form">
            <form method="POST">
                <h1>Donate Today</h1>
                <input type="text" name="fullname" placeholder="Enter your fullname" required /> <br>
                <input type="email" name="email" placeholder="Email"  required/> <br>
                <input type="phone" name="phone" placeholder="Phone"  required/> <br>
                <input type="number" name="amount" required placeholder="Enter the Amount you want to donate" />
                <a href=""><button type="submit" name="donate"  required value="submit">Donate</button></a>
            </form>
       </div>
       <div class="options">
            <div class="optiona"></div>
            <div class="optionb"></div>
            <div class="optionc"></div>
        </div>


        </div>
    </div>
</body>
</html>