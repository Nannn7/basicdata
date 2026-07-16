<?php

namespace Modules\Basicdata\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Basicdata\Exports\DeveloperExport;
use Modules\Basicdata\Http\Requests\DeveloperRequest;
use Modules\Basicdata\Models\Developer;

class DeveloperController extends Controller
{
    protected $user;

    public function __construct()
    {
        // Mengatur middleware auth
        $this->middleware('auth');

        // Mengatur user setelah middleware auth dijalankan
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        // Check if the authenticated user has the required permission to view developers
        if (is_null($this->user) || !$this->user->can('basic-data.read')) {
            abort(403, 'Sorry! You are not allowed to view developers.');
        }

        return view('basicdata::developer.index');
    }

    public function store(DeveloperRequest $request)
    {
        // Check if the authenticated user has the required permission to create developers
        if (is_null($this->user) || !$this->user->can('basic-data.create')) {
            abort(403, 'Sorry! You are not allowed to create developers.');
        }

        $validate = $request->validated();

        if ($validate) {
            try {
                // Save to database
                Developer::create($validate);
                return redirect()
                    ->route('basicdata.developer.index')
                    ->with('success', 'Developer created successfully');
            } catch (Exception $e) {
                return redirect()
                    ->route('basicdata.developer.create')
                    ->with('error', 'Failed to create developer');
            }
        }
    }

    public function create()
    {
        // Check if the authenticated user has the required permission to create developers
        if (is_null($this->user) || !$this->user->can('basic-data.create')) {
            abort(403, 'Sorry! You are not allowed to create developers.');
        }

        return view('basicdata::developer.create');
    }

    public function edit($id)
    {
        // Check if the authenticated user has the required permission to update developers
        if (is_null($this->user) || !$this->user->can('basic-data.update')) {
            abort(403, 'Sorry! You are not allowed to update developers.');
        }

        $developer = Developer::findOrFail($id);
        return view('basicdata::developer.create', compact('developer'));
    }

    public function update(DeveloperRequest $request, $id)
    {
        // Check if the authenticated user has the required permission to update developers
        if (is_null($this->user) || !$this->user->can('basic-data.update')) {
            abort(403, 'Sorry! You are not allowed to update developers.');
        }

        $validate = $request->validated();

        if ($validate) {
            try {
                // Update in database
                $developer = Developer::find($id);
                $developer->update($validate);
                return redirect()
                    ->route('basicdata.developer.index')
                    ->with('success', 'Developer updated successfully');
            } catch (Exception $e) {
                return redirect()
                    ->route('basicdata.developer.edit', $id)
                    ->with('error', 'Failed to update developer');
            }
        }
    }

    public function destroy($id)
    {
        // Check if the authenticated user has the required permission to delete developers
        if (is_null($this->user) || !$this->user->can('basic-data.delete')) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry! You are not allowed to delete developers.'
            ], 403);
        }

        try {
            // Find and delete the developer
            $developer = Developer::find($id);
            $developer->delete();

            return response()->json(['success' => true, 'message' => 'Developer deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete developer']);
        }
    }

    public function deleteMultiple(Request $request)
    {
        // Check if the authenticated user has the required permission to delete developers
        if (is_null($this->user) || !$this->user->can('basic-data.delete')) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry! You are not allowed to delete developers.'
            ], 403);
        }

        $ids = $request->input('ids');

        Developer::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => 'Developers deleted successfully']);
    }

    public function dataForDatatables(Request $request)
    {
        // Check if the authenticated user has the required permission to view developers
        if (is_null($this->user) || !$this->user->can('basic-data.read')) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry! You are not allowed to view developers.'
            ], 403);
        }

        // Retrieve data from the database
        $query = Developer::query();

        // Apply search filter if provided
        if ($request->has('search') && !empty($request->get('search'))) {
            $search = json_decode($request->get('search'));

            if (isset($search->search)) {
                $search_ = strtolower($search->search);
                $query->where(function ($q) use ($search_) {
                    $q->whereRaw('LOWER(code) LIKE ?', ['%' . $search_ . '%']);
                    $q->orWhereRaw('LOWER(name) LIKE ?', ['%' . $search_ . '%']);
                });
            }
        }

        // Apply sorting if provided
        if ($request->has('sortOrder') && !empty($request->get('sortOrder'))) {
            $order = $request->get('sortOrder');
            $column = $request->get('sortField');
            $query->orderBy($column, $order);
        }

        // Get the total count of records
        $totalRecords = $query->count();

        // Apply pagination if provided
        if ($request->has('page') && $request->has('size')) {
            $page = $request->get('page');
            $size = $request->get('size');
            $offset = ($page - 1) * $size;

            $query->skip($offset)->take($size);
        }

        // Get the filtered count of records
        $filteredRecords = $query->count();

        // Get the data for the current page
        $data = $query->get();

        $data = $data->map(function ($item) {
            return [
                'id' => $item->id,
                'code' => $item->code,
                'name' => $item->name,
            ];
        });

        // Calculate the page count
        $pageCount = ceil($totalRecords / $request->get('size'));

        // Calculate the current page number
        $currentPage = $request->get('page') ?: 1;

        // Return the response data as a JSON object
        return response()->json([
            'draw' => $request->get('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'pageCount' => $pageCount,
            'page' => $currentPage,
            'totalCount' => $totalRecords,
            'data' => $data,
        ]);
    }

    public function export(Request $request)
    {
        // Check if the authenticated user has the required permission to export developers
        if (is_null($this->user) || !$this->user->can('basic-data.export')) {
            abort(403, 'Sorry! You are not allowed to export developers.');
        }

        // Get search parameter from request
        $search = $request->get('search');

        return Excel::download(new DeveloperExport($search), 'developer.xlsx');
    }
}
