<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DynamicFormController extends Controller
{
    /**
     * Get form structure by slug
     */
    public function show($slug)
    {
        try {
            $form = Form::with(['fields' => function($query) {
                $query->orderBy('order');
            }])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->first();

            if (!$form) {
                return response()->json([
                    'success' => false,
                    'message' => 'Form tidak ditemukan atau tidak aktif'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $form,
                'message' => 'Struktur form berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil struktur form',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Submit form data
     */
    public function submit(Request $request, $slug)
    {
        try {
            $form = Form::with('fields')->where('slug', $slug)->first();

            if (!$form) {
                return response()->json([
                    'success' => false,
                    'message' => 'Form tidak ditemukan'
                ], 404);
            }

            $rules = [];
            foreach ($form->fields as $field) {
                $fieldRules = [];
                if ($field->is_required) {
                    $fieldRules[] = 'required';
                } else {
                    $fieldRules[] = 'nullable';
                }

                if ($field->type === 'file') {
                    $fieldRules[] = 'file';
                    $fieldRules[] = 'max:10240';
                }

                $rules[$field->name] = implode('|', $fieldRules);
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $submittedData = [];
            foreach ($form->fields as $field) {
                if ($field->type === 'file' && $request->hasFile($field->name)) {
                    $path = $request->file($field->name)->store('dynamic-form-uploads', 'public');
                    $submittedData[$field->label] = $path;
                } else {
                    $submittedData[$field->label] = $request->input($field->name);
                }
            }

            FormSubmission::create([
                'form_id' => $form->id,
                'data' => $submittedData
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Form berhasil dikirim. Terima kasih!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim form',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
