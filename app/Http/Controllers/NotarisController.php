<?php

namespace Modules\Basicdata\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Basicdata\Exports\NotarisExport;
use Modules\Basicdata\Http\Requests\NotarisRequest;
use Modules\Basicdata\Models\Notaris;

class NotarisController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        if (is_null($this->user) || !$this->user->can('basic-data.read')) {
            abort(403, 'Sorry! You are not allowed to view notaris.');
        }

        return view('basicdata::notaris.index');
    }

    public function create()
    {
        if (is_null($this->user) || !$this->user->can('basic-data.create')) {
            abort(403, 'Sorry! You are not allowed to create notaris.');
        }

        return view('basicdata::notaris.create');
    }

    public function store(NotarisRequest $request)
    {
        if (is_null($this->user) || !$this->user->can('basic-data.create')) {
            abort(403, 'Sorry! You are not allowed to create notaris.');
        }

        $validate = $request->validated();

        if ($validate) {
            try {
                Notaris::create($validate);
                return redirect()
                    ->route('basicdata.notaris.index')
                    ->with('success', 'Notaris created successfully');
            } catch (Exception $e) {
                return redirect()
                    ->route('basicdata.notaris.create')
                    ->with('error', 'Failed to create notaris');
            }
        }
    }

    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('basic-data.update')) {
            abort(403, 'Sorry! You are not allowed to update notaris.');
        }

        $notaris = Notaris::findOrFail($id);
        return view('basicdata::notaris.create', compact('notaris'));
    }

    public function update(NotarisRequest $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('basic-data.update')) {
            abort(403, 'Sorry! You are not allowed to update notaris.');
        }

        $validate = $request->validated();

        if ($validate) {
            try {
                $notaris = Notaris::find($id);
                $notaris->update($validate);
                return redirect()
                    ->route('basicdata.notaris.index')
                    ->with('success', 'Notaris updated successfully');
            } catch (Exception $e) {
                return redirect()
                    ->route('basicdata.notaris.edit', $id)
                    ->with('error', 'Failed to update notaris');
            }
        }
    }

    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('basic-data.delete')) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry! You are not allowed to delete notaris.'
            ], 403);
        }

        try {
            $notaris = Notaris::find($id);
            $notaris->delete();

            return response()->json(['success' => true, 'message' => 'Notaris deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete notaris']);
        }
    }

    public function deleteMultiple(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('basic-data.delete')) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry! You are not allowed to delete notaris.'
            ], 403);
        }

        $ids = $request->input('ids');

        Notaris::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => 'Notaris deleted successfully']);
    }

    public function dataForDatatables(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('basic-data.read')) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry! You are not allowed to view notaris.'
            ], 403);
        }

        $query = Notaris::query();

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

        if ($request->has('sortOrder') && !empty($request->get('sortOrder'))) {
            $order = $request->get('sortOrder');
            $column = $request->get('sortField');
            $query->orderBy($column, $order);
        }

        $totalRecords = $query->count();

        if ($request->has('page') && $request->has('size')) {
            $page = $request->get('page');
            $size = $request->get('size');
            $offset = ($page - 1) * $size;

            $query->skip($offset)->take($size);
        }

        $filteredRecords = $query->count();

        $data = $query->get();

        $data = $data->map(function ($item) {
            return [
                'id' => $item->id,
                'code' => $item->code,
                'name' => $item->name,
            ];
        });

        $pageCount = ceil($totalRecords / $request->get('size'));
        $currentPage = $request->get('page') ?: 1;

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
        if (is_null($this->user) || !$this->user->can('basic-data.export')) {
            abort(403, 'Sorry! You are not allowed to export notaris.');
        }

        $search = $request->get('search');

        return Excel::download(new NotarisExport($search), 'notaris.xlsx');
    }
}
