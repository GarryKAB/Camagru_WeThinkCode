<?php 
// Put this in your function.php
function connect_db()
{
    try
    {
        $connection = new PDO('mysql:host=localhost;dbname=mydbname', 'myusername', 'mypassword');
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection->setAttribute(PDO::ATTR_PERSISTENT, true);
    }
    catch (PDOException $e)
    {
        // Proccess error
        echo 'Cannot connect to database: ' . $e->getMessage();
    }

    return $connection;
}

// Then include the functions.php in your file and call it
$dbh = connect_db();

// Perform query
// put this inside try/catch to catch the error
// You don't need to prepare statements if you're not inserting input from outside source
$stmt = $dbh->query('SELECT COUNT(*) FROM songlist');
 ?>

  <?php 

//Connections
try {
    $handler = new PDO('mysql:host=localhost;dbname=s','root', '*');
    $handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    exit($e->getMessage());
}

$name = $_POST['name']; 
$username = $_POST['username']; 
$email = $_POST['email'];   
$password = $_POST['password']; 
$password1 = $_POST['passwordconf'];
$ip = $_SERVER['REMOTE_ADDR'];


//Verifcation 
if (empty($name) || empty($username) || empty($email) || empty($password) || empty($password1)){
    $error = "Complete all fields";
}

// Password match
if ($password != $password1){
    $error = "Passwords don't match";
}

// Email validation

if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $error = "Enter a  valid email";
}

// Password length
if (strlen($password) <= 6){
    $error = "Choose a password longer then 6 character";
}

if(!isset($error)){
//no error
$sthandler = $handler->prepare("SELECT username FROM users WHERE username = :name");
$sthandler->bindParam(':name', $username);
$sthandler->execute();

if($sthandler->rowCount() > 0){
    echo "exists! cannot insert";
} else {
    //Securly insert into database
    $sql = 'INSERT INTO userinfo (name ,username, email, password, ip) VALUES (:name,:username,:email,:password,:ip)';    
    $query = $handler->prepare($sql);

    $query->execute(array(

    ':name' => $name,
    ':username' => $username,
    ':email' => $email,
    ':password' => $password,
    ':ip' => $ip

    ));
    }
}else{
    echo "error occured: ".$error;
    exit();
}
  ?>