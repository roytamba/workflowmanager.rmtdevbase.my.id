<?php

namespace App\Http\Controllers;

use App\Models\ProjectDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProjectDetailController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|integer',
            'project_type' => 'required|in:web,desktop,mobile,embedded',
            'status' => 'nullable|in:draft,in_progress,completed,on_hold,cancelled',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'deployment_status' => 'nullable|in:none,uat,live',
            'uat_link' => 'nullable|url',
            'live_link' => 'nullable|url',
            'checkout_link' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('validation_errors', $validator->errors()->all())
                ->withInput();
        }

        try {
            $imagePath = null;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->store('project/images', 'public');
            }

            ProjectDetail::create([
                'project_id' => $request->project_id,
                'project_type' => $request->project_type,
                'status' => $request->status,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'deployment_status' => $request->deployment_status,
                'uat_link' => $request->uat_link,
                'live_link' => $request->live_link,
                'checkout_link' => $request->checkout_link,
                'image' => $image,
            ]);

            return redirect()->back()->with('success', 'Project Detail created successfully!');
        } catch (Exception $e) {
            Log::error('Project Detail creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create project detail.');
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'project_type' => 'required|in:web,desktop,mobile,embedded',
            'status' => 'nullable|in:draft,in_progress,completed,on_hold,cancelled',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'deployment_status' => 'nullable|in:none,uat,live',
            'uat_link' => 'nullable|url',
            'live_link' => 'nullable|url',
            'checkout_link' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $detail = ProjectDetail::findOrFail($id);

            // Handle image upload & delete old
            if ($request->hasFile('image')) {
                if ($detail->image && Storage::disk('public')->exists($detail->image)) {
                    Storage::disk('public')->delete($detail->image);
                }

                $image = $request->file('image');
                $detail->image = $image->store('project/images', 'public');
            }

            $detail->update([
                'project_type' => $request->project_type,
                'status' => $request->status,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'deployment_status' => $request->deployment_status,
                'uat_link' => $request->uat_link,
                'live_link' => $request->live_link,
                'checkout_link' => $request->checkout_link,
                // image sudah di-set di atas
            ]);

            return redirect()->back()->with('success', 'Project Detail updated successfully!');
        } catch (Exception $e) {
            Log::error('Project Detail update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update project detail.');
        }
    }

    public function destroy($id)
    {
        try {
            $detail = ProjectDetail::findOrFail($id);

            if ($detail->image && Storage::disk('public')->exists($detail->image)) {
                Storage::disk('public')->delete($detail->image);
            }

            $detail->delete();

            return redirect()->back()->with('success', 'Project Detail deleted successfully!');
        } catch (Exception $e) {
            Log::error('Project Detail deletion failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete project detail.');
        }
    }
}
