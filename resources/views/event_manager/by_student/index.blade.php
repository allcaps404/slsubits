@extends('layouts.event_manager.index')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-700">Student Attendance Filter</h1>

    <form method="GET" class="grid grid-cols-1 md:grid-cols-6 gap-4 mb-6">
        <!-- Student Name -->
        <input type="text" name="student_name" value="{{ request('firstname') }}" placeholder="FirstName" class="input">
        <input type="text" name="student_name" value="{{ request('lastname') }}" placeholder="LastName" class="input">

        <!-- Student ID -->
        <input type="text" name="student_id" value="{{ request('student_id') }}" placeholder="ID Number" class="input">

        <!-- Course -->
        <input type="text" name="course" value="{{ request('course') }}" placeholder="Course" class="input">
        
        <select name="academic_year" class="input">
            <option value="">All Year</option>
            <option value="" {{ request('academic_year') == '' ? 'selected' : '' }}>Academic_year</option>
        </select>
    
        <select name="semester" class="input">
            <option value="">Semester</option>
            <option value="1st Semester" {{ request('semester') == '1st Semester' ? 'selected' : '' }}>1st Semester</option>
            <option value="2nd Semester" {{ request('semester') == '2nd Semester' ? 'selected' : '' }}>2nd Semester</option>
        </select>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded col-span-1">Filter</button>
    </form>

    <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
        <thead>
            <tr class="bg-blue-100 text-left text-sm uppercase font-semibold text-blue-700">
                <th class="px-4 py-2">ID Number</th>  
                <th class="px-4 py-2">FirstName</th>
                <th class="px-4 py-2">LastName</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
            <tr class="border-b">
                <td class="px-4 py-2">{{ $student->otherDetail->idnumber ?? '-' }}</td>
                <td class="px-4 py-2">{{ $student->firstname}}</td>
                <td class="px-4 py-2">{{ $student->lastname }}</td>
                <td class="px-4 py-2">
                    <a href="{{ route('event_manager.by_student.show', $student->id) }}" class="text-blue-600 hover:underline">View</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center py-4 text-gray-500">No students found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
