<?php

namespace App\Http\Controllers\EventOrganizerControllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\DetailCompetition;
use Illuminate\Http\Request;
use DOMDocument;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailEvent;
use HTMLPurifier_Config;
use HTMLPurifier;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CompetitionEOController extends Controller
{
    public function indexCompetitionEO(){
        $userId = Auth::id();

        $dataCompetition = DB::table('detail_competition')
            ->join('detail_event', 'detail_competition.id_event', '=', 'detail_event.id')
            ->where('detail_event.id_eo', '=', $userId)
            ->select('detail_competition.*', 'detail_event.event_name')
            ->get();

        return view('event_organizer.competition.competition-eo', compact('dataCompetition'), ['type_menu' => 'competition-eo']);
    }

    public function createCompetitionEO(){
        $user = Auth::user();
        $dataEvent = DB::table('detail_event')
            ->where('detail_event.id_eo', $user->id)
            ->get();

        if($dataEvent->isEmpty()){
            toast('Harus memiliki event terlebih dahulu', 'error');
            return redirect()->route('event-eo');
        }else{
            return view('event_organizer.competition.create-competition-eo', compact('dataEvent'), ['type_menu' => 'competition-eo']);
        }
    }

    public function storeCompetitionEO(Request $request){
        $selectedEventId = $request->input('event_name');
            
        try {
            $this->validate($request, [
                'thumbnail_competition' => 'required|image|mimes:jpeg,png,jpg|max:3000',
                'competition_name' => 'required|max:100',
                'competition_description' => 'required',
                'competition_start_date' => 'required|date|after_or_equal:' . Carbon::now()->format('Y-m-d'),
                'competition_end_date' => 'required|date|after_or_equal:competition_start_date',
                'competition_fee' => 'max:9',
                'participant_qty' => 'max:9',
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

            // Upload thumbnail
            if ($request->hasFile('thumbnail_competition')) {
                $file = $request->file('thumbnail_competition');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePathThumbnailCompetition = 'event_organizer/competition/' . $fileName;

                Storage::disk('public')->put($filePathThumbnailCompetition, File::get($file));
            }

            // Post ke database
            DetailCompetition::create([
                'id_event' => $selectedEventId,
                'thumbnail_competition' => $filePathThumbnailCompetition,
                'competition_name' => $request->competition_name,
                'competition_description' => $competition_description,
                'competition_start_date' => $request->competition_start_date,
                'competition_end_date' => $request->competition_end_date,
                'competition_fee' => $request->competition_fee,
                'participant_qty' => $request->participant_qty,
                'id_category' => 2
            ]);


            toast('Berhasil membuat perlombaan', 'success');
            return redirect()->route('competition-eo');

        } catch (\Illuminate\Validation\ValidationException $e) {
            toast('Validasi gagal', 'error');
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

        return view(
            'event_organizer.competition.edit-competition-eo', 
            compact(
                'dataCompetition',
                'dataEvent',
                'selectedEvent',
            ), 
            ['type_menu' => 'competition-eo']
        );
    }
    
    public function updateCompetitionEO(Request $request, $competitionId){
        $selectedEventId = $request->input('event_name');
            
        try {
            $this->validate($request, [
                'thumbnail_competition' => 'image|mimes:jpeg,png,jpg|max:3000',
                'competition_name' => 'required|max:100',
                'competition_description' => 'required',
                'competition_start_date' => 'required|date|after_or_equal:' . Carbon::now()->format('Y-m-d'),
                'competition_end_date' => 'required|date|after_or_equal:competition_start_date',
                'competition_fee' => 'nullable|max:9',
                'participant_qty' => 'required|max:9',
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

            // Upload thumbnail
            if ($request->hasFile('thumbnail_competition')) {
                $file = $request->file('thumbnail_competition');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePathThumbnailCompetition = 'event_organizer/competition/' . $fileName;

                Storage::disk('public')->put($filePathThumbnailCompetition, File::get($file));
            }

            // Update ke database
            $competition = DetailCompetition::find($competitionId);
            $competition->update([
                'id_event' => $selectedEventId,
                'thumbnail_competition' => $filePathThumbnailCompetition ?? $competition->thumbnail_competition,
                'competition_name' => $request->competition_name,
                'competition_description' => $competition_description,
                'competition_start_date' => $request->competition_start_date,
                'competition_end_date' => $request->competition_end_date,
                'competition_fee' => $request->competition_fee,
                'participant_qty' => $request->participant_qty,
                'id_category' => 2
            ]);


            toast('Perlombaan berhasil diupdate', 'success');
            return redirect()->route('competition-eo');

        } catch (\Illuminate\Validation\ValidationException $e) {
            toast('Validasi gagal', 'error');
            return redirect()->back()->withErrors($e->errors())->withInput($request->all());
        }
    }

    public function deleteCompetitionEO($id){
        $dataCompetition = DetailCompetition::find($id);
        $dataCompetition->delete();

        toast('Perlombaan berhasil dihapus', 'success');
        return redirect()->route('competition-eo');
    }
}