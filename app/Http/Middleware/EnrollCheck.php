<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnrollCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
    
        if (!$user) {
            // User is not authenticated
            return redirect()->route('login'); // Redirect to the login page or handle it as needed
        }

        // Check if the user is a student
        if ($user->type !== 'user') {
            return $next($request); // Allow other users to freely enter the course.show page
        }
    
        $courseId = $request->route('course');
        
        // Ensure that the 'courses' relationship is eager-loaded
        $user->load('courses');
    
        if (!$user->courses->contains($courseId)) {
            // User is not enrolled in the course
            return redirect()->route('courses.index')->with('error', 'You are not enrolled in this course.');
        }
    
        return $next($request);
    }
    

}
