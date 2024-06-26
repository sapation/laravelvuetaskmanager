<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        $fields = $request->all();

        $errors = Validator::make($fields, [
            'name' => 'required',
            'startDate' => 'required',
            'endDate' => 'required',
        ]);

        if($errors->fails()) {
            return response($errors->errors()->all(), 422);
        }

        $project = Project::create([
            'name' => $fields['name'],
            'startDate' => $fields['startDate'],
            'endDate' => $fields['endDate'],
            'status' => Project::NOT_STARTED,
            'slug' => Project::createSlug($fields['name']),
        ]);

        return response(['message' => 'Project created'], 200);
    }

    public function update(Request $request)
    {
        $fields = $request->all();

        $errors = Validator::make($fields, [
            'id' => 'required',
            'name' => 'required',
            'startDate' => 'required',
            'endDate' => 'required',
        ]);

        if ($errors->fails()) {
            return response($errors->errors()->all(), 422);
        }

        $project = Project::where('id', $fields['id'])->update([
            'name' => $fields['name'],
            'startDate' => $fields['startDate'],
            'endDate' => $fields['endDate'],
            'slug' => Project::createSlug($fields['name']),
        ]);

        return response(['message' => 'Project updated'], 200);
    }
}
