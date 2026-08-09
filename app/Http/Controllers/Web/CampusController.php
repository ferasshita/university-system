<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampusRequest;
use App\Http\Requests\UpdateCampusRequest;
use App\Models\Campus;
use App\Jobs\AuditLogJob;
use Illuminate\Http\Request;

class CampusController extends Controller
{
    public function index(Request $request)
    {
        $query = Campus::query();
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
        }
        $campuses = $query->paginate(15);
        return view('campuses.index', compact('campuses'));
    }

    public function create()
    {
        return view('campuses.create');
    }

    public function store(StoreCampusRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = auth()->id();

        $campus = Campus::create($validated);

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'campus.created',
            'resource_type' => 'campus',
            'resource_id' => $campus->id,
            'new_data' => $campus->toArray(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return redirect()->route('campuses.index')->with('success', __('Campus created successfully.'));
    }

    public function show(Campus $campus)
    {
        return view('campuses.show', compact('campus'));
    }

    public function edit(Campus $campus)
    {
        return view('campuses.edit', compact('campus'));
    }

    public function update(UpdateCampusRequest $request, Campus $campus)
    {
        $oldData = $campus->toArray();
        $campus->update($request->validated());

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'campus.updated',
            'resource_type' => 'campus',
            'resource_id' => $campus->id,
            'old_data' => $oldData,
            'new_data' => $campus->toArray(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return redirect()->route('campuses.index')->with('success', __('Campus updated successfully.'));
    }

    public function destroy(Campus $campus)
    {
        $oldData = $campus->toArray();
        $campus->delete();

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'campus.deleted',
            'resource_type' => 'campus',
            'resource_id' => $campus->id,
            'old_data' => $oldData,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return redirect()->route('campuses.index')->with('success', __('Campus deleted successfully.'));
    }
}
