<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use App\Models\User;
use App\Services\ProgramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function __construct(
        private ProgramService $programService
    ) {
    }

    public function index(): Response
    {
        return Inertia::render('Admin/Students/Index', [
            'programs' => $this->programService->getAsDropdown(),
        ]);
    }

    public function getDataTable(Request $request)
    {
        $query = Student::with(['user', 'program'])
        ->whereHas('user', function ($query) {
            $query->where('deleted_at', null);
        });

        // Apply search
        if ($request && $request->has('search')) {
            $query->where('full_name', 'like', '%' . $request->input('search') . '%')
                ->orWhere('student_number', 'like', '%' . $request->input('search') . '%');
        }

        if ($request && $request->has('sort_column') && $request->has('sort_direction')) {
            $query->orderBy($request->input('sort_column'), $request->input('sort_direction'));
        }


        $students = $query->paginate(10);
        return $students;
    }

    public function delete($id)
    {
        $student = Student::find($id);
    
        if ($student) {
            // Delete also user part
            $user = User::find($student->user_id);
            $user->delete();
            $user->save();
            $student->delete();
            $student->save();
        }

        return redirect()->route('admin.students')->with([
            'success' => [
                'header' => 'Student deleted successfully!',
                'message' => '',
            ]
        ]);
    }

    public function updateForumStatus($id, Request $request)
    {
        $student = Student::find($id);
        $data = $request->all();
        $forumStatus = $data['forumStatus'];
        $student->forum_status = $forumStatus;
        $student->save();

        return redirect()->route('admin.students')->with([
            'success' => [
                'header' => 'Updated successfully!',
                'message' => '',
            ]
        ]);
    }

    public function toggleStatus(Student $student)
    {
        // $student->toggleStatus();
        $user = $student->user;

        $user->status = $user->status == 1 ? 0 : 1;
        $user->save();

        $header = 'Student account set to inactive status';

        if ($user->status == 1) {
            $header = 'Student account set to active status';
        }

        return redirect()->route('admin.students')->with([
            'success' => [
                'header' => $header,
                'message' => '',
            ]
        ]);
    }

    public function update($id, UpdateStudentRequest $request)
    {
        $data = $request->all();
        DB::beginTransaction();
        $student = Student::find($id);

        $name = $data['first_name'] . ' ' . $data['last_name'];

        $student->student_number = $data['student_number'];
        $student->first_name = $data['first_name'];
        $student->last_name = $data['last_name'];
        $student->full_name = $name;
        $student->email = $data['email'];
        $student->program_id = $data['program_id'];
        $student->save();

        $user = $student->user;
        $user->email = $data['email'];
        $user->name = $name;
        $user->save();
        
        DB::commit();

        return redirect()->route('admin.students')->with([
            'success' => [
                'header' => 'Student data updated successfully!',
                'message' => '',
            ]
        ]);


    }
}
