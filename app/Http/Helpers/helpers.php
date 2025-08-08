<?php

use App\Mail\SendMail;
use App\Models\Advertise;
use App\Models\EmailTemplate;
use App\Models\Extension;
use App\Models\General;
use App\Models\Referral;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

function uploadImage($image, $location, $name = null, $extension = null, $resize = [])
{
    try {
        if ($name) {
            $replaceName = $name;
        } else {
            $replaceName = uniqid() . rand(111, 999);
        }
        if ($extension) {
            $filename = $replaceName . '.' . $extension;
        } else {
            $filename = $replaceName . '.' . $image->getClientOriginalExtension();
        }
        $destination = public_path($location . '/' . $filename);
        $relPath = public_path($location . '/');
        if (!file_exists($relPath)) {
            mkdir($relPath, 777, true);
        }
        $img = \Intervention\Image\Facades\Image::make($image);
        if (count($resize) > 0) {
            $img->resize($resize[0], $resize[1]);
        }
        $img->save($destination);
        return $filename;
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

function Replace($data)
{
    $data = str_replace("'", "", $data);
    $data = str_replace("!", "", $data);
    $data = str_replace("@", "", $data);
    $data = str_replace("#", "", $data);
    $data = str_replace("$", "", $data);
    $data = str_replace("%", "", $data);
    $data = str_replace("^", "", $data);
    $data = str_replace("&", "", $data);
    $data = str_replace("*", "", $data);
    $data = str_replace("(", "", $data);
    $data = str_replace(")", "", $data);
    $data = str_replace("+", "", $data);
    $data = str_replace("=", "", $data);
    $data = str_replace(",", "", $data);
    $data = str_replace(":", "", $data);
    $data = str_replace(";", "", $data);
    $data = str_replace("|", "", $data);
    $data = str_replace("'", "", $data);
    $data = str_replace('"', "", $data);
    $data = str_replace("?", "", $data);
    $data = str_replace("  ", "_", $data);
    $data = str_replace("'", "", $data);
    $data = str_replace(".", "-", $data);
    $data = strtolower(str_replace("  ", "-", $data));
    $data = strtolower(str_replace(" ", "-", $data));
    $data = strtolower(str_replace(" ", "-", $data));
    $data = strtolower(str_replace("__", "-", $data));
    return str_replace("_", "-", $data);
}

function shortCodeReplacer($shortCode, $replace_with, $template_string)
{
    return str_replace($shortCode, $replace_with, $template_string);
}


function tawkto()
{
    $tawkto = Extension::where('act', 'tawkto-chat')->where('status', 1)->first();
    return $tawkto ? $tawkto->generateScript() : '';
}

function fbComment()
{
    $comment = Extension::where('act', 'fb-comment')->where('status', 1)->first();
    return  $comment ? $comment->generateScript() : '';
}

function googleRecaptcha()
{
    $reCaptcha = Extension::where('act', 'google-recaptcha')->where('status', 1)->first();
    return  $reCaptcha ? $reCaptcha->generateScript() : '';
}

function customCaptcha($height = 60, $width = '100%', $bgcolor = '#003', $textcolor = '#abc')
{
    $textcolor = '#' . General::first()->color_code;
    $captcha = Extension::where('act', 'custom-captcha')->where('status', 1)->first();
    if (!$captcha) {
        return 0;
    }
    $code = rand(100000, 999999);
    $char = str_split($code);
    $ret = '<link href="https://fonts.googleapis.com/css?family=Henny+Penny&display=swap" rel="stylesheet">';
    $ret .= '<div style="height: ' . $height . 'px; line-height: ' . $height . 'px; width:' . $width . '; text-align: center; background-color: ' . $bgcolor . '; color: ' . $textcolor . '; font-size: ' . ($height - 20) . 'px; font-weight: bold; letter-spacing: 20px; font-family: \'Henny Penny\', cursive;  -webkit-user-select: none; -moz-user-select: none;-ms-user-select: none;user-select: none;  display: flex; justify-content: center;">';
    foreach ($char as $value) {
        $ret .= '<span style="    float:left;     -webkit-transform: rotate(' . rand(-60, 60) . 'deg);">' . $value . '</span>';
    }
    $ret .= '</div>';
    $captchaSecret = hash_hmac('sha256', $code, $captcha->shortcode->random_key->value);
    $ret .= '<input type="hidden" name="captcha_secret" value="' . $captchaSecret . '">';
    return $ret;
}

function captchaVerify($code, $secret)
{
    $captcha = Extension::where('act', 'custom-captcha')->where('status', 1)->first();
    $captchaSecret = hash_hmac('sha256', $code, $captcha->shortcode->random_key->value);
    if ($captchaSecret == $secret) {
        return true;
    }
    return false;
}

function showAmount($amount, $decimal = 2, $separate = true, $exceptZeros = false)
{
    $separator = '';
    if ($separate) {
        $separator = ',';
    }
    $printAmount = number_format($amount, $decimal, '.', $separator);
    if ($exceptZeros) {
        $exp = explode('.', $printAmount);
        if ($exp[1] * 1 == 0) {
            $printAmount = $exp[0];
        }
    }
    return $printAmount;
}

function dateTime($date, $format = 'd M, Y h:i A')
{
    return date($format, strtotime($date));
}

function slug($string)
{
    return Illuminate\Support\Str::slug($string);
}

function short_text($data, $length)
{
    $first_part = explode(" ", $data);
    $main_part = strip_tags(implode(' ', array_splice($first_part, 0, $length)));
    return $main_part . "....";
}

function str_slug($title = null)
{
    return \Illuminate\Support\Str::slug($title);
}

function urlPath($routeName, $routeParam = null)
{
    if ($routeParam == null) {
        $url = route($routeName);
    } else {
        $url = route($routeName, $routeParam);
    }
    $basePath = route('home');
    $path = str_replace($basePath, '', $url);
    return $path;
}

function createTransaction($message, $amount, $oldBalance, $newBalance, $status, $userID = null, $type = null)
{
    $transId = substr(rand(0000, 9999) . time(), 6);
    if (!is_null($userID)) {
        $me = $userID;
    } else {
        $me = auth()->id();
    }
    if (!is_null($type)) {
        $t = '+';
    } else {
        $t = $type;
    }

    return Transaction::create([
        'user_id' => $me,
        'trans_id' => $transId,
        'description' => $message,
        'amount' => $amount,
        'old_bal' => $oldBalance,
        'new_bal' => $newBalance,
        'status' => $status,
        'type' => $t,
    ]);
}

function getTrx($length = 12)
{
    $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function percent($num_amount, $num_total)
{
    if ($num_total > 0) {
        $count1 = $num_amount / $num_total;
        $count2 = $count1 * 100;
        $count = round($count2);
        return $count;
    } else {
        return 0;
    }
}

function dateSorting($arr)
{
    usort($arr, "dateSort");
    return $arr;
}

function getAmount($amount, $length = 2)
{
    $amount = round($amount, $length);
    return $amount + 0;
}

function curlPostRequestWithHeaders($url, $headers, $postParam = [])
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postParam));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function curlGetRequest($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function showBelowUser($id)
{
    $level = Referral::count();
    $under_ref = User::where('ref_id', $id)->get();
    $print = array();
    $i = 2;
    foreach ($under_ref as $data) {
        $cc = User::where('ref_id', $data->id)->count();
        if ($cc > 0) {
            echo '<ul>';
            echo '<li class="container">';
            echo '<h6 style="color: #0b0b0b; font-weight: bold">' . $print[] =  showBelowUser($data->id) . '</h6>';
            echo '</li>';
            echo '</ul>';
        }
        echo "</li>";
        $i++;
    }
}

function levelCommision($id, $amount)
{
    $usr = $id;
    $i = 1;
    $level = Referral::count();
    while ($usr != "" || $usr != "0" || $i < $level) {
        $me = User::find($usr);
        $user = User::find($me->ref_id);
        if ($user == "") {
            break;
        }
        $comission = Referral::where('id', $i)->first();
        $com = ($amount * $comission->percentage) / 100;
        $new_bal = $user->balance + $com;
        $user->balance = $new_bal;
        createTransaction('Congratulation, You Got ' . $i . ' Level Referral Commission from ' . $user->name, $com, $user->balance, $new_bal, 5, $user->id);
        $user->save();
        $general = General::first();
        $shortCodes = [
            'amount' => $amount,
            'post_balance' => $new_bal,
            'level' => $i,
            'currency' => $general->currency,
        ];
        @send_email($user, "REFERRAL_COMMISSION", $shortCodes);
        $usr = $user->id;
        $i++;
    }
    return 0;
}

function curl_get_file_contents($url)
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, $url);
    $contents = curl_exec($c);
    curl_close($c);

    if ($contents) return $contents;
    else return FALSE;
}


