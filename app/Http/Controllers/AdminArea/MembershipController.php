<?php

namespace App\Http\Controllers\AdminArea;

use Illuminate\Http\Request;
use services\Callers\CategoryCaller;
use Illuminate\Support\Facades\DB;

class MembershipController extends ParentController
{
        public function all_plan()
    {
        // Fetch all records from the 'membership-plan' table
        $membershipPlans = DB::table('membership-plan')->get();
        $response['membershipPlans'] = $membershipPlans; 
        return view('AdminArea.pages.membership.all')->with($response);
    }

    public function add_plan()
    {
        return view('AdminArea.pages.membership.add');
    }

    public function store_plan(Request $request)
    {
        // Validation if needed
        $request->validate([
            'plan_name' => 'required',
            'yearly_price' => 'required',
            'monthly_price' => 'required',
            'plan_description' => 'required',
        ]);
        $data = $request->except('_token');
        $id = $request->input('id');
            if ($id && $id != '') {
            DB::table('membership-plan')->where('id', $id)->update($data);
        } else {
            DB::table('membership-plan')->insert($data);
        }
    
        return redirect('admin/add-plan')->with('alert-success', "Plan Save Successfully");
    }

    public function edit($id)
    {
        // Retrieve the membership based on the $id
        $response['membership'] = DB::table('membership-plan')->find($id);
        return view('AdminArea.pages.membership.add')->with($response);
    }

    public function delete($id)
    {
        // Delete the membership based on the $id
        DB::table('membership-plan')->where('id', $id)->delete();
        return redirect('admin/all-plan')->with('alert-success', "Membership Deleted Successfully");
    }
}
