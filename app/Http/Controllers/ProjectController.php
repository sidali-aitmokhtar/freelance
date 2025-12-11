<?php

namespace App\Http\Controllers;

use App\Filters\ProjectFilter;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Services\ProjectService;
use Symfony\Component\HttpFoundation\RequestMatcher\QueryParameterRequestMatcher;

class ProjectController extends Controller
{
    public function __construct(
        private readonly ProjectService $projectService
    ){}


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,ProjectFilter $filter)
    {
        try{
            $projects=$this->projectService->getProjects($filter);
            return response()->json([
                'success' => true,
                'message' => 'Projects retrieved successfully',
                'data' => $projects
            ], 200);
        }catch(\Exception $e){   
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],$e->getCode()?:500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        try{
            $project=$this->projectService->createProject($request);
            return response()->json([
                'success'=>true,
                'message'=>'project created successfully',
                'data'=>$project
            ],201);
        }catch(\Exception $e){
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage()
            ],$e->getCode()?:500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, Project $project)
    {
        try{
            $project=$this->projectService->updateProject($request,$project);
            return response()->json([
                'success'=>true,
                'message'=>'project updated successfully',
                'data'=>$project
            ],200);
        }catch(\Exception $e){
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage()
            ],$e->getCode()?:500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectRequest $request,Project $project)
    {
        try{
            $this->projectService->deleteProject($request,$project);
            return response()->json([
                'success'=>true,
                'message'=>'project delted successfully'
            ],200);
        }catch(\Exception $e){
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage()
            ],$e->getCode()?:500);
        }
    }

}
