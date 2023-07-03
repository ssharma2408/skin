<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Crypt;

use Session;
use Hash;

class StaffController extends Controller
{
    public function dashboard()
    {
		return view('staffs.dashboard');
    }
	
	public function index()
    {
        $theUrl     = config('app.api_url').'v1/staffs';	   
		$response   = Http ::withHeaders([
            'Authorization' => 'Bearer '.Session::get('user_details')->token 
        ])->get($theUrl, [
				'clinic_id'=>$_ENV['CLINIC_ID']
			]);
		
		$staffs = json_decode($response->body())->data;		

        return view('staffs.index', compact('staffs'));
        
    }

    public function create()
    {
        //abort_if(Gate::denies('staff_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //$clinics = Clinic::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        //return view('staffs.create', compact('clinics'));
        return view('staffs.create');
    }

    public function store(Request $request)
    {		
		
		$theUrl     = config('app.api_url').'v1/staffs';
		
		$post_arr = [
			'name'=>$request['name'],
			'email'=>$request['email'],
			'mobile_number'=>$request['mobile'],
			'username'=>Session::get('user_details')->prefix."_".$request['username'],
			'password'=>Hash::make($request['password']),
			'clinic_id'=>$_ENV['CLINIC_ID'],
		];
		
		$response   = Http ::withHeaders([
            'Authorization' => 'Bearer '.Session::get('user_details')->token 
        ])->post($theUrl, $post_arr);
		
		$staff = json_decode($response->body());
		

        return redirect()->route('staffs.index');
    }

    public function edit()
    {		
		$url_arr = explode("/", url()->full());

		$staff_id = $url_arr[count($url_arr)-2];
		
		$theUrl     = config('app.api_url').'v1/staffs/'.$staff_id;
		$response   = Http ::withHeaders([
            'Authorization' => 'Bearer '.Session::get('user_details')->token 
        ])->get($theUrl);
		
		$staff = json_decode($response->body())->data;
		
		$staff->username = explode("_", $staff->username)[0];		

        return view('staffs.edit', compact('staff'));
        
    }

    public function update(Request $request)
    {
        
		$url_arr = explode("/", url()->full());

		$staff_id = $url_arr[count($url_arr)-1];	
		
		$post_arr = [
			'name'=>$request['name'],
			'email'=>$request['email'],
			'mobile_number'=>$request['mobile'],
			'username'=>Session::get('user_details')->prefix."_".$request['username'],			
			'clinic_id'=>$_ENV['CLINIC_ID'],
		];
		
		if(trim($request['password']) != ""){
			$post_arr['password'] = Hash::make(trim($request['password']));
		}
		
		$theUrl     = config('app.api_url').'v1/staffs/'.$staff_id;
		$response   = Http ::withHeaders([
            'Authorization' => 'Bearer '.Session::get('user_details')->token 
        ])->put($theUrl, $post_arr);
		
		$staff = json_decode($response->body());

        return redirect()->route('staffs.index');
    }

    public function show()
    {
        
		$url_arr = explode("/", url()->full());

		$staff_id = $url_arr[count($url_arr)-1];
		
		$theUrl     = config('app.api_url').'v1/staffs/'.$staff_id;
		$response   = Http ::withHeaders([
            'Authorization' => 'Bearer '.Session::get('user_details')->token 
        ])->get($theUrl);
		
		$staff = json_decode($response->body())->data;	

        return view('staffs.show', compact('staff'));
        
    }

    public function destroy()
    {
        
		$url_arr = explode("/", url()->full());

		$staff_id = $url_arr[count($url_arr)-1];
		
		$theUrl     = config('app.api_url').'v1/staffs/'.$staff_id;

		$response   = Http ::withHeaders([
            'Authorization' => 'Bearer '.Session::get('user_details')->token			
        ])->delete($theUrl);	

        return redirect()->route('staffs.index');
    }

