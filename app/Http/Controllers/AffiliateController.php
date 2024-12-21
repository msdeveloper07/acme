<?php

namespace App\Http\Controllers;
use App\Affiliate;
use App\Facades\ShopifyAPI;
use App\Store;
use Illuminate\Http\Request;
use DB;


class AffiliateController extends Controller
{
	/***********************************************
		Store Affiliate Form into DB
	********************************************** */
	public function storeAffiliateForm(Request $request){
		if(!empty($request->customer_id)){
		    $affiliate = Affiliate::where("shopify_user_id",$request->customer_id)->get()->count();
		    if($affiliate == 0){
                $store = Store::where("shopname",$request->shopname)->first();
                $user_response = ShopifyAPI::shopify_call($store->token, $store->shopname, "/admin/api/2021-01/customers/".$request->customer_id.".json", array(), 'GET');
                $user = json_decode($user_response['response']);
                $affiliate = new Affiliate;
		        $affiliate->shopify_user_id = $user->customer->id;
		        $affiliate->name = $user->customer->first_name." ".$user->customer->last_name;
		        $affiliate->email = $user->customer->email;
		        $affiliate->save();
            }
			DB::table('users')->insert(
				[
					'shopify_user_id' => $request->customer_id, 'email' => $request->email, 'name' => $request->full_name,
					'phone' => $request->phone, 'textarea_data' => $request->textarea_data
				]
			);
			return response()->json([
				'success' => true,
				'message' => 'Data successfully submit.'
			], 200);
		}else{
			return response()->json([
				'success' => false,
				'message' => 'Something went wrong..!'
			], 422);
		}
    }

    /***********************************************
		API for customer Data
	********************************************** */
	public function getCustomerData(Request $request){
		if($request->customerID_){
			$users = DB::table('users')->where('shopify_user_id',$request->customerID_)->first();
			if(!empty($users)){
				$affiliates = DB::table('affiliate')->where('shopify_user_id',$request->customerID_)->first();
	            $store = Store::find(2);
	            $users->panel_text = $store->panel_text;
				return response()->json([
					'success' => true,
					'data' => $users,
					'status' => @$affiliates->tags,
					'affiliates_vname' => @$affiliates->vehicle_info,
					'affiliates_image' => @$affiliates->image
				], 200);
			}else{
				return response()->json([
					'success' => true,
					'data' => '',
					'status' => '',
					'affiliates_vname' => '',
					'affiliates_image' => ''
				], 200);
			}
			
			//echo"<pre>"; print_r($users); die;
		}
	}

	/***********************************************
		API for Affiliates
	********************************************** */
	public function getTierRedem(Request $request){
		if($request->customerID_){
			$affiliates = DB::table('affiliate')->where('shopify_user_id',$request->customerID_)->first();
			$credits = DB::table('credits')->where('shopify_user_id',$request->customerID_)->get();
			$commissions = DB::table('commissions')->where('shopify_user_id',$request->customerID_)->get();
			if($affiliates->tags == "affiliate"){
				return response()->json([
					'success' => 'true',
					'data' => $affiliates->image,
					'credits' => $credits,
					'commissions' => $commissions
				], 200);
			}else{
				return response()->json([
					'success' => 'false',
					'data' => "You don't have access to see data."
				], 200);
			}
		}
	}

	/***********************************************
		API for referrals Data
	********************************************** */
	public function getReferralsData(Request $request){
		if($request->customerID_){
			$approved_users = DB::table('users')->where('shopify_user_id',$request->customerID_)->where('referral_status','approved')->get();
			$pending_users = DB::table('users')->where('shopify_user_id',$request->customerID_)->where('referral_status','pending')->get();
			$history = DB::table('users')->where('shopify_user_id',$request->customerID_)->orderBy('id', 'DESC')->get();
			$approved_ = array();
			$pending_ = array();
			$history_ = array();
			foreach ($approved_users as $key => $value) {
				$approved = $value->name;
				$approved_[] = $approved;
			}

			foreach ($pending_users as $key => $value) {
				$pending = $value->name;
				$pending_[] = $pending;
			}			

			foreach ($history as $key => $value) {
			    $histry['user'] = $value->name;
			    if($value->approve_or_reject_datetime == null){
                    $histry['approve_or_reject_datetime'] = $value->submission_datetime;
                }else {
                    $histry['approve_or_reject_datetime'] = $value->approve_or_reject_datetime;
                }
				$histry['referral_status'] = $value->referral_status;
				$history_[] = $histry;
			}
			return response()->json([
				'success' => true,
				'approved_users' => $approved_,
				'pending_users' => $pending_,
				'history_data' => $history_
			], 200);
			//echo"<pre>"; print_r($users); die;
		}
	}

