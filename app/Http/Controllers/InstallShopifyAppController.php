<?php

namespace App\Http\Controllers;

use App\Affiliate;
use Illuminate\Http\Request;
use App\Store;
use DB;
use View;

class InstallShopifyAppController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }


    public function adminIndex()
    {
        die("HERE");
    }

    public function install(Request $request){
        $shop = $request->shop;
        $str = str_replace(".myshopify.com","",$shop);
        $data_count = DB::table('stores')->where('shopname', $str)->get()->count();
        if($data_count>0){
            //die("THJERE");
            $access_token = DB::table('stores')->where('shopname', $str)->value('token');
            $shop_id = DB::table('stores')->where('shopname', $str)->value('id');
            $shop_ = $shop;
            $this->adminView($shop_id);
        }else{
            $shop          = "store.myshopify.com";
            $api_key       = env('SHOPIFY_API_KEY');
            $shared_secret = env('SHOPIFY_SECRET_KEY');
            $scopes        = "read_content,write_content,read_themes,write_themes,read_products,write_products,read_product_listings,read_customers,write_customers,read_orders,write_orders,read_script_tags,write_script_tags,read_checkouts,write_checkouts,read_shipping,write_shipping,unauthenticated_read_product_listings,unauthenticated_write_checkouts,unauthenticated_write_customers,unauthenticated_read_customer_tags";
            $redirect_uri  = env('APP_URL').'/generate-token-app';
            // Build install/approval URL to redirect to
            $install_url = "https://" . $shop . "/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);
            return redirect($install_url);
        }
    }


    public function generateToken(Request $request){
        $api_key       = env('SHOPIFY_API_KEY');
        $shared_secret = env('SHOPIFY_SECRET_KEY');
        $params        = $_GET;
        $hmac          = $_GET['hmac'];

        $params = array_diff_key($params, array('hmac' => ''));
        ksort($params);
        $computed_hmac = hash_hmac('sha256', http_build_query($params), $shared_secret);
        if (hash_equals($hmac, $computed_hmac)) {
            $query = array(
                "client_id" => $api_key,
                "client_secret" => $shared_secret,
                "code" => $params['code']
            );
            $access_token_url = "https://" . $params['shop'] . "/admin/oauth/access_token";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $access_token_url);
            curl_setopt($ch, CURLOPT_POST, count($query));
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
            $result = curl_exec($ch);
            curl_close($ch);

            // Store the access token
            $result       = json_decode($result, true);
            $access_token = $result['access_token'];
            $shop      = $_GET['shop'];
            $shopname  = strtok($shop, '.');

            /********************* save access token ****************/
            $store     = Store::where('shopname', $shopname)->first();
            if(!$store){
                $store = new Store;
            }
            $store->shopname = $shopname;
            $store->token    = $access_token;
            $store->save();
            $redirect_url = "https://".$shopname.".myshopify.com/admin/apps/".env('SHOPIFY_APP_NAME');

            return redirect($redirect_url);
        }else{
           die('Error:: Invalid Request');
        }
    }

    public function adminView($shop_id){
        $users = DB::table('users')->get();
        $approved_users = DB::table('users')->where('referral_status','approved')->get();
        $rejected_users = DB::table('users')->where('referral_status','rejected')->get();
        $pending_users = DB::table('users')->where('referral_status','pending')->get();
        foreach ($users as $user){
            $affiliate = Affiliate::where('shopify_user_id',$user->shopify_user_id)->first();
            $user->affiliater = $affiliate->name;
        }

        foreach ($approved_users as $user){
            $affiliate = Affiliate::where('shopify_user_id',$user->shopify_user_id)->first();
            $user->affiliater = $affiliate->name;
        }

        foreach ($rejected_users as $user){
            $affiliate = Affiliate::where('shopify_user_id',$user->shopify_user_id)->first();
            $user->affiliater = $affiliate->name;
        }

        foreach ($pending_users as $user){
            $affiliate = Affiliate::where('shopify_user_id',$user->shopify_user_id)->first();
            $user->affiliater = $affiliate->name;
        }
        $store = Store::find($shop_id);
        $affiliate_users = Affiliate::get();
        $credits = DB::table('credits')->get();
        $commissions = DB::table('commissions')->get();
        echo  View::make('app_connected',['users' =>$users, 'approved_users'=>$approved_users, 'pending_users'=>$pending_users, 'rejected_users'=>$rejected_users ,'affiliate'=>$affiliate,'store'=>$store,'affiliate_users'=>$affiliate_users, 'credits' => $credits, 'commissions' => $commissions]);
    }

    public function update_panel(Request $request){
        $store = Store::find($request->shop_id);
        $store->panel_text = $request->affiliate_panel_text;
        $store->save();
        $this->adminView($request->shop_id);
    }

    public function updateCustomerTag(Request $request){
        //echo"<pre>"; print_r($request->all());   die;
        $shopify_user_id = $request->id_;
        $status = $request->status_;
        if(!empty($shopify_user_id) && !empty($status)){
            if($status == 'enable'){
                $tags = 'affiliate';  
            }else{
                $tags = '';
            }
            $customerUrl = 'https://store.myshopify.com/admin/api/2021-01/customers/'.$shopify_user_id.'.json';
            $result = $this->cURlupdateTag($customerUrl,$tags,$shopify_user_id);
            if($result)
            {   
                $update_affiliate = DB::table('affiliate')
                    ->where('shopify_user_id', $shopify_user_id)
                    ->limit(1)
                    ->update(array('tags' => $tags));  
               
                return response()->json([
                    'success' => true,
                    'message' => 'Tags have been updated successfully',
                    'data' => $result
                ], 200);
            }
            else
            {
               return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong.',
                    'data' => 'Data'
                ], 200);

            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'data' => 'Data'
            ], 200);
        }
    }



    /****************************
        updating tag
    *************************** */
    public function cURlupdateTag($customerUrl,$tags,$shopify_user_id){
        $data = array();
        $data['id'] = $shopify_user_id;
        $data['tags'] = $tags;
        $customer['customer'] = $data;
        $customer_encode = json_encode($customer);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$customerUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $customer_encode);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $header = array(
            'Content-Type: application/json',
            'X-Shopify-Access-Token: token'
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $server_output = curl_exec ($ch);
        $result = json_decode($server_output);
        return $result;
    }



    public function seachCustomerCURL($seach_Url){
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $seach_Url,
            CURLOPT_USERAGENT => 'Codular Sample cURL Request'
        ]);
        $resp = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($resp, true);
        return $result;
    }

    public function uploadImage(Request $request){
        //echo"<pre>"; print_r($request->all()); die;
        $affiliate = Affiliate::where('shopify_user_id',$request->shopify_user_id)->get()->count();
        if(!empty($request->shopify_user_id) && $affiliate > 0){
            
            if ($request->hasFile('file')) {
                $image = $request->file('file');
                $name = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('images/affiliate/',$name);
                $image->move($destinationPath, $name);
                \DB::table('affiliate')->where('shopify_user_id',$request->shopify_user_id)->update([
                    'image' => $name,
                ]);
            }
            \DB::table('affiliate')->where('shopify_user_id',$request->shopify_user_id)->update([
               'vehicle_info' => $request->vehicle_info,
            ]);
            $msg = 'Data have been updated successfully';
            return response()->json($msg); 
        }else{
            $msg = 'No data found.';
            return response()->json($msg);
        }  
    }

    public function affiliateReferral($id){
        $users = DB::table('users')->where('shopify_user_id',$id)->get();
        if($users->count() > 0){
            foreach ($users as $user){
                $affiliate = Affiliate::where('shopify_user_id',$user->shopify_user_id)->first();
                $user->affiliater = $affiliate->name;
            }
            echo  View::make('referrals',['users' =>$users]);
        }else{
            $users = array();
            echo  View::make('referrals',['users' =>$users]);
        }
    }
}
