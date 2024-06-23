<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Facility;
use App\Models\Property;
use App\Models\Amenities;
use App\Models\MultiImage;
use App\Models\PackagePlan;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use App\Models\PropertyMessage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class PropertyController extends Controller
{
    public function AllProperty()
    {
        $property =Property::latest()->get();
        return view('backend.property.all_property',compact('property'));
    }

    public function AddProperty()
    {
        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('status','active')->where('role','agent')->latest()->get();
        return view('backend.property.add_property',compact('propertytype','amenities','activeAgent'));
    }

    public function StoreProperty(Request $request)
    {
        $amen = $request->amenities_id;
        $amenities = implode(",", $amen);
        // dd($amenities);

        $pcode = IdGenerator::generate(['table' => 'properties', 'field' => 'property_code', 'length' => 5, 'prefix' => 'PC']);

        // $image = $request->file('property_thambnail');
        // $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        // Image::make($image)->resize(370, 250)->save('upload/property/thambnail/' . $name_gen);
        // $save_url = 'upload/property/thambnail/' . $name_gen;


        $property_id =  Property::insertGetId([
            'ptype_id' =>$request->ptype_id,
            'amenities_id' =>$amenities,
            'property_name' =>$request->property_name,
            'property_slug' =>strtolower(str_replace(' ','-',$request->property_name)),
            'property_code'=>$pcode,
            'property_status' =>$request->property_status,
            'lowest_price' =>$request->lowest_price,
            'max_price' =>$request->max_price,
            'bedrooms' =>$request->bedrooms,
            'bathrooms' =>$request->bathrooms,
            'garage' =>$request->garage,
            'garage_size' =>$request->garage_size,
            'address' =>$request->address,
            'city' =>$request->city,
            'state' =>$request->state,
            'postal_code' =>$request->postal_code,
            'property_size' =>$request->property_size,
            'neighborhood' =>$request->neighborhood,
            'latitude' =>$request->latitude,
            'longitude' =>$request->longitude,
            // 'property_thambnail' =>$save_url,
            'property_thambnail' =>"m",
            'short_descp' =>$request->short_descp,
            'long_descp' =>$request->long_descp,
            'agent_id' =>$request->agent_id,
            'property_video' =>$request->property_video,
            'status' =>1,
            'created_at' =>Carbon::now(),
            'hot' =>$request->hot,
            'featured' =>$request->featured,
        ]);

        /// Multi image Upload /////
        // $images = $request->file('multi_img');
        // foreach($images as $img){

        //     $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
        //     Image::make($img)->resize(770, 520)->save('upload/property/multi-image/' . $make_name);
        //     $uploadPath = 'upload/property/multi-image/' . $make_name;

        //     MultiImage::insert([
        //          'property_id' =>$property_id,
        //          'photo_name' =>$uploadPath,
        //          'created_at' =>Carbon::now(),
        //     ]);

        // }

         /// End  Multi image Upload Here

         // Facilites Add Here

        $facilities = Count($request->facility_name);

        if($facilities !=NULL){
             for($i=0; $i < $facilities; $i++){
                $fcount = new Facility();
                $fcount->property_id = $property_id;
                $fcount->facility_name = $request->facility_name[$i];
                $fcount->distance = $request->distance[$i];
                $fcount->save();
             }
        }





        return  $prod_name = Count($request->prod_name);

        if($prod_name !=NULL){
             for($i=0; $i < $prod_name; $i++){
                $fcount = new Facility();
                $fcount->property_id = $property_id;
                $fcount->facility_name = $request->facility_name[$i];
                $fcount->distance = $request->distance[$i];
                $fcount->save();
             }
        }

         /// End Facilites

        $notification = array(
            'message' =>"Property Add Successfully!",
            'alert-type' =>'success'
        );

      return redirect()->route('all.property')->with($notification);
    }

    public function EditProperty($id)
    {
        $property = Property::findOrFail($id);
        $propertytype = PropertyType::latest()->get();

        $type = $property->amenities_id;
        $property_ami = explode(',', $type);

        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('status','active')->where('role','agent')->latest()->get();
        $multiImage = MultiImage::where('property_id',$id)->get();
        $facilities  = Facility::where('property_id',$id)->get();
        return view('backend.property.edit_property',compact('propertytype','amenities','activeAgent','property','property_ami','multiImage','facilities'));
    }

    public function UpdateProperty(Request $request)
    {
        $amen = $request->amenities_id;
        $amenities = implode(",", $amen);

        $property_id = $request->id;

        Property::findOrFail($property_id)->update([
            'ptype_id' =>$request->ptype_id,
            'amenities_id' =>$amenities,
            'property_name' =>$request->property_name,
            'property_slug' =>strtolower(str_replace(' ','-',$request->property_name)),
            'property_status' =>$request->property_status,
            'lowest_price' =>$request->lowest_price,
            'max_price' =>$request->max_price,
            'bedrooms' =>$request->bedrooms,
            'bathrooms' =>$request->bathrooms,
            'garage' =>$request->garage,
            'garage_size' =>$request->garage_size,
            'address' =>$request->address,
            'city' =>$request->city,
            'state' =>$request->state,
            'postal_code' =>$request->postal_code,
            'property_size' =>$request->property_size,
            'neighborhood' =>$request->neighborhood,
            'latitude' =>$request->latitude,
            'longitude' =>$request->longitude,
            'short_descp' =>$request->short_descp,
            'long_descp' =>$request->long_descp,
            'agent_id' =>$request->agent_id,
            'property_video' =>$request->property_video,
            'status' =>1,
            'updated_at' =>Carbon::now(),
            'hot' =>$request->hot,
            'featured' =>$request->featured,

        ]);

        $notification = array(
            'message' =>"Property Details Updated Successfully!",
            'alert-type' =>'success'
        );

      return redirect()->route('all.property')->with($notification);
    }

    public function UpdatePropertyThambnail(Request $request)
    {

        $pro_id = $request->id;
        $oldImage = $request->old_img;

        $image = $request->file('property_thambnail');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(370, 250)->save('upload/property/thambnail/' . $name_gen);
        $save_url = 'upload/property/thambnail/' . $name_gen;

        if(file_exists($oldImage)){
            unlink($oldImage);
        }

        Property::findOrFail($pro_id)->update([
            'property_thambnail' =>$save_url,
            'updated_at' =>Carbon::now(),
        ]);

        $notification = array(
            'message' =>"Property Thambnail Image  Updated Successfully!",
            'alert-type' =>'success'
        );

      return redirect()->back()->with($notification);
    }

    public function UpdatePropertyMultiimage(Request $request)
    {
        $imgs = $request->multi_img;

        foreach($imgs as $id => $img){
            $imgDel = MultiImage::findOrFail($id);
            unlink($imgDel->photo_name);

            $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
            Image::make($img)->resize(770, 520)->save('upload/property/multi-image/' . $make_name);
            $uploadPath = 'upload/property/multi-image/' . $make_name;

            MultiImage::where('id',$id)->update([
                 'photo_name' =>$uploadPath,
                 'updated_at' =>Carbon::now(),
            ]);
        }

        $notification = array(
            'message' =>"Property Multi Image  Updated Successfully!",
            'alert-type' =>'success'
        );

      return redirect()->back()->with($notification);
    }

    Public function PropertyMultiImageDelete($id)
    {
        $oldImg = MultiImage::findOrFail($id);
        unlink($oldImg->photo_name);

        MultiImage::findOrFail($id)->delete();

        $notification = array(
            'message' =>"Property Multi Image   Delete Successfully!",
            'alert-type' =>'success'
        );

      return redirect()->back()->with($notification);
    }

    public function StoreNewMultiimage(Request $request)
    {
        $new_multi = $request->imageid;
        $image = $request->file('multi_img');



            $make_name = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(770, 520)->save('upload/property/multi-image/' . $make_name);
            $uploadPath = 'upload/property/multi-image/' . $make_name;

            MultiImage::insert([
                'property_id' =>$new_multi,
                'photo_name' =>$uploadPath,
                'created_at' =>Carbon::now(),
           ]);

        $notification = array(
            'message' =>"Property New Multi Image  Updated Successfully!",
            'alert-type' =>'success'
        );

      return redirect()->back()->with($notification);
    }

    public function UpdatePropertyFacilities(Request $request)
    {

        $pid = $request->id;

            if($request->facility_name == NULL){
                return redirect()->back();
            }else
            {
                Facility::where('property_id',$pid)->delete();

                $facilities = Count($request->facility_name);

                if($facilities !=NULL){
                    for($i=0; $i < $facilities; $i++){
                        $fcount = new Facility();
                        $fcount->property_id = $pid;
                        $fcount->facility_name = $request->facility_name[$i];
                        $fcount->distance = $request->distance[$i];
                        $fcount->save();
                    }
            }
        }

        $notification = array(
            'message' =>"Property Facilities  Updated Successfully!",
            'alert-type' =>'success'
        );

      return redirect()->back()->with($notification);
    }

    public function DeleteProperty($id)
    {
        $property = Property::findOrFail($id);
        unlink($property->property_thambnail);

        Property::findOrFail($id)->delete();

        $image = MultiImage::where('property_id', $id)->get();

        foreach($image as $img){
            unlink($img->photo_name);
            MultiImage::where('property_id', $id)->delete();
        }

        $facilitiesData = Facility::where('property_id', $id)->get();

        foreach($facilitiesData as $item){
              $item->facility_name;
              Facility::where('property_id', $id)->delete();
        }


        $notification = array(
            'message' =>"Property All Related Item Has Been Delete Successfully!",
            'alert-type' =>'success'
        );

      return redirect()->back()->with($notification);

    }

    public function DetailsProperty($id)
    {
        $property = Property::findOrFail($id);
        $propertytype = PropertyType::latest()->get();

        $type = $property->amenities_id;
        $property_ami = explode(',', $type);

        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('status','active')->where('role','agent')->latest()->get();
        return view('backend.property.details_property',compact('property','property_ami','amenities'));
    }

    public function InactiveProperty(Request $request)
    {
        $pid = $request->id;
        Property::findOrFail($pid)->update([
            'status'=>0,
        ]);

        $notification = array(
            'message' =>"Property Status Has Been InActive Successfully!",
            'alert-type' =>'warning'
        );

      return redirect()->back()->with($notification);
    }
    public function ActiveProperty(Request $request)
    {
        $pid = $request->id;
        Property::findOrFail($pid)->update([
            'status'=>1,
        ]);

        $notification = array(
            'message' =>"Property Status Has Been Active Successfully!",
            'alert-type' =>'success'
        );

      return redirect()->back()->with($notification);
    }

    public function AdminPackageHistory()
    {
        $packagehistory = PackagePlan::latest()->get();
        return view('backend.package.package_history', compact('packagehistory'));
    }

    public function PackageInvoice($id)
    {

        $packagehistory = PackagePlan::where('id', $id)->first();

        $pdf = Pdf::loadView('backend.package.package_history_invoice',compact('packagehistory'))->setPaper('a4')->setOption([
            'tempDir' =>public_path(),
            'chroot' => public_path(),
        ]);
        return $pdf->download('invoice.pdf');
    }

    public function AdminPropertyMessage()
    {
        $usermsg = PropertyMessage::get();
        return view('agent.message.all_message', compact('usermsg'));
    }
}
