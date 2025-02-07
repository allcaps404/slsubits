@extends('layouts.student.index')


@section('content')
	<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <!-- Profile Card -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
     <div class="flex items-center space-x-4">
      <img alt="Profile picture of the user" class="w-24 h-24 rounded-full" height="100" src="https://storage.googleapis.com/a1aa/image/-sIyLA5A4mz6xqurmkfc_ic3NQ0nQ6u4WJJZtIN-zJo.jpg" width="100"/>
      <div>
       <h2 class="text-xl font-bold">
        Hello, {{ Auth::user()->firstname }}
       </h2>
       <p class="text-gray-600">
         {{ $otherdetails->course }}
       </p>
      </div>
     </div>
     <div class="mt-4">
      <h3 class="text-lg font-semibold">
       Contact Information
      </h3>
      <p class="text-gray-600">
       <i class="fas fa-envelope">
       </i>
       {{ Auth::user()->email }}
      </p>
      <p class="text-gray-600">
       <i class="fas fa-phone">
       </i>
       {{ $otherdetails->year }} Year |
       {{ $otherdetails->academic_year }},
       {{ $otherdetails->semester }} Semester
      </p>
     </div>
    </div>
   </div>
   <!-- Events Section -->
   <div class="mt-8">
    <h2 class="text-2xl font-bold mb-4">
     Attendances
    </h2>
    <div class="bg-white p-6 rounded-lg shadow-lg overflow-x-auto">
     <table class="min-w-full bg-white">
      <thead>
       <tr>
        <th class="py-2 px-4 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
         Event
        </th>
        <th class="py-2 px-4 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
         Date & Time
        </th>
        <th class="py-2 px-4 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
         Semester
        </th>
        <th class="py-2 px-4 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
         Academic Year
        </th>
        <th class="py-2 px-4 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
         Login
        </th>
        <th class="py-2 px-4 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
         Logout
        </th>
       </tr>
      </thead>
      <tbody>
       <tr>
        <td class="py-2 px-4 border-b border-gray-200">
         Tech Conference
        </td>
        <td class="py-2 px-4 border-b border-gray-200">
         2023-09-15 10:00 AM
        </td>
        <td class="py-2 px-4 border-b border-gray-200">
         Fall 2023
        </td>
        <td class="py-2 px-4 border-b border-gray-200">
         2023-2024
        </td>
        <td class="py-2 px-4 border-b border-gray-200">
         10:00 AM
        </td>
        <td class="py-2 px-4 border-b border-gray-200">
         12:00 PM
        </td>
       </tr>
       <tr>
        <td class="py-2 px-4 border-b border-gray-200">
         Workshop on AI
        </td>
        <td class="py-2 px-4 border-b border-gray-200">
         2023-10-01 02:00 PM
        </td>
        <td class="py-2 px-4 border-b border-gray-200">
         Fall 2023
        </td>
        <td class="py-2 px-4 border-b border-gray-200">
         2023-2024
        </td>
        <td class="py-2 px-4 border-b border-gray-200">
         02:00 PM
        </td>
        <td class="py-2 px-4 border-b border-gray-200">
         04:00 PM
        </td>
       </tr>
       <tr>
        <td class="py-2 px-4 border-b border-gray-200">
         Coding Bootcamp
        </td>
        <td class="py-2 px-4 border-b border-gray-200">
         2023-11-20 09:00 AM
        </td>
        <td class="py-2 px-4 border-b border-gray-200">
         Fall 2023
        </td>
        <td class="py-2 px-4 border-b border-gray-200">
         2023-2024
        </td>
        <td class="py-2 px-4 border-b border-gray-200">
         09:00 AM
        </td>
        <td class="py-2 px-4 border-b border-gray-200">
         05:00 PM
        </td>
       </tr>
      </tbody>
     </table>
    </div>
   </div>
   <!-- News Section -->
   <div class="mt-8">
    <h2 class="text-2xl font-bold mb-4">
     Latest News
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
     <div class="bg-white p-6 rounded-lg shadow-lg">
      <img alt="Image representing the news article" class="w-full h-40 object-cover rounded-lg mb-4" height="200" src="https://storage.googleapis.com/a1aa/image/M8ix0X2aIN7Sk24O6JPURBi-lqoUqKnFIjo5OSQch2w.jpg" width="300"/>
      <h3 class="text-xl font-semibold mb-2">
       Campus Reopening
      </h3>
      <p class="text-gray-600">
       The campus will reopen for in-person classes starting next semester.
      </p>
     </div>
     <div class="bg-white p-6 rounded-lg shadow-lg">
      <img alt="Image representing the news article" class="w-full h-40 object-cover rounded-lg mb-4" height="200" src="https://storage.googleapis.com/a1aa/image/M8ix0X2aIN7Sk24O6JPURBi-lqoUqKnFIjo5OSQch2w.jpg" width="300"/>
      <h3 class="text-xl font-semibold mb-2">
       New Library Resources
      </h3>
      <p class="text-gray-600">
       New resources have been added to the library, including e-books and journals.
      </p>
     </div>
     <div class="bg-white p-6 rounded-lg shadow-lg">
      <img alt="Image representing the news article" class="w-full h-40 object-cover rounded-lg mb-4" height="200" src="https://storage.googleapis.com/a1aa/image/M8ix0X2aIN7Sk24O6JPURBi-lqoUqKnFIjo5OSQch2w.jpg" width="300"/>
      <h3 class="text-xl font-semibold mb-2">
       Tech Conference
      </h3>
      <p class="text-gray-600">
       Join us for the annual tech conference featuring industry leaders.
      </p>
     </div>
    </div>
   </div>
@endsection