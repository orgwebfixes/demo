<?php
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Arr;


/**
 *
 * @param type $change_dropdown
 * @param type $replace_dropdown
 * @param type $url
 * @param type $empty
 * @return string
 */
if (!function_exists('ajax_fill_dropdown')) {
    function ajax_fill_dropdown($change_dropdown, $replace_dropdown, $url, $empty = [])
    {
        $html = '<script type="text/javascript">';

        $html .= 'jQuery(document).ready(function($) {';
        $html .= 'jQuery("select[name=\'' . $change_dropdown . '\']").change(function(e){';
        $html .= 'jQuery.ajax({';
        $html .= 'type: "POST",';
        $html .= 'url: "' . $url . '",';
        $html .= 'dataType:"json",';
        $html .= 'data: jQuery(this).parents("form").find("input:not(:hidden),select").serialize(),';
        $html .= 'success:function(data){';
        $html .= 'jQuery("select[name=\'' . $replace_dropdown . '\']").find("option:not(:first)").remove();';
        if (!empty($empty)) {
            foreach ($empty as $key => $emt) {
                $html .= '    jQuery("select[name=\'' . $emt . '\']").find("option:not(:first)").remove();';
            }
        }
        $html .= '    jQuery.each(data, function(key,value){';
        $html .= '        jQuery("select[name=\'' . $replace_dropdown . '\']").append(\'<option value="\'+key+\'">\'+value+\'</option>\');';
        $html .= '});';
        $html .= '}';
        $html .= '});';
        $html .= '});';
        $html .= '});';
        $html .= '</script>';
        return $html;
    }
}

if (!function_exists('array_get')) {
    /**
     * Get an item from an array using "dot" notation.
     *
     * @param  array   $array
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function array_get($array, $key, $default = null)
    {
        return Arr::get($array, $key, $default);
    }
}

if (!function_exists('CheckHoursDiff')) {
    /**
     * Check houtres Diffrence
     *
     * @param  date   $created_at
     * @return mixed
     */
    function CheckHoursDiff($created_at)
    {
        $user = Sentinel::getUser();
        if (Carbon::now()->diffInHours($created_at) < \Config::get('srtpl.settings.edit_past_entry_time', 12) || $user->hasAccess(['settings.allow_past_enrty_edit'])) {
            return true;
        }
        return false;
    }
}
if (!function_exists('getUserName')) {
    /**
     * Check houtres Diffrence
     *
     * @param  date   $created_at
     * @return mixed
     */
    function getUserName($user_id)
    {
        if ($user_id) {
            $user = User::select([DB::raw('users.name as user_name')])->where('id', $user_id)->first();
            return ($user) ? $user->user_name : '';
        }

        return '';
    }
}
if (!function_exists('ageofRecord')) {
    /**
     * Check houtres Diffrence
     *
     * @param  date   $created_at
     * @return mixed
     */
    function ageofRecord($date, $todate = null)
    {
        $todate = !empty($todate) ? $todate : Carbon::now();
        $diff = Carbon::parse($date)->diffInDays($todate);
        return $diff . ' Day';
    }
}

/**
 *
 * @param type $type
 * @param type $base64
 * @param type $alt
 * @param array $attributes
 * @return type
 */
if (!function_exists('imgBase64')) {
    function imgBase64($type, $base64, $alt = null, $attributes = [])
    {
        $attributes['alt'] = $alt;
        $attrib = '';
        if (!empty($attributes)) {
            foreach ($attributes as $key => $value) {
                $attrib .= ' ' . $key . '="' . $value . '"';
            }
        }
        return '<img src="' . $type . ';base64,' . $base64 . '"' . $attrib . '>';
    }
}

/**
 *
 * @param type $code
 * @param type $density
 * @param type $top_txt
 * @param type $is_bottom_code
 * @return type
 */
