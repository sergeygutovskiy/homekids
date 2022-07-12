<?php

namespace App\Http\Controllers\Client;

use App\Enums\FileCategory;
use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FileController extends Controller
{
    /**
     * Загрузить файл
     *
     * @group Файлы
     * @authenticated
     *
     * @bodyParam file file required Файл
     * @bodyParam category string required Категория ['job_project_photo'] Example: job_project_photo
     * 
     */
    public function store(Request $request)
    {
        $fileCategories = [ 
            FileCategory::JOB_PROJECT_PHOTO 
        ];

        $validator = Validator::make($request->all(), [
            'file' => ['file'],
            'category' => Rule::in($fileCategories) 
        ]);

        if ( $validator->fails() ) 
        {
            return response()->json([
                'error' => 'Ошибка валидации',
                'data' => null,
                'meta' => $validator->errors()
            ], 400);
        }

        $file = $request->file('file');
        $fileCategory = $request->input('category');

        $pathToSave = 'users/' . $request->user()->id . '/' . $fileCategory; 
        $savedFilePath = $file->store($pathToSave, 'public');

        if ( !$savedFilePath ) {
            return response()->json([
                'error' => 'Не удалось сохранаить файл',
                'data' => null
            ], 400);
        }

        File::create([
            'path' => $savedFilePath,
            'original_name' => $file->getClientOriginalName(), 
        ]);

        return response()->json([
            'error' => null,
            'data' => [
                'path' => $savedFilePath,
            ]
        ]);
    }
}
