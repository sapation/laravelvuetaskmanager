<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function store(Request $request) {

        return DB::transaction(function() use($request){
            $fields = $request->all();
            $errors = Validator::make($fields, [
                'name' => 'required',
                'projectId' => 'required|numeric',
                'memberIds' => 'required|array',
                'memberIds.*' => 'numeric'
            ]);

            if ($errors->fails()) {
                return response($errors->errors()->all(), 422);
            }

            $task = Task::create([
                'projectId' => $fields['projectId'],
                'name' => $fields['name'],
                'status' => Task::NOT_STARTED,
            ]);

            $members = $fields['memberIds'];
            for ($i = 0; $i < count($members); $i++) {
                TaskMember::create([
                    "projectId" => $fields['projectId'],
                    "taskId" => $task->id,
                    "memberId" => $members[$i]
                ]);
            }

            return response(['data' => $task, 'message' => 'Task created'], 200);
        });
    }

    public function taskNotStartedToPending(Request $request) {
        Task::changeTaskStatic($request->id, Task::PENDING);
        return response(['message'=>'Task move to pending'], 200);
    }

    public function taskNotStartedToCompleted(Request $request) {
        Task::changeTaskStatic($request->id, Task::COMPLETED);
        return response(['message'=>'Task move to completed'], 200);
    }

    public function taskPendingToCompleted(Request $request) {
        Task::changeTaskStatic($request->id, Task::COMPLETED);
        return response(['message'=>'Task move to completed'], 200);
    }

    public function taskPendingToNotStart(Request $request) {
        Task::changeTaskStatic($request->id, Task::NOT_STARTED);
        return response(['message'=>'Task move to Not started'], 200);
    }

    public function taskCompletedToPending(Request $request) {
        Task::changeTaskStatic($request->id, Task::PENDING);
        return response(['message'=>'Task move to Pending'], 200);
    }

    public function taskCompletedToNotStart(Request $request) {
        Task::changeTaskStatic($request->id, Task::NOT_STARTED);
        return response(['message'=>'Task move to Not started'], 200);
    }
}
