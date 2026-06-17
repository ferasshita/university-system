<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubsystemRequest;
use App\Http\Requests\UpdateSubsystemRequest;
use App\Models\Subsystem;
use App\Jobs\AuditLogJob;
use Illuminate\Http\Request;

class SubsystemController extends Controller
{
    public function index(Request $request)
    {
        $query = Subsystem::query();
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%");
        }
        $subsystems = $query->paginate(15);
        return view('subsystems.index', compact('subsystems'));
    }

    public function create()
    {
        return view('subsystems.create');
    }

    public function store(StoreSubsystemRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = auth()->id();

        $subsystem = Subsystem::create($validated);

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'subsystem.created',
            'resource_type' => 'subsystem',
            'resource_id' => $subsystem->id,
            'new_data' => $subsystem->toArray(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return redirect()->route('subsystems.index')->with('success', __('Subsystem created successfully.'));
    }

    public function show(Subsystem $subsystem)
    {
        return view('subsystems.show', compact('subsystem'));
    }

    public function edit(Subsystem $subsystem)
    {
        return view('subsystems.edit', compact('subsystem'));
    }

    public function update(UpdateSubsystemRequest $request, Subsystem $subsystem)
    {
        $oldData = $subsystem->toArray();
        $subsystem->update($request->validated());

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'subsystem.updated',
            'resource_type' => 'subsystem',
            'resource_id' => $subsystem->id,
            'old_data' => $oldData,
            'new_data' => $subsystem->toArray(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return redirect()->route('subsystems.index')->with('success', __('Subsystem updated successfully.'));
    }

    public function toggleActive(Subsystem $subsystem)
    {
        $oldData = $subsystem->toArray();
        $subsystem->is_active = !$subsystem->is_active;
        $subsystem->save();

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'subsystem.toggled',
            'resource_type' => 'subsystem',
            'resource_id' => $subsystem->id,
            'old_data' => $oldData,
            'new_data' => $subsystem->toArray(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return redirect()->route('subsystems.index')->with('success', __('Subsystem status toggled.'));
    }

    public function destroy(Subsystem $subsystem)
    {
        $oldData = $subsystem->toArray();
        $subsystem->delete();

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'subsystem.deleted',
            'resource_type' => 'subsystem',
            'resource_id' => $subsystem->id,
            'old_data' => $oldData,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return redirect()->route('subsystems.index')->with('success', __('Subsystem deleted successfully.'));
    }
}
