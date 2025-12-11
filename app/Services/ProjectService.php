<?php

namespace App\Services;

use App\Models\Project;
use App\Filters\ProjectFilter;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Repositories\ProjectRepository;

class ProjectService extends BaseService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly ProjectRepository $projectRepository
    ){}

    public function getProjects(ProjectFilter $filter){
        
        return ProjectResource::collection($filter->apply(Project::query())->get());
    }

    public function getProject(){

    }
    
    public function createProject(ProjectRequest $request){
        $this->logwithcontext('creating a project',[
            'operation'=>'creation',
            'project_title'=>$request->title,
            'created_by'=>$request->user()->id
        ]);
        // $user=$request->user();
        $data=$request->validated();
        $data['client_id']=$request->user()->id;
        $project=$this->projectRepository->create($data);

        $this->loginfo('project created successfully',[
            'project_id'=>$project->id
        ]);

        return $project;
    }

    public function updateProject(ProjectRequest $request,$project){
        $this->logwithcontext('updating project',[
            'opperation'=>'update',
            'project_id'=>$project->id,
            'updated_by'=>$request->user()->id
        ]);
        if(!$project){
            $this->logerror('there is no project');
            throw new \Exception('there is no project',404);
        }
        $this->access($request,$project);
        $data = array_filter($request->validated(), fn($value) => !is_null($value));
        $updatedProject=$this->projectRepository->update($data,$project->id);

        if(!$updatedProject){
            $this->logerror('did not update');
            throw new \Exception('did not update',500); // 500 highlights that the repository failed to persist the update
        }

        $this->loginfo('updated successfully', ['project_id' => $updatedProject->id]);

        return $updatedProject;
    }

    public function deleteProject(ProjectRequest $request,$project){
        $this->logwithcontext('',[
            'operation'=>'deleting',
            'project_id'=>$project->id,
            'by'=>$request->user()->id
        ]);

        $this->access($request,$project);

        $this->projectRepository->delete($project->id);

        // if(){

        // }

        $this->loginfo('project deleted');

        return ;

    }

    private function access(ProjectRequest $request,$project){
        $user=$request->user();
        if($user->hasRole('admin')){
            $this->loginfo('admin has access');
            return ;
        }
        if($user->hasRole('client') && $user->id==$project->client_id){
            $this->loginfo('client has access to his own');
            return ;
        }
        $this->logerror('you are not the owner or an admin');
        throw new \Exception('you are not the owner or an admin',403);
    }
}
