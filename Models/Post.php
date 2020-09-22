<?php

require './DbConnection.php';

try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
$Post = new Post();

if(method_exists($Post, 'store')){
    $Post->store();
}


class Post
{
    
    
    public function store(){

        $url = "https://jsonplaceholder.typicode.com/users";

        //  Initiate curl
$ch = curl_init();
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// Execute
$result=curl_exec($ch);
// Closing
curl_close($ch);



$res = file_get_contents($url);
// Will dump a beauty json :3
$users = json_decode($res, true);

foreach($users as $user){
    $id = $user['id'];
    $name = $user['name'];
    $email = $user['email'];
    $insert_user = $conn->prepare('INSERT INTO users (id, name, email, created_at, updated_at) VALUES (:id, :name, :email,now(), now())');

    $insert_user->execute(array(
        ':id' => $id,
        ':name' => $name,
        ':email' => $email));


    print_r([$id, $name, $email]);

}

       }

}