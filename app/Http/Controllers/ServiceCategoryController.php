<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\ServiceCategory;
use App\Models\Ticket;
use App\Models\Order;
use App\Http\Controllers\AppHelper;
use App\Models\User;
use App\Models\AppUser;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class ServiceCategoryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('service_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceCategory = ServiceCategory::where([['is_delete',0]])->orderBy('id','DESC')->get();

        return view('admin.service-category.index', ['serviceCategory'=>$serviceCategory]);
    }

    public function create()
    {
        abort_if(Gate::denies('service_category_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.service-category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'bail|required',
            'name' => 'bail|required',
            'is_active' => 'bail|required'
        ]);
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;

        if ($request->hasFile('image')) {
            $data['image'] = (new AppHelper)->saveImage($request);
        }

        ServiceCategory::create($data);
        return redirect()->route('service_category_index')->withStatus('Service category is added successfully.');
    }

    public function edit(ServiceCategory $serviceCategory,$id)
    {
        abort_if(Gate::denies('service_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $serviceCategory = ServiceCategory::where([['is_delete',0],['id',$id]])->first();

        return view('admin.service-category.edit',['serviceCategory'=>$serviceCategory]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'bail|required',
            'is_active' => 'bail|required'
        ]);
        $data = $request->all();
        $ServiceCategory = ServiceCategory::where('id',$id)->first();
        if ($request->hasFile('image')) {
            if($ServiceCategory->image && !empty($ServiceCategory->image)){
                (new AppHelper)->deleteFile($ServiceCategory->image);
            }
            $data['image'] = (new AppHelper)->saveImage($request);
        }
        ServiceCategory::find($id)->update($data);
        return redirect()->route('service_category_index')->withStatus('Service category is updated successfully.');
    }

    public function destroy($id)
    {
        try{
            ServiceCategory::find($id)->update(['is_delete'=>1]);
            return redirect()->route('service_category_index')->withStatus('Service category is deleted.');
        }catch(Throwable $th){
            return response('Data is Connected with other Data', 400);
        }
    }

}
