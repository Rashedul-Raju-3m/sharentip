<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Division;
use App\Models\Event;
use App\Models\Category;
use App\Models\Service;
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

class DistrictController extends Controller
{
    public function getDivisionWiseDistrictDropdown(){
        $divisionID = $_GET['divisionID'];
        $districts = District::GetAllDivisionWiseDistrictDropdownData($divisionID);
        return $districts;
    }
}
