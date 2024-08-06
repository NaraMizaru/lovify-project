<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Wedding;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function taskToProcess($id, $taskName)
    {
        $wedding = Wedding::where('id', $id)->first();

        if (!$wedding) {
            return response()->json(['message' => 'Wedding not found'], 404);
        }

        $task = Task::where('wedding_id', $wedding->id)->where('name', $taskName)->first();

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        if ($task->status === 'ready') {
            return response()->json(['message' => 'Task already marked as ready, cannot change to process'], 400);
        }

        $task->status = 'process';
        $task->save();

        return response()->json(['message' => 'Task marked as processed'], 200);
    }

    public function taskToReady($id, $taskName)
    {
        $wedding = Wedding::where('id', $id)->first();

        if (!$wedding) {
            return response()->json(['message' => 'Wedding not found'], 404);
        }

        $task = Task::where('wedding_id', $wedding->id)->where('name', $taskName)->first();

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        if ($task->status !== 'process') {
            return response()->json(['message' => 'Task must be in process status before marking as ready'], 400);
        }

        $task->status = 'ready';
        $task->save();

        return response()->json(['message' => 'Task marked as redied'], 200);
    }
}
