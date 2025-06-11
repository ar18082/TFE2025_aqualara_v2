<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FileStorageFormRequest;
use App\Models\FileStorage;
use Illuminate\Http\Request;

class FileStorageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.file-storage.index', [
            'fileStorages' => FileStorage::orderBy('id')->paginate(25),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fileStorage = new FileStorage();

        return view('admin.file-storage.form', [
            'fileStorage' => $fileStorage,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FileStorageFormRequest $request)
    {
        dd($request);
        //        $fileStorage = FileStorage::create($request->validated());

        if ($request->validated()) {
            // Store files first
            $files = $request->file('files');

            foreach ($files as $file) {
                // $new_filename is unique and based on timestamp
                $new_filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                // check if folder exists

                //                $path = storage_path('app/public/uploads');
                $current_user = auth()->user()->id;

                $path_to_save = 'public/uploads';

                if (! is_dir(storage_path('app/'.$path_to_save))) {
                    mkdir(storage_path('app/'.$path_to_save), 0777, true);
                }

                $file->storeAs($path_to_save, $new_filename);

                // Create Entry in DB in FileStorage for each file
                // hash is md5 of file
                $hash = md5_file($file->getRealPath());

                $FileStorage = new FileStorage();

                $FileStorage->filename = $new_filename;
                $FileStorage->original_filename = $file->getClientOriginalName();
                $FileStorage->path = $path_to_save;
                $FileStorage->extension = $file->getClientOriginalExtension();
                $FileStorage->mime_type = $file->getMimeType();
                $FileStorage->size = $file->getSize();
                $FileStorage->hash = $hash;
                $FileStorage->description = $request->description;
                $FileStorage->is_public = false;
                $FileStorage->is_active = true;
                $FileStorage->user_id = $current_user;

                $FileStorage->save();

                //                dd($FileStorage);

            }
            //            dd('STOP');

        }

        $message = __('Le fichier :filename a été créé avec succès.', [
            'filename' => '$fileStorage->filename',
        ]);

        return to_route('admin.file_storage.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
