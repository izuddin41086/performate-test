<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\ProjectDetails;
use App\Models\ProjectStatus;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;

class ProjectsController extends Controller
{
    use ApiResponser;

    public function index(){}

    public function create(){}

    public function store(Request $request)
    {
        if(!Auth::user()->can("Create Project")){
            return $this->error("Forbidden to create Project!", 403, []);
        }

        $requestAll = $request->all();

        $user = User::where("id", $requestAll["owner"])->first();
        if (!$user){
            return $this->error("User not found!", 403, []);
        }

        $attr = $request->validate([
            'title' => 'required|string|unique:projects|max:50',
            'owner' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $project = Project::create($requestAll);

        return $this->success($project,"Project successfully created!");
    }

    public function show(Project $project)
    {
        if(!Auth::user()->can("Read Project")){
            return $this->error("Forbidden to read Project!", 403, []);
        }

        $projectShow = Project::where("id",$project->id)
                        ->with(["user","project_details"])->first();

        return $this->success($projectShow, "Success");
    }

    public function edit(Project $project){}

    public function update(Request $request, Project $project)
    {
        if(!Auth::user()->can("Update Project")){
            return $this->error("Forbidden to update Project!", 403, []);
        }

        $attr = $request->validate([
            'title' => 'required|string|unique:projects|max:50',
            'owner' => 'required|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $requestAll = $request->all();
        $project->update($requestAll);
    
        return $this->success([],"Project successfully updated!");
    }

    public function finishing(Request $request)
    {
        if(!Auth::user()->can("Finishing Project")){
            return $this->error("Forbidden to delete Project!", 403, []);
        }

        $attr = $request->validate([
            'project_id' => 'required|integer',
            'completion_date' => 'required|date',
        ]);

        $requestAll = $request->all();
        $projectId = $requestAll["project_id"];

        $project = Project::where("id", $projectId)->first();
        if (!$project){
            return $this->error("Project not found!", 404, []);
        }

        $start_date = date_create($project["start_date"]);
        $end_date = date_create($project["end_date"]);
        $completion_date = date_create($requestAll["completion_date"]);

        $planned_duration = date_diff($start_date, $end_date)->format("%a");
        $actual_duration = date_diff($start_date, $completion_date)->format("%a");
        $onscheduleVal = ROUND(($planned_duration / $actual_duration) * 100, 0);

        $projectStatus = ProjectStatus::where("low_range", "<", $onscheduleVal)
                    ->where("high_range", ">", $onscheduleVal)->first();

        $projectDetails = ProjectDetails::where("project_id", $projectId)->delete();
        ProjectDetails::create([
            "project_id"=>$projectId,
            "completion_date"=>$requestAll["completion_date"],
            "planned_duration"=>$planned_duration,
            "actual_duration"=>$actual_duration,
            "on_schedule_status"=>$projectStatus["status_name"],
        ]);

        $projectShow = Project::where("id",$projectId)
                        ->with("project_details")->first();

        return $this->success($projectShow,"Project successfully finished!");
    }

    public function destroy(Project $project)
    {
        if(!Auth::user()->can("Delete Project")){
            return $this->error("Forbidden to delete Project!", 403, []);
        }
        ProjectDetails::where("project_id", $project->id)->delete();
        $project->delete();
        return $this->success([],"Project successfully deleted!");
    }
}
