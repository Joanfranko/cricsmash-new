<?php
namespace App\Http\Helpers;

use App\Models\User;
use Validator;

class Helper {
    public static function getUniqueUserName($modal, $field, $value, $id = '', $i = 0) {
        static $actualValue;
        if ($i == 0) {
            $actualValue = $value;
        }
        $i++;
        $data_id = '';
        if ($modal == 'User') {
            $data = User::where($field, $value)->get();
            if ($data->count() > 0)
                $data_id = User::where($field, $value)->first()->id;
        }

        if (($data->count()) > 0 && $data_id == $id) {
            $result = $value;
        } elseif (($data->count()) > 0) {
            $newValue = $actualValue . '_' . $i;
            $result = Helper::getUniqueUserName($modal, $field, $newValue, $id, $i);
        } else {
            $result = $value;
        }
        return $result;
    }

    public static function checkAdminAccess() {
        /*$currentURL = Request::path();
        if(Auth::user()->role() > 2) {
            $permission = DB::table('admin_menus')
                ->select('admin_menu_access_permission.menu_id', 'admin_menu_access_permission.isAccessible', 'admin_menus.menu_name')
                ->leftJoin('admin_menu_access_permission', 'admin_menu_access_permission.menu_id', '=', 'admin_menus.id')
                ->leftJoin('roles', 'roles.id', 'admin_menu_access_permission.role_id')
                ->where('admin_menus.href', $currentURL)
                ->where('admin_menu_access_permission.role_id', Auth::user()->role())
                ->where('admin_menus.isActive', 1)
                ->where('roles.isActive', 1)
                ->first();
    
            if(!isset($permission) || $permission->isAccessible != 1) {
                abort(403, 'Unauthorized access.');
            }
        }*/
    }

    public static function validateUserRequest($request, $validationRules, $message=[])
    {
        $data['error_string'] = [];
        $data['inputerror'] = [];
        $data['status'] = true;
        $validator = Validator::make($request->all(), $validationRules, $message);
        if ($validator->fails()) {
            $response['status'] = false;
            $response['message'] = 'Validation fails.';
            $message = $validator->messages();

            $data = [];
            foreach ($validationRules as $key => $value) {
                $data['error_string'][] = $message->first($key);
                $data['inputerror'][] = $key;//str_replace('_', '-', $key);
            }
            $response['data'] = $data;
            echo json_encode($response, true);
            exit;
            //return response()->json($data, 406); /406 => Not acceptable/
        }
    }

    //reference: https://stackoverflow.com/questions/12553160/getting-visitors-country-from-their-ip
    public static function getIpInfo($ip, $purpose = "location", $deep_detect = TRUE) {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city"           => @$ipdat->geoplugin_city,
                            "state"          => @$ipdat->geoplugin_regionName,
                            "country"        => @$ipdat->geoplugin_countryName,
                            "country_code"   => @$ipdat->geoplugin_countryCode,
                            "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }
        return $output;
    }

}
?>