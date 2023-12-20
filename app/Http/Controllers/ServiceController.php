<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppHelper;
use App\Models\District;
use App\Models\Division;
use App\Models\Event;
use App\Models\Category;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceImage;
use App\Models\ServiceItem;
use App\Models\Ticket;
use App\Models\Order;
use App\Models\Upazila;
use App\Models\User;
use App\Models\AppUser;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class ServiceController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('service_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service = Service::where([['is_delete',0]])->orderBy('id','DESC')->get();

        return view('admin.service.index', ['service'=>$service]);
    }

    public function create()
    {
        abort_if(Gate::denies('service_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $serviceCategory = ServiceCategory::GetAllServiceCategoryDropdownData();
        $divisions = Division::GetAllDivisionDropdownData();
        return view('admin.service.create',['serviceCategory'=>$serviceCategory,'divisions'=>$divisions]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_category_id' => 'bail|required',
//            'unit_cost' => 'bail|required|integer',
            'name' => 'bail|required',
            'company_name' => 'bail|required',
            'contact_person_name' => 'bail|required',
            'contact_person_mobile' => 'bail|required',
            'division' => 'bail|required',
            'district' => 'bail|required',
            'upazila' => 'bail|required',
            'is_active' => 'bail|required'
        ]);
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;

        if ($request->hasFile('image')) {
            $data['image'] = (new AppHelper)->saveImage($request);
        }

        $service = Service::create($data);
        foreach ($data['item_name'] as $index => $item){
            $serviceItem['service_id'] = $service->id;
            $serviceItem['service_category_id'] = $data['service_category_id'];
            $serviceItem['item_name'] = $data['item_name'][$index];
            $serviceItem['item_description'] = $data['item_description'][$index];
            $serviceItem['item_quantity'] = $data['item_quantity'][$index];
            $serviceItem['item_price'] = $data['item_price'][$index];
            $serviceItem['ems_discount'] = $data['ems_discount'][$index];
            ServiceItem::create($serviceItem);
        }

        $imgSL = 1;
        if ($request->file('attach_link') != '') {
            foreach($request->file('attach_link') as $index => $value) {
                $avatar = $request->file('attach_link')[$index];

                $file_title = 'more'.rand(1,10000).$imgSL.'-'.time().'.'.$avatar->getClientOriginalExtension();
                $image['image'] = $file_title;
                $path = public_path("/images/upload/");
                $target_file =  $path.basename($file_title);
                $file_path = $_FILES['attach_link']['tmp_name'][$index];
                $result = move_uploaded_file($file_path,$target_file);

                $image['service_id'] = $service->id;
                $image['img_level'] = $data['img_level'][$index];

                ServiceImage::create($image);
                $imgSL++;
            }
        }

        return redirect()->route('service_index')->withStatus('Service is added successfully.');
    }

    public function edit(Service $service,$id)
    {
        abort_if(Gate::denies('service_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $service = Service::where([['is_delete',0],['id',$id]])->first();
        $serviceCategory = ServiceCategory::GetAllServiceCategoryDropdownData();
        $divisions = Division::GetAllDivisionDropdownData();
        $districts = District::GetAllDivisionWiseDistrictDropdownData($service->division);
        $upazilas = Upazila::GetAllDistrictWiseUpazilaDropdownData($service->district);
        $items = ServiceItem::where('service_id',$service->id)->get();
        return view('admin.service.edit',['service'=>$service,'serviceCategory'=>$serviceCategory,'divisions'=>$divisions,'districts'=>$districts,'upazilas'=>$upazilas,'items'=>$items]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'service_category_id' => 'bail|required',
//            'unit_cost' => 'bail|required|integer',
            'name' => 'bail|required',
            'company_name' => 'bail|required',
            'contact_person_name' => 'bail|required',
            'contact_person_mobile' => 'bail|required',
            'division' => 'bail|required',
            'district' => 'bail|required',
            'upazila' => 'bail|required',
            'is_active' => 'bail|required'
        ]);
        $data = $request->all();
        $service = Service::where('id',$id)->first();
        if ($request->hasFile('image')) {
            if($service->image && !empty($service->image)){
                (new AppHelper)->deleteFile($service->image);
            }
            $data['image'] = (new AppHelper)->saveImage($request);
        }
        Service::find($id)->update($data);
        $deleteItem = ServiceItem::where('service_id',$service->id)->get();
        foreach ($deleteItem as $delete){
            ServiceItem::where('id',$delete->id)->delete();
        }
        foreach ($data['item_name'] as $index => $item){
            $serviceItem['service_id'] = $id;
            $serviceItem['service_category_id'] = $data['service_category_id'];
            $serviceItem['item_name'] = $data['item_name'][$index];
            $serviceItem['item_description'] = $data['item_description'][$index];
            $serviceItem['item_quantity'] = $data['item_quantity'][$index];
            $serviceItem['item_price'] = $data['item_price'][$index];
            $serviceItem['ems_discount'] = $data['ems_discount'][$index];
            ServiceItem::create($serviceItem);
        }
        /*$imgSL = 1;
        if ($request->file('attach_link') != '') {
            foreach($request->file('attach_link') as $index => $value) {
                $avatar = $request->file('attach_link')[$index];

                $file_title = 'more'.rand(1,10000).$imgSL.'-'.time().'.'.$avatar->getClientOriginalExtension();
                $image['image'] = $file_title;
                $path = public_path("/images/upload/");
                $target_file =  $path.basename($file_title);
                $file_path = $_FILES['attach_link']['tmp_name'][$index];
                $result = move_uploaded_file($file_path,$target_file);

                $image['service_id'] = $id;
                $image['img_level'] = $data['img_level'][$index];

                ServiceImage::create($image);
                $imgSL++;
            }
        }*/
        return redirect()->route('service_index')->withStatus('Service is updated successfully.');
    }

    public function destroy($id)
    {
        try{
            Service::find($id)->update(['is_delete'=>1]);
            return redirect()->route('service_index')->withStatus('Service is deleted.');
        }catch(Throwable $th){
            return response('Data is Connected with other Data', 400);
        }
    }

    public function addMoreItem(){
        $slNo = $_GET['slNo']+1;
        $view = \Illuminate\Support\Facades\View::make('admin.service._add_more_item',compact('slNo'));
        $contents = $view->render();
        $response['content'] = $contents;
        $response['sl'] = $slNo;
        return $response;
    }

    public function categoryWiseService(){
        $categoryID = $_GET['serviceCategoryID'];
        $services = Service::where('service_category_id',$categoryID)->get();
        if (count($services)>0){
            $view = \Illuminate\Support\Facades\View::make('admin.service._category_wise_service',compact('services'));
            $contents = $view->render();
            $response['content'] = $contents;
            $response['categoryID'] = $categoryID;
            return $response;
        }
    }

    public function addMultipleServiceImage(){
        $slNo = $_GET['slNo'];
        $view = \Illuminate\Support\Facades\View::make('admin.service._multiple_image',compact('slNo'));
        $response['slNo'] = $slNo++;
        $contents = $view->render();
        $response['content'] = $contents;
        return $response;
    }

    public function serviceImageDelete(){
        $slNo = $_GET['slNo'];
        $deleteImage = ServiceImage::where('id',$slNo)->first();
        File::delete(public_path().'/images/upload/'.$deleteImage->image);
        $deleteImage->delete();
        $response['ok'] = 'Delete';
        return $response;
    }

}
