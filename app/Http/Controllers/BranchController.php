<?php

    namespace Modules\Basicdata\Http\Controllers;

    use App\Http\Controllers\Controller;
    use Exception;
    use Illuminate\Http\Request;
    use Maatwebsite\Excel\Facades\Excel;
    use Modules\Basicdata\Exports\BranchExport;
    use Modules\Basicdata\Http\Requests\BranchRequest;
    use Modules\Basicdata\Models\Branch;

    class BranchController extends Controller
    {
        protected $user;

        public function __construct()
        {
            $this->user = auth()->user();
        }

        public function index()
        {
            // Check if the authenticated user has the required permission to view branches
            if (is_null($this->user) || !$this->user->can('basic-data.read')) {
                abort(403, 'Sorry! You are not allowed to view branches.');
            }

            return view('basicdata::branch.index');
        }

        public function store(BranchRequest $request)
        {
            // Check if the authenticated user has the required permission to create branches
            if (is_null($this->user) || !$this->user->can('basic-data.create')) {
                abort(403, 'Sorry! You are not allowed to create branches.');
            }

            $validate = $request->validated();

            if ($validate) {
                try {
                    // Save to database
                    Branch::create($validate);
                    return redirect()
                        ->route('basicdata.branch.index')
                        ->with('success', 'Branch created successfully');
                } catch (Exception $e) {
                    return redirect()
                        ->route('basicdata.branch.create')
                        ->with('error', 'Failed to create branch');
                }
            }
        }

        public function create()
        {
            // Check if the authenticated user has the required permission to create branches
            if (is_null($this->user) || !$this->user->can('basic-data.create')) {
                abort(403, 'Sorry! You are not allowed to create branches.');
            }
            $branches = Branch::all();
            return view('basicdata::branch.create', compact('branches'));
        }

        public function edit($id)
        {
            // Check if the authenticated user has the required permission to update branches
            if (is_null($this->user) || !$this->user->can('basic-data.update')) {
                abort(403, 'Sorry! You are not allowed to update branches.');
            }

            $branch   = Branch::findOrFail($id);
            $branches = Branch::all();
            return view('basicdata::branch.create', compact('branch', 'branches'));
        }

        public function update(BranchRequest $request, $id)
        {
            // Check if the authenticated user has the required permission to update branches
            if (is_null($this->user) || !$this->user->can('basic-data.update')) {
                abort(403, 'Sorry! You are not allowed to update branches.');
            }

            $validate = $request->validated();

            // Tambahkan validasi manual untuk memeriksa parent_id
            if (isset($validate['parent_id']) && $validate['parent_id'] == $id) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['parent_id' => 'Cabang tidak dapat menjadi induk dari dirinya sendiri.']);
            }

            if ($validate) {
                try {
                    // Update in database
                    $branch = Branch::find($id);
                    $branch->update($validate);
                    return redirect()
                        ->route('basicdata.branch.index')
                        ->with('success', 'Branch updated successfully');
                } catch (Exception $e) {
                    return redirect()
                        ->route('basicdata.branch.edit', $id)
                        ->with('error', 'Failed to update branch');
                }
            }
        }

        public function destroy($id)
        {
            // Check if the authenticated user has the required permission to delete branches
            if (is_null($this->user) || !$this->user->can('basic-data.delete')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry! You are not allowed to delete branches.'
                ], 403);
            }

            try {
                // Find the branch
                $branch = Branch::find($id);

                // Check if the branch has children
                if ($branch->children()->exists()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cabang dengan anak cabang tidak dapat dihapus.'
                    ], 422);
                }

                // Delete from database
                $branch->delete();

                return response()->json(['success' => true, 'message' => 'Branch deleted successfully']);
            } catch (Exception $e) {
                return response()->json(['success' => false, 'message' => 'Failed to delete branch']);
            }
        }

        public function deleteMultiple(Request $request)
        {
            // Check if the authenticated user has the required permission to delete branches
            if (is_null($this->user) || !$this->user->can('basic-data.delete')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry! You are not allowed to delete branches.'
                ], 403);
            }

            $ids = $request->input('ids');

            // Check if any of the branches have children
            $branchesWithChildren = Branch::whereIn('id', $ids)
                ->whereHas('children')
                ->get();

            if ($branchesWithChildren->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Beberapa cabang memiliki anak cabang dan tidak dapat dihapus.'
                ], 422);
            }

            Branch::whereIn('id', $ids)->delete();
            return response()->json(['success' => true, 'message' => 'Branches deleted successfully']);
        }

        public function dataForDatatables(Request $request)
        {
            // Check if the authenticated user has the required permission to view branches
            if (is_null($this->user) || !$this->user->can('basic-data.read')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry! You are not allowed to view branches.'
                ], 403);
            }

            // Retrieve data from the database
            $query = Branch::query();

            // Apply search filter if provided
            if ($request->has('search') && !empty($request->get('search'))) {
                $search = $request->get('search');
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'LIKE', "%$search%");
                    $q->orWhere('name', 'LIKE', "%$search%");
                });
            }

            // Apply sorting if provided
            if ($request->has('sortOrder') && !empty($request->get('sortOrder'))) {
                $order  = $request->get('sortOrder');
                $column = $request->get('sortField');
                $query->orderBy($column, $order);
            }

            // Get the total count of records
            $totalRecords = $query->count();

            // Apply pagination if provided
            if ($request->has('page') && $request->has('size')) {
                $page   = $request->get('page');
                $size   = $request->get('size');
                $offset = ($page - 1) * $size; // Calculate the offset

                $query->skip($offset)->take($size);
            }

            // Get the filtered count of records
            $filteredRecords = $query->count();

            // Get the data for the current page
            $data = $query->get();

            $data = $data->map(function ($item) {
                return [
                    'id'        => $item->id,
                    'code'      => $item->code,
                    'name'      => $item->name,
                    'parent_id' => $item->parent?->name ?? null,
                ];
            });

            // Calculate the page count
            $pageCount = ceil($totalRecords / $request->get('size'));

            // Calculate the current page number
            $currentPage = 0 + 1;


            // Return the response data as a JSON object
            return response()->json([
                'draw'            => $request->get('draw'),
                'recordsTotal'    => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'pageCount'       => $pageCount,
                'page'            => $currentPage,
                'totalCount'      => $totalRecords,
                'data'            => $data,
            ]);
        }

        public function export()
        {
            // Check if the authenticated user has the required permission to export branches
            if (is_null($this->user) || !$this->user->can('basic-data.export')) {
                abort(403, 'Sorry! You are not allowed to export branches.');
            }

            return Excel::download(new BranchExport, 'branch.xlsx');
        }
    }
