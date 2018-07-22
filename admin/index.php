<?php
ob_start(); // Output Buffering Start
session_start();

$noNavbar = " ";

include 'system/ini.php';

if (isset($_SESSION['Username'])) {

    header('Location: dashboard.php');

} 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $username   = $_POST['Username']; 
    
    $password   = $_POST['Password'];
    
    $hashPass   = md5($password);
    
    $stmt       = $con->prepare('SELECT *  FROM user 
                                            WHERE
                                                Username = ?
                                            AND 
                                                Password = ?
                                            AND 
                                                GroupID = 1
                                            LIMIT 1');
    
    $stmt->execute(array($username, $hashPass));
    
    $row        = $stmt->fetch();
    
    $cont       = $stmt->rowCount();

    echo $cont . " " .  $username . "  " . $hashPass;

    if ($cont > 0) {

        $_SESSION['Username']   = $username;

        $_SESSION['UserID']     = $row['UserID'];

        $_SESSION['Name']       = $row['Fullname'];

        header('Location: dashboard.php');
    }

    
    
}


?>

    <div class="container">
        
        <form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
            
            <h2>Admin Panel</h2>
            
            <div class="row">
            
                <div class="col-md-offset-4 col-md-4">
                    
                    <form class="form-inline">
                        
                        <div class="form-group">
                            
                            <input type="text" class="form-control" name="Username" placeholder="User">
                            
                        </div>
                        
                        <div class="form-group">
                            
                            <input type="password" class="form-control" name="Password" placeholder="Password">
                            
                        </div>
                        
                        <div class="form-group text-center">
                            
                            <input id="checkAdmin" type="checkbox"> <label for="checkAdmin">This Page For Admin Only</label>
                            
                        </div>
                        
                      <input type="submit" value="login" class="btn btn-default">
                        
                    </form>
                    
                </div>
                
            </div>
            


        </form>
        
    </div>

<?php

include $foldertemp . 'footer.php';

ob_end_flush(); // Release The Output