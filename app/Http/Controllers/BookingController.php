<?php

namespace App\Http\Controllers;

use App\Models\ScheduledClass;

class BookingController extends Controller
{
    public function create()
    {
        $scheduledClasses = ScheduledClass::where('date_time', '>', now())
            ->with('classType', 'instructor')
            ->oldest()->get();

        return view('member.book')->with('scheduledClasses', $scheduledClasses);
    }
}
