<?php
    session_start();
    
    function get_PDO_connection(){
        $dbname = 'test';
        $dsn = "mysql:dbname=$dbname;host=127.0.0.1";
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
        echo "<meta name='lang' content='" . isset($_SESSION['lang']) ? $_SESSION['lang'] : 'it' . "'>";
        return;
    }

    function print_header(){
        include "./utils/header.php";
        return;
    }

    function print_footer(){
        include "./utils/footer.html";
        return;
    }

    function get_css(){
        echo "<link rel='icon' href='.\img\logo.jpg'>";
        echo "<link href='./css/main.css' rel='stylesheet'></link>";
        echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'></link>";
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
        if(!check_role("admin")) error("not_admin");
        return;
    }

    function error($params = ""){
        header("Location: error.php?err=" . $params);
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
        
        echo "<label for='captcha'>Captcha</label><br>";
        echo '<img src="data:image/png;base64,' . base64_encode($obContents) . '" /><br>';
        echo "<input type='text' placeholder='Captcha' name='captcha' required>";
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