function send_email($user, $type, $shortCodes = null)
{
    $general = General::first();
    $config = $general->email_configuration;

    $emailTemplate = EmailTemplate::where('act', $type)->where('email_status', 1)->first();
    if (!$emailTemplate) {
        return;
    }

    $message = shortCodeReplacer("{{name}}", $user->name, $general->email_body);
    $message = shortCodeReplacer("{{message}}", $emailTemplate->email_body, $message);

    if (empty($message)) {
        $message = $emailTemplate->email_body;
    }

    foreach ($shortCodes as $code => $value) {
        $message = shortCodeReplacer('{{' . $code . '}}', $value, $message);
    }

    if ($config->name == 'smtp') {

        if ($type == 'contact-mail') {
            sendSmtpMail($config, $user->email, $user->name, $user->subject, $user->message, $general);
        } else {
            sendSmtpMail($config, $user->email, $user->name, $emailTemplate->subj, $message, $general);
        }
    } else {
        $headers = "From: $general->web_name <$general->sender_email> \r\n";
        $headers .= "Reply-To: $user->name <$user->email> \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        @mail($user->email, $emailTemplate->subj, $message, $headers);
    }
}

function sendSmtpMail($config, $receiver_email, $receiver_name, $subject, $message, $general)
{
    try {
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = $config->smtp_host;
        $mail->SMTPAuth = true;
        $mail->Username = $config->smtp_username;
        $mail->Password = $config->smtp_password;
        $mail->SMTPSecure = $config->smtp_encryption;
        $mail->Port = intval($config->smtp_port);
        $mail->setFrom($general->sender_email, @$general->web_name);
        $mail->addAddress($receiver_email, $receiver_name);
        $mail->addReplyTo($general->sender_email, @$general->web_name);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->send();
    } catch (Exception $e) {
        throw new Exception($e);
    }
}

