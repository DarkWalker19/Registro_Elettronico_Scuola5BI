<?php
    session_start();
    
    function get_PDO_connection(){
        //$dbname = 'uvfsyhtv_wp183';
        $dbname = 'registro';
        $dsn = "mysql:dbname=$dbname;host=127.0.0.1";
        //$db_user = 'uvfsyhtv';
        //$db_password = 'LdAD5lxZ@w*172';
        $db_user = 'root';
        $db_password = '';
        
        try{
            $db = new PDO($dsn, $db_user, $db_password);
        } catch(PDOException $e) {
            error("PDO_Exception");
        }
    
        return $db;
    }
    
    function print_metadata(){
        echo "<meta name='author' content='Gruppo 3'>";
        echo "<meta name='lang' content='it'>";
        echo "<meta name='keywords' content='HTML, CSS, JavaScript'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>";
        return;
    }

    function print_header(){
        include "header.php";
        return;
    }

    function print_footer(){
        include "footer.php";
        return;
    }

    function get_css(){
        echo "<link rel='icon' href='./img/logo.png'>";
        echo "<link href='./css/main.css' rel='stylesheet'></link>";
        echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'></link>";
        echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css'/>";
        echo '<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>';
        return;
    }
    
    function check_role($role = ""){
        return $_SESSION['role'] == $role;
    }

    function is_user_logged(){
        if(!isset($_SESSION['user'])) error("user_not_logged_in");
        return;
    }

    function is_user_admin(){
        is_user_logged();
        if(!check_role("admin")) error("user_not_admin");
        return;
    }

    function error($err_type = ""){
        header("Location: err.php?err=" . $err_type);
        exit();
    }

    function generate_captcha($width=150, $height=100){
        $img = imagecreate($width, $height);

        $bg = imagecolorallocate($img, 255, 255, 255);
        $textcolor = imagecolorallocate($img, 0, 0, 0);
        $noise = [
                    imagecolorallocate($img, 200, 200, 200),
                    imagecolorallocate($img, 0, 200, 200),
                    imagecolorallocate($img, 200, 200, 0),
                    imagecolorallocate($img, 200, 0, 200),
                ];

        imagefill($img, 0, 0, $bg);

        $text = random_string(5);
        
        //String -> Img
        imagettftext($img, $height/4, random_int(-18, 18), 20, $height/2, $textcolor, "font/arial.ttf",$text);
        
        //Noises the img
        for($x=0; $x<$width*$height/2; $x++) imagesetpixel($img, random_int(0, $width), random_int(0, $height), $noise[random_int(0, count($noise)-1)]);

        //Capturing img
        ob_start();
        imagepng($img);
        $obContents = ob_get_contents();
        ob_end_clean();
        imagedestroy($img);

        get_css();
        
        echo '<img src="data:image/png;base64,' . base64_encode($obContents) . '" /><br><br>';
        echo "<label for='captcha'>Captcha</label><br>";
        echo "<input class='form-control _input-field' type='text' placeholder='Inserisci Captcha' name='captcha' required></input>";
        return $text;
    }

    function random_string($length){
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charsLength = strlen($chars);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $chars[rand(0, $charsLength - 1)];
        }
        return $randomString;
    }
?>