	/***********************************************
		Submit Company Form
	********************************************** */
	public function submitCompanyForm(Request $request){
		if(!empty($request->customer_id)){
			DB::table('company')->insert(
				[
					'shopify_customer_id' => $request->customer_id, 'company_name' => $request->company_name
				]
			);
			return response()->json([
				'success' => true,
				'message' => 'Data successfully submit.'
			], 200);
		}else{
			return response()->json([
				'success' => false,
				'message' => 'Something went wrong..!'
			], 422);
		}
	}
	/**********************************************************
		Update User Status
	***********************************************************/
	public function updateStatus(Request $request){
		// echo"<pre>"; print_r(array($request->shid)); die;
		if(!empty($request->shid) && !empty($request->status_) && !empty($request->email_)){
			$updated = DB::table('users')->where('shopify_user_id', $request->shid)->where('email',$request->email_)->get();
			foreach ($updated as $key => $value) {
				//echo"<pre>"; print_r($value); die;
				$affected = DB::table('users')
				->where('id', $value->id)
				->update(['referral_status' => strtolower($request->status_), 'approve_or_reject_datetime' => now()]);
			}
			return response()->json([
				'success' => true,
				'message' => 'Status updated.'
			], 200);
		}else{
			return response()->json([
				'success' => false,
				'message' => 'Something went wrong..!'
			], 422);
		}
	}
	/**********************************************************
		Add commission
	***********************************************************/
	public function updateCommission(Request $request){
		//echo"<pre>"; print_r($request->all()); die;
		if(!empty($request->commission) && !empty($request->shopify_user_id) && !empty($request->emaiL_)){
			$updated = DB::table('users')->where('shopify_user_id', $request->shopify_user_id)->where('email',$request->emaiL_)->get();
			foreach ($updated as $key => $value) {
				$commission = $request->commission + $value->commission;
				$affected = DB::table('users')
				->where('id', $value->id)
				->update(['commission' => $commission, 'commission_text' => $request->commission_text]);
			}

			// if ($request->hasFile('commission_file')) {
   //              $image = $request->file('commission_file');
   //              $name = time().'.'.$image->getClientOriginalExtension();
   //              $destinationPath = public_path('images/affiliate/',$name);
   //              $image->move($destinationPath, $name);
   //              DB::table('commissions')->insert(
			// 		[
			// 			'shopify_user_id' => $request->shopify_user_id, 'referral_email' => $request->emaiL_, 'commission_val' => $request->commission, 'commission_text' => $request->commission_text,
			// 			'image' => $name
			// 		]
			// 	);
			// 	return response()->json([
			// 		'success' => true,
			// 		'message' => 'Status updated.'
			// 	], 200);
   //          }

			DB::table('commissions')->insert(
				[
					'shopify_user_id' => $request->shopify_user_id, 'referral_email' => $request->emaiL_, 'commission_val' => $request->commission, 'commission_text' => $request->commission_text
				]
			);

			return response()->json([
				'success' => true,
				'message' => 'Status updated.'
			], 200);
		}else{
			return response()->json([
				'success' => false,
				'message' => 'Something went wrong..!'
			], 422);
		}
	}

	/**********************************************************
		Add credits
	***********************************************************/
	public function updateCredits(Request $request){
		// echo"<pre>"; print_r($request->all()); die;
		if(!empty($request->points) && !empty($request->shopify_user_id) && !empty($request->emaiL_)){
			$updated = DB::table('users')->where('shopify_user_id', $request->shopify_user_id)->where('email',$request->emaiL_)->get();
			foreach ($updated as $key => $value) {
				$points = $request->points + $value->points;
				$affected = DB::table('users')
				->where('id', $value->id)
				->update(['points' => $points, 'point_text' => $request->points_text]);
			}
			
			// if ($request->hasFile('credits_file')) {
   //              $image = $request->file('credits_file');
   //              $name = time().'.'.$image->getClientOriginalExtension();
   //              $destinationPath = public_path('images/affiliate/',$name);
   //              $image->move($destinationPath, $name);

   //              DB::table('credits')->insert(
			// 		[
			// 			'shopify_user_id' => $request->shopify_user_id, 'referral_email' => $request->emaiL_, 'points' => $request->points, 'point_text' => $request->points_text, 'image' => @$name
			// 		]
			// 	);

			// 	return response()->json([
			// 		'success' => true,
			// 		'message' => 'Status updated.'
			// 	], 200);
   //          }

			DB::table('credits')->insert(
				[
					'shopify_user_id' => $request->shopify_user_id, 'referral_email' => $request->emaiL_, 'points' => $request->points, 'point_text' => $request->points_text
				]
			);

			return response()->json([
				'success' => true,
				'message' => 'Status updated.'
			], 200);
		}else{
			return response()->json([
				'success' => false,
				'message' => 'Something went wrong..!'
			], 422);
		}
	}

	public function get_panel_text(){
	    $store = Store::find(2);
	    $return['panel_text'] = $store->panel_text;
	    return json_encode($return);
    }
}
