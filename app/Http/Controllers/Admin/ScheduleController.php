<?php

namespace App\Http\Controllers\Admin;

use App\Models\Schedule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // abort_if(Gate::denies('schedule_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //$schedules = Schedule::orderByRaw("CASE WHEN status = 'available' THEN 1 ELSE 2 END")->get();
        $schedules = Schedule::all();
        //return view('admin.index', compact('schedules'));
        return view('admin.schedule.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       // abort_if(Gate::denies('schedule_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.schedule.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //abort_if(Gate::denies('schedule_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Ubah format tanggal ke 'yyyy-mm-dd'
        $date = \DateTime::createFromFormat('d-m-Y', $request->input('date'))->format('Y-m-d');
    
        Schedule::create([
            'date' => $date,
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'max_slot' => $request->input('max_slot') // Tambahkan nilai 'max_slot'
        ]);
    
        return redirect()->route('admin.schedule.index')->with('message', "Schedule Successfully Created !");
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        return redirect()->route('admin.schedule.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        //abort_if(Gate::denies('schedule_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.schedule.edit', compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        // Validasi input
        $request->validate([
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'max_slot' => 'required'
        ]);
    
        // Periksa apakah jumlah slot yang baru lebih besar dari jumlah slot yang sudah digunakan
        if ($request->max_slot > $schedule->used_slot) {
            // Jika lebih besar, maka ubah status menjadi "available"
            $request->merge(['status' => 'available']);
        }
    
        // Update schedule
        $schedule->update([
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'max_slot' => $request->max_slot,
            'status' => $request->status // Ubah status sesuai dengan logika di atas
        ]);
    
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.schedule.index')->with('message', "Schedule Successfully Updated !");
    }
    


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        //abort_if(Gate::denies('schedule_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schedule->delete();

        return redirect()->route('admin.schedule.index')->with('message', "Schedule Successfully Deleted !");
    }
}