	public function clinic()
	{

		$theUrl     = config('app.api_url').'v1/clinics/'.$_ENV['CLINIC_ID'];	   
		$response   = Http ::withHeaders([
            'Authorization' => 'Bearer '.Session::get('user_details')->token 
        ])->get($theUrl);
				
		$clinic = json_decode($response->body())->data;
		
		if(!empty($clinic->opening_hours)){
			$timing_arr = [];
			foreach($clinic->opening_hours as $timing){
				$timing_arr[$timing->day][] = $timing;
			}
			$clinic->opening_hours = $timing_arr;
		}
		
		$day_arr = array("Monday", "Tuseday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
		
		//get closed days
		$theUrl     = config('app.api_url').'v1/closed-timings/'.$clinic->clinic_admin->id;
		$response   = Http ::withHeaders([
            'Authorization' => 'Bearer '.Session::get('user_details')->token 
        ])->get($theUrl);
				
		$closed_days = json_decode($response->body())->data;		

        return view('staffs.clinic', compact('clinic', 'day_arr', 'closed_days'));
	}

	public function doctors()
	{
		$theUrl     = config('app.api_url').'v1/doctors/'.$_ENV['CLINIC_ID'];
		$response   = Http ::withHeaders([
            'Authorization' => 'Bearer '.Session::get('user_details')->token 
        ])->get($theUrl);

		$doctors = json_decode($response->body())->data[0]->doctors;

	   return view('staffs.doctors', compact('doctors'));
	}

	public function view(Request $request)
	{
		$theUrl     = config('app.api_url').'v1/doctors/'.$_ENV['CLINIC_ID'].'/'.$request->doctor_id;
		$response   = Http ::withHeaders([
            'Authorization' => 'Bearer '.Session::get('user_details')->token 
        ])->get($theUrl);

		$details = json_decode($response->body())->data;
		
		if(!empty($details->opening_hours)){
			$timing_arr = [];
			foreach($details->opening_hours as $timing){
				$timing_arr[$timing->day][] = $timing;
			}
			$details->opening_hours = $timing_arr;
		}
		
		$day_arr = array("Monday", "Tuseday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");

		return view('staffs.doctor', compact('details', 'day_arr'));
	}

	public function timings()
	{
		$theUrl     = config('app.api_url').'v1/clinic-timings/'.$_ENV['CLINIC_ID'];
		$response   = Http ::withHeaders([
            'Authorization' => 'Bearer '.Session::get('user_details')->token 
        ])->get($theUrl);

		$details = json_decode($response->body())->data;
		
		if(!empty($details->opening_hours)){
			$timing_arr = [];
			foreach($details->opening_hours as $timing){
				$timing_arr[$timing->day][] = $timing;
			}
			$details->opening_hours = $timing_arr;
		}

		$day_arr = array("Monday", "Tuseday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");

		return view('staffs.timings', compact('details', 'day_arr'));
	}
	
	public function save(Request $request)
    {		
		$theUrl     = config('app.api_url').'v1/timings-save';
		
		$response   = Http ::withHeaders([
            'Authorization' => 'Bearer '.Session::get('user_details')->token 
        ])->post($theUrl, $request->all());

		$response = json_decode($response->body());		
		$route = 'clinic.show';
		
		if($request->type =='doctor'){
			$route = 'clinic.doctors';
		}
        return redirect()->route($route)->with('success', "Timings updated successfully");
    }

	public function closed_day(Request $request)
	{
		$theUrl     = config('app.api_url').'v1/closed-timings/'.$request->clinic_admin;
		$response   = Http ::withHeaders([
            'Authorization' => 'Bearer '.Session::get('user_details')->token 
        ])->get($theUrl);

		$details = json_decode($response->body())->data;
		
		$clinic_admin = $request->clinic_admin;

		return view('staffs.closedday', compact('details', 'clinic_admin'));
	}

	public function closed_day_save(Request $request)
    {		
		
		$theUrl     = config('app.api_url').'v1/closed-timings-save';
		
		$response   = Http ::withHeaders([
            'Authorization' => 'Bearer '.Session::get('user_details')->token 
        ])->post($theUrl, $request->all());

		$response = json_decode($response->body());

        return redirect()->route('clinic.show')->with('success', "Timings updated successfully");
    }
	
	public function doctor_timing_edit(Request $request)
	{
		$theUrl     = config('app.api_url').'v1/doctors/'.$_ENV['CLINIC_ID'].'/'.$request->doctor_id;
		$response   = Http ::withHeaders([
            'Authorization' => 'Bearer '.Session::get('user_details')->token 
        ])->get($theUrl);

		$details = json_decode($response->body())->data;
		
		if(!empty($details->opening_hours)){
			$timing_arr = [];
			foreach($details->opening_hours as $timing){
				$timing_arr[$timing->day][] = $timing;
			}
			$details->opening_hours = $timing_arr;
		}
		
		$day_arr = array("Monday", "Tuseday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");

		return view('staffs.doctor_edit', compact('details', 'day_arr'));
	}
}