function getIpInfo()
{
    $ip = $_SERVER["REMOTE_ADDR"];

    //Deep detect ip
    if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }


    $xml = @simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" . $ip);


    $country = @$xml->geoplugin_countryName;
    $city = @$xml->geoplugin_city;
    $area = @$xml->geoplugin_areaCode;
    $code = @$xml->geoplugin_countryCode;
    $long = @$xml->geoplugin_longitude;
    $lat = @$xml->geoplugin_latitude;

    $data['country'] = $country;
    $data['city'] = $city;
    $data['area'] = $area;
    $data['code'] = $code;
    $data['long'] = $long;
    $data['lat'] = $lat;
    $data['ip'] = request()->ip();
    $data['time'] = date('d-m-Y h:i:s A');

    return $data;
}

function osBrowser()
{
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $osPlatform = "Unknown OS Platform";
    $osArray = array(
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );
    foreach ($osArray as $subex => $value) {
        if (preg_match($subex, $userAgent)) {
            $osPlatform = $value;
        }
    }
    $browser = "Unknown Browser";
    $browserArray = array(
        '/msie/i' => 'Internet Explorer',
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/edge/i' => 'Edge',
        '/opera/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i' => 'Handheld Browser'
    );
    foreach ($browserArray as $subex => $value) {
        if (preg_match($subex, $userAgent)) {
            $browser = $value;
        }
    }

    $data['os_platform'] = $osPlatform;
    $data['browser'] = $browser;

    return $data;
}

function print_advertise($add_type, $image_type = null, $limit = 1)
{
    if ($add_type == 'script') {
        $ad = Advertise::whereNotNull('script')->inRandomOrder()->limit($limit)->get();
    } else {
        // leaderboard, large-Leaderboard, square, small-square, medium-rectangle, rectangle
        if (is_null($image_type)) {
            $image_type = 'square';
        }
        $ad = Advertise::whereNull('script')->where('image_type', $image_type)->inRandomOrder()->limit($limit)->get();
    }

    $html = '';
    foreach ($ad as $data) {
        $html .= '<div class="widget widget_add">
        <div class="add-inner">
        <a class="thumb" href="' . $data->image_redirect_url . '"><img src="' . asset('public/images/advertise/' . $data->image) . '" alt="' . $data->image_type . '"></a>
        </div>
    </div>';
    }
    return $html;
}
