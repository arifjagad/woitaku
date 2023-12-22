<?php

namespace App\Http\Controllers\EventOrganizerControllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\DetailCompetition;
use App\Models\CompetitionCategory;
use Illuminate\Http\Request;
use DOMDocument;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailEvent;
use HTMLPurifier_Config;
use HTMLPurifier;

class CompetitionEOController extends Controller
{
    public function indexCompetitionEO(){
        $userId = Auth::id();

        $dataCompetition = DB::table('detail_competition')
            ->join('competition_category', 'detail_competition.id_competition_category', '=', 'competition_category.id')
            ->join('detail_event', 'detail_competition.id_event', '=', 'detail_event.id')
            ->where('detail_event.id_eo', '=', $userId)
            ->select('detail_competition.*', 'detail_event.event_name', 'competition_category.category_name')
            ->get();

        return view('event_organizer.competition.competition-eo', compact('dataCompetition'), ['type_menu' => 'competition-eo']);
    }

    public function createCompetitionEO(){
        $user = Auth::user();
        $dataEvent = DB::table('detail_event')
            ->where('detail_event.id_eo', $user->id)
            ->get();

        $dataCompetitionCategory = CompetitionCategory::all();

        if($dataEvent->isEmpty()){
            toast('You must create an event first!', 'error');
            return redirect()->route('event-eo');
        }else{
            return view('event_organizer.competition.create-competition-eo', compact('dataEvent', 'dataCompetitionCategory'), ['type_menu' => 'competition-eo']);
        }
    }

    public function storeCompetitionEO(Request $request){
        $selectedEventId = $request->input('event_name');
        $selectedCompetitionCategoryId = $request->input('competition_category');
            
        try {
            $this->validate($request, [
                'competition_name' => 'required|max:50',
                'competition_category' => 'required',
                'competition_description' => 'required',
                'competition_start_date' => 'required',
                'competition_end_date' => 'required',
                'competition_fee' => 'required',
                'participant_qty' => 'required',
                'event_name' => 'required',
            ]);

            // Upload data dari summernote untuk deskripsi event
            $competition_description = $request->competition_description;

            $config = HTMLPurifier_Config::createDefault();
            $purifier = new HTMLPurifier($config);
            $competition_description = $purifier->purify($competition_description);

            $dom = new DOMDocument();
            if (!empty($competition_description)) {
                $dom->loadHTML($competition_description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            }

            $images = $dom->getElementsByTagName('img');

            foreach ($images as $key => $img) {
                if (strpos($img->getAttribute('src'),'data:image/') === 0) {
                    $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                    $image_name = "/upload/" . time() . $key . '.png';
                    file_put_contents(public_path() . $image_name, $data);

                    $img->removeAttribute('src');
                    $img->setAttribute('src', $image_name);
                }
            }

            $competition_description = $dom->saveHTML();

            // Post ke database
            DetailCompetition::create([
                'id_event' => $selectedEventId,
                'competition_name' => $request->competition_name,
                'id_competition_category' => $selectedCompetitionCategoryId,
                'competition_description' => $competition_description,
                'competition_start_date' => $request->competition_start_date,
                'competition_end_date' => $request->competition_end_date,
                'competition_fee' => $request->competition_fee,
                'participant_qty' => $request->participant_qty,
                'id_category' => 2
            ]);


            toast('Competition Successfully Created!', 'success');
            return redirect()->route('competition-eo');

        } catch (\Illuminate\Validation\ValidationException $e) {
            toast('Validation Failed!', 'error');
            return redirect()->back()->withErrors($e->errors())->withInput($request->all());
        }
    }

    public function editCompetitionEO($id){

        $dataCompetition = DetailCompetition::find($id);

        $dataEvent = DetailEvent::select('id', 'event_name')
            ->where('id_eo', Auth::id())
            ->get();

        $selectedEvent = DB::table('detail_competition')
            ->join('detail_event', 'detail_competition.id_event', '=', 'detail_event.id')
            ->where('detail_competition.id', '=', $id)
            ->get();

        $dataCompetitionCategory = CompetitionCategory::all();

        $selectCompetitionCategory = DB::table('detail_competition')
            ->join('competition_category', 'detail_competition.id_competition_category', '=', 'competition_category.id')
            ->where('detail_competition.id', '=', $id)
            ->get();

        return view(
            'event_organizer.competition.edit-competition-eo', 
            compact(
                'dataCompetition',
                'dataEvent',
                'selectedEvent',
                'dataCompetitionCategory',
                'selectCompetitionCategory'
            ), 
            ['type_menu' => 'competition-eo']
        );
    }
    
    public function updateCompetitionEO(Request $request){
        $selectedEventId = $request->input('event_name');
        $selectedCompetitionCategoryId = $request->input('competition_category');
            
        try {
            $this->validate($request, [
                'competition_name' => 'required|max:50',
                'competition_category' => 'required',
                'competition_description' => 'required',
                'competition_start_date' => 'required',
                'competition_end_date' => 'required',
                'competition_fee' => 'required',
                'participant_qty' => 'required',
                'event_name' => 'required',
            ]);

            // Upload data dari summernote untuk deskripsi event
            $competition_description = $request->competition_description;

            $config = HTMLPurifier_Config::createDefault();
            $purifier = new HTMLPurifier($config);
            $competition_description = $purifier->purify($competition_description);

            $dom = new DOMDocument();
            if (!empty($competition_description)) {
                $dom->loadHTML($competition_description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            }

            $images = $dom->getElementsByTagName('img');

            foreach ($images as $key => $img) {
                if (strpos($img->getAttribute('src'),'data:image/') === 0) {
                    $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                    $image_name = "/upload/" . time() . $key . '.png';
                    file_put_contents(public_path() . $image_name, $data);

                    $img->removeAttribute('src');
                    $img->setAttribute('src', $image_name);
                }
            }

            $competition_description = $dom->saveHTML();

            // Post ke database
            DetailCompetition::create([
                'id_event' => $selectedEventId,
                'competition_name' => $request->competition_name,
                'id_competition_category' => $selectedCompetitionCategoryId,
                'competition_description' => $competition_description,
                'competition_start_date' => $request->competition_start_date,
                'competition_end_date' => $request->competition_end_date,
                'competition_fee' => $request->competition_fee,
                'participant_qty' => $request->participant_qty,
                'id_category' => 2
            ]);


            toast('Competition Successfully Updated!', 'success');
            return redirect()->route('competition-eo');

        } catch (\Illuminate\Validation\ValidationException $e) {
            toast('Validation Failed!', 'error');
            return redirect()->back()->withErrors($e->errors())->withInput($request->all());
        }
    }

    public function deleteCompetitionEO($id){
        $dataCompetition = DetailCompetition::find($id);
        $dataCompetition->delete();

        toast('Competition Successfully Deleted!', 'success');
        return redirect()->route('competition-eo');
    }
}