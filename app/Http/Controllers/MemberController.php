<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    /**
     * Index Endpoint
     */
    public function index(Request $request)
    {
        $query = $request->get('query');
        //$members = Member::select('name', 'email');
        $members = DB::table('member');

        if (!is_null($query) && $query !== '') {
            $members->where('name', 'like', '%' . $query . '%')
                ->orderBy('id', 'desc');

            return response(['data' => $members->paginate(10)], 200);
        }

        return response(['data' => $members->paginate(10)], 200);
    }

    /**
     * Store Endpoint
     */
    public function store(Request $request)
    {
        $fields = $request->all();

        $errors = Validator::make($fields, [
            'name' => 'required',
            'email' => 'required|email',
        ]);

        if ($errors->fails()) {
            return response($errors->errors()->all(), 422);
        }

        $member = Member::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
        ]);

        return response(['data' => $member, 'message' => 'Member created'], 200);
    }

    /**
     * Update Endpoint
     */
    public function update(Request $request)
    {
        $fields = $request->all();

        $errors = Validator::make($fields, [
            'id' => 'required|numeric',
            'name' => 'required',
            'email' => 'required',
        ]);

        if ($errors->fails()) {
            return response($errors->errors()->all(), 422);
        }

        $member = Member::where('id', $fields['id'])->update([
            'name' => $fields['name'],
            'email' => $fields['email'],
        ]);

        return response(['data' => $member, 'message' => 'Member updated'], 200);
    }
}