function code128BarCode($code, $density = 1, $top_txt = 'PRODUCT', $is_bottom_code = true)
{
    $CODE128A_START_BASE = 103;
    $CODE128B_START_BASE = 104;
    $CODE128C_START_BASE = 105;
    $STOP = 106;

    //Creates an array for alphanumeric codes
    //Formatted as numerical representations of "B S B S B S", where B is the number of lines and S is the number of spaces

    $code128_bar_codes = [
        212222, 222122, 222221, 121223, 121322, 131222, 122213, 122312, 132212, 221213, 221312, 231212, 112232, 122132, 122231, 113222, 123122, 123221, 223211, 221132, 221231,
        213212, 223112, 312131, 311222, 321122, 321221, 312212, 322112, 322211, 212123, 212321, 232121, 111323, 131123, 131321, 112313, 132113, 132311, 211313, 231113, 231311,
        112133, 112331, 132131, 113123, 113321, 133121, 313121, 211331, 231131, 213113, 213311, 213131, 311123, 311321, 331121, 312113, 312311, 332111, 314111, 221411, 431111,
        111224, 111422, 121124, 121421, 141122, 141221, 112214, 112412, 122114, 122411, 142112, 142211, 241211, 221114, 413111, 241112, 134111, 111242, 121142, 121241, 114212,
        124112, 124211, 411212, 421112, 421211, 212141, 214121, 412121, 111143, 111341, 131141, 114113, 114311, 411113, 411311, 113141, 114131, 311141, 411131, 211412, 211214,
        211232, 23311120
    ];

    //Get the width and height of the barcode
    //Determine the height of the barcode, which is >= .5 inches

    $width = (((11 * strlen($code)) + 35) * ($density / 72)); // density/72 determines bar width at image DPI of 72
    $height = ($width * .15 > .7) ? $width * .15 : .7;

    $px_width = round($width * 72);
    //$px_height = ($height * 72);
    $px_height = ($height * 64);
    $font_height = 0;
    $top_font_height = 0;
    if ($is_bottom_code) {
        // Font Size
        $font = 3;
        $font_width = imagefontwidth($font);
        $font_height = imagefontheight($font);
    }
    if (!empty($top_txt)) {
        $top_font = 2;
        $top_font_width = imagefontwidth($top_font);
        $top_font_height = imagefontheight($top_font);
    }
    //Create a true color image at the specified height and width
    //Allocate white and black colors

    $img = imagecreatetruecolor($px_width, $px_height + $font_height);
    $white = imagecolorallocate($img, 255, 255, 255);
    $black = imagecolorallocate($img, 0, 0, 0);

    //Fill the image white
    //Set the line thickness (based on $density)

    imagefill($img, 0, 0, $white);
    imagesetthickness($img, $density);

    //Create the checksum integer and the encoding array
    //Both will be assembled in the loop

    $checksum = $CODE128B_START_BASE;
    $encoding = [$code128_bar_codes[$CODE128B_START_BASE]];

    //Add Code 128 values from ASCII values found in $code

    for ($i = 0; $i < strlen($code); $i++) {
        //Add checksum value of character

        $checksum += (ord(substr($code, $i, 1)) - 32) * ($i + 1);

        //Add Code 128 values from ASCII values found in $code
        //Position is array is ASCII - 32

        array_push($encoding, $code128_bar_codes[(ord(substr($code, $i, 1))) - 32]);
    }

    //Insert the checksum character (remainder of $checksum/103) and $STOP value

    array_push($encoding, $code128_bar_codes[$checksum % 103]);
    array_push($encoding, $code128_bar_codes[$STOP]);

    //Implode the array as string

    $enc_str = implode($encoding);

    //Assemble the barcode

    for ($i = 0, $x = 0, $inc = round(($density / 72) * 100); $i < strlen($enc_str); $i++) {
        //Get the integer value of the string element

        $val = intval(substr($enc_str, $i, 1));

        //Create lines/spaces
        //Bars are generated on even sequences, spaces on odd

        for ($n = 0; $n < $val; $n++, $x += $inc) {
            if ($i % 2 == 0) {
                imageline($img, $x, 0 + $top_font_height, $x, $px_height, $black);
            }
        }
    }
    //top text
    if (!empty($top_txt)) {
        $top_text_width = $top_font_width * strlen($top_txt);

        // Position to align in center
        $top_position_center = ceil(($px_width - $top_text_width) / 2);
        imagestring($img, $top_font, $top_position_center, 0, $top_txt, $black);
    }
    //bottom text
    if ($is_bottom_code) {
        /*
          -----------
          Text Width
          -----------
         */

        $text_width = $font_width * strlen($code);

        // Position to align in center
        $position_center = ceil(($px_width - $text_width) / 2);

        /*
          -----------
          Text Height
          -----------
         */

        $text_height = $font_height;

        /*
          -----------------
          Write the string
          -----------------
         */

        imagestring($img, $font, $position_center, $px_height, $code, $black);
    }
    //imagestring($img, 5, 10, $px_height, $code, $black);
    //Return the image
    ob_start();
    imagepng($img);
    //Get the image from the output buffer
    $img_src = ob_get_clean();
    return base64_encode($img_src);
}
function statusHelper($status = 'default')
{
    switch ($status) {
        case 'success':
            $result = '<i class="color-success fa fa-check-circle" aria-hidden="true"></i>';
            return $result;
            break;
        case 'default':
            $result = '<i class="color-default fa fa-meh-o" aria-hidden="true"></i>';
            return $result;
            break;
        case 'notice':
            $result = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>';
            return $result;
            break;
        case 'error':
            $result = '<i class="color-error fa fa-exclamation-circle" aria-hidden="true"></i>';
            return $result;
            break;
        case 'info':
            $result = '<i class="color-info fa fa-info-circle" aria-hidden="true"></i>';
            return $result;
            break;
        default:
            $result = '<i class="color-success fa fa-smile-o" aria-hidden="true"></i>';
            return $result;
            break;
    }
}
function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
