<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProjectResource::collection(
            Project::all()
        );
    }

    /**
     * Display a listing of projects for the authenticated user.
     */
    public function auth() : AnonymousResourceCollection
    {
        return ProjectResource::collection(
            Project::where('user_id', Auth::id())->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        $requestValifated = $request->validated();
        if ($request->hasFile("image"))
        {
            $imagePath = $request->file('image')->store('images', 'public');
            $requestValifated['image'] = $imagePath;
        }

        if ($request->hasFile('filePath'))
        {
            $filePath = $request->file('filePath')->store('files', 'public');
            $requestValifated['filePath'] = $filePath;
        }

        return ProjectResource::make(
            Project::create(array_merge(
                $requestValifated,
                ['user_id' => Auth::id()]
            ))
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return ProjectResource::make($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $project->update($request->validated());
        return ProjectResource::make(
            $project->refresh()
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($project->image)
        {
            Storage::disk('public')->delete($project->image);
        }

        if ($project->filePath)
        {
            Storage::disk('public')->delete($project->filePath);
        }

        return $project->delete();
    }
}
