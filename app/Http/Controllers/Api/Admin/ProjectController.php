<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\Admin\Projects\CreateProjectRequest;
use App\Http\Requests\Api\Admin\Projects\DeleteProjectRequest;
use App\Http\Requests\Api\Admin\Projects\GetProjectRequest;
use App\Http\Requests\Api\Admin\Projects\GetProjectsRequest;
use App\Http\Requests\Api\Admin\Projects\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\ProjectItem;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\QueryParameter;
use Spatie\QueryBuilder\QueryBuilder;

#[Group(name: 'Projects', weight: 11)]
class ProjectController extends ApiController
{
    protected const INCLUDES = [
        'order',
        'quote',
    ];

    /**
     * List Projects
     */
    #[QueryParameter('per_page', 'How many items to show per page.', type: 'int', default: 15, example: 20)]
    #[QueryParameter('page', 'Which page to show.', type: 'int', example: 2)]
    public function index(GetProjectsRequest $request)
    {
        $projects = QueryBuilder::for(ProjectItem::class)
            ->allowedFilters(['id', 'status', 'order_id', 'quote_id'])
            ->allowedIncludes($this->allowedIncludes(self::INCLUDES))
            ->allowedSorts(['id', 'created_at', 'updated_at', 'status'])
            ->simplePaginate(request('per_page', 15));

        return ProjectResource::collection($projects);
    }

    /**
     * Create a new project
     */
    public function store(CreateProjectRequest $request)
    {
        $project = ProjectItem::create($request->validated());

        return new ProjectResource($project);
    }

    /**
     * Show a specific project
     */
    public function show(GetProjectRequest $request, ProjectItem $project)
    {
        $project = QueryBuilder::for(ProjectItem::class)
            ->allowedIncludes($this->allowedIncludes(self::INCLUDES))
            ->findOrFail($project->id);

        return new ProjectResource($project);
    }

    /**
     * Update a specific project
     */
    public function update(UpdateProjectRequest $request, ProjectItem $project)
    {
        $project->update($request->validated());

        return new ProjectResource($project);
    }

    /**
     * Delete a specific project
     */
    public function destroy(DeleteProjectRequest $request, ProjectItem $project)
    {
        $project->delete();

        return $this->returnNoContent();
    }
}
