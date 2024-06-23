<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Facility;
use App\Models\Property;
use App\Models\MultiImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PropertyMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function PropertyDetails($id,$slug)
    {
        $property = Property::findOrFail($id);
        $multiImage =MultiImage::where('property_id',$id)->get();

         $amen = $property->amenities_id;
             $property_amen = explode(",", $amen);
             $facility  =Facility::where('property_id',$id)->get();
         
          $type_id = $property->ptype_id;
        $relatedProperty = Property::where('ptype_id', $type_id)->where('id', '!=', $id)->orderBy('id', 'DESC')->limit(3)->get();
        return view('frontend.property.property_details',compact('property','multiImage','property_amen','facility','relatedProperty'));
    }

    public function PropertyMessage(Request $request)
    {
        $pid = $request->property_id;
        $aid = $request->agent_id;

        if(Auth::check()){

            PropertyMessage::insert([
                'user_id'=>Auth::user()->id,
                'agent_id'=>$aid,
                'property_id'=>$pid,
                'msg_name'=>$request->msg_name,
                'msg_email'=>$request->msg_email,
                'msg_phone'=>$request->msg_phone,
                'message'=>$request->message,
                'created_at'=>Carbon::now(),
            ]);

            $notification = array(
                'message' =>"Your Message Request has sent Successfully!",
                'alert-type' =>'success'
            );
    
          return redirect()->back()->with($notification);

        }else{

            $notification = array(
                'message' =>"Plz Login Your Account First!",
                'alert-type' =>'error'
            );
    
          return redirect()->back()->with($notification);
        }
    }
}
