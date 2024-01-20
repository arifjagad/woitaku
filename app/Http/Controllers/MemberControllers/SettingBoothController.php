<?php

namespace App\Http\Controllers\MemberControllers;

use App\Http\Controllers\Controller;
use App\Models\DetailEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DetailBooth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SettingBoothController extends Controller
{
    public function indexSettingBooth()
    {
        $authId = auth()->user()->id;

        $dataBooth = DB::table('transaction')
            ->join('detail_event', 'detail_event.id', '=', 'transaction.id_event')
            ->join('booth_rental', 'booth_rental.id', '=', 'transaction.id_booth_rental')
            ->join('detail_booth', 'detail_booth.id_booth_rental', '=', 'booth_rental.id')
            ->where('transaction.transaction_status', '=', 'success')
            ->where('detail_booth.id_member', '=', $authId)
            ->orderBy('detail_booth.id', 'asc')
            ->get();

        return view ('member.detail.setting-booth', compact('dataBooth'), ['type_menu' => 'setting-booth']);
    }

// ...

public function updateDetailBooth(Request $request)
{
    $request->validate([
        'thumbnail_booth' => 'image|mimes:jpeg,png,jpg|max:3000',
        'booth_image.*' => 'nullable|image|mimes:jpeg,png,jpg',
        'booth_name' => 'required|string|max:255',
    ]);

    $detailBoothId = $request->input('booth_id');
    $detailBooth = DetailBooth::find($detailBoothId);

    // Upload thumbnail
    if ($request->hasFile('thumbnail_booth')) {
        $file = $request->file('thumbnail_booth');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePathThumbnailBooth = 'booth_images/' . $fileName;

        Storage::disk('public')->put($filePathThumbnailBooth, File::get($file));
    }

    $detailBooth->thumbnail_booth = $filePathThumbnailBooth ?? $detailBooth->thumbnail_booth;
    $detailBooth->booth_name = $request->input('booth_name');
    $detailBooth->booth_description = $request->input('booth_description');

    // Ambil gambar-gambar lama
    $existingImages = json_decode($detailBooth->booth_image, true) ?? [];

    // Proses upload dan simpan ke dalam storage hanya jika ada perubahan
    if ($request->hasFile('booth_image')) {
        $newImages = [];

        foreach ($request->file('booth_image') as $image) {
            $imageName = time() . '_' . $image->getClientOriginalName();
            $filePath = 'booth_images/' . $imageName;

            // Simpan gambar ke dalam storage
            Storage::disk('public')->put($filePath, File::get($image));

            $newImages[] = $imageName;
        }

        // Bandingkan apakah ada perubahan
        if ($existingImages != $newImages) {
            // Jika ada perubahan, gunakan data baru
            $detailBooth->booth_image = json_encode($newImages);
        }
    }

   

    $detailBooth->save();
    
    toast('Update Produk Booth Berhasil!', 'success');
    return redirect()->back();
}

    
}