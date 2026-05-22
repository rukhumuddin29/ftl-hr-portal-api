<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        return $this->success(Department::orderBy('name')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'description' => 'nullable|string',
            'status' => 'nullable|in:active,inactive'
        ]);

        $department = Department::create($validated);
        return $this->success($department, 'Department created successfully', 201);
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
            'description' => 'nullable|string',
            'status' => 'nullable|in:active,inactive'
        ]);

        $department->update($validated);
        return $this->success($department, 'Department updated successfully');
    }

    public function destroy(Department $department)
    {
        if ($department->users()->count() > 0) {
            return $this->error('Cannot delete department because users are assigned to it.', 400);
        }
        $department->delete();
        return $this->success(null, 'Department deleted successfully');
    }
}
