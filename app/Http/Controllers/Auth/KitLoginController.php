<?php
namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class KitLoginController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    

    function kit(){
			$app_id = '1461990380583214';
			$secret = '101867770748e047f062da3daa12525b';
			$version = 'v1.1'; // 'v1.1' for example

        function doCurl($url) {
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $data = json_decode(curl_exec($ch), true);
          curl_close($ch);
          return $data;
        }

        $token_exchange_url = 'https://graph.accountkit.com/'.$version.'/access_token?'.
          'grant_type=authorization_code'.
          '&code='.$_POST['code'].
          "&access_token=AA|$app_id|$secret";
        $data = doCurl($token_exchange_url);
        $user_id = $data['id'];
        $user_access_token = $data['access_token'];
        $refresh_interval = $data['token_refresh_interval_sec'];
        
        // Get Account Kit information
        $me_endpoint_url = 'https://graph.accountkit.com/'.$version.'/me?'.
          'access_token='.$user_access_token;
        $data = doCurl($me_endpoint_url);
        echo $phone = isset($data['phone']) ? $data['phone']['number'] : '';
        echo $email = isset($data['email']) ? $data['email']['address'] : '';
    }
}