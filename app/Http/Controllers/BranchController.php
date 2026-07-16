<?php

    namespace Modules\Basicdata\Http\Controllers;

    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\Controller;
    use Exception;
    use Illuminate\Http\Request;
    use Maatwebsite\Excel\Facades\Excel;
    use Modules\Basicdata\Exports\BranchExport;
    use Modules\Basicdata\Http\Requests\BranchRequest;
    use Modules\Basicdata\Models\Branch;
    use Modules\Corsec\Models\ApprovalRequest;
    use Modules\Corsec\Services\ApprovalRequestService;

    class BranchController extends Controller
    {
        protected $user;
        private readonly ApprovalRequestService $approvalService;

        public function __construct()
        {
            // Mengatur middleware auth
            $this->middleware('auth');
            $this->approvalService = app(ApprovalRequestService::class);

            // Mengatur user setelah middleware auth dijalankan
            $this->middleware(function ($request, $next) {
                $this->user = Auth::user();
                return $next($request);
            });
        }

        public function index()
        {
            // Check if the authenticated user has the required permission to view branches
            if (is_null($this->user) || !$this->user->can('basic-data.read')) {
                abort(403, 'Sorry! You are not allowed to view branches.');
            }

            $parentBranches = Branch::query()
                ->orderBy('name')
                ->get(['id', 'name']);

            return view('basicdata::branch.index', compact('parentBranches'));
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
                    $this->approvalService->createRequest(
                        Branch::class,
                        ApprovalRequest::ACTION_CREATE,
                        null,
                        $validate,
                        null,
                        'Pengajuan create branch'
                    );
                    return redirect()
                        ->route('basicdata.branch.index')
                        ->with('success', 'Pengajuan branch berhasil dikirim untuk approval.');
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
            $branches = Branch::query()
                ->orderBy('name')
                ->get(['id', 'name']);
            return view('basicdata::branch.create', compact('branches'));
        }

        public function edit($id)
        {
            // Check if the authenticated user has the required permission to update branches
            if (is_null($this->user) || !$this->user->can('basic-data.update')) {
                abort(403, 'Sorry! You are not allowed to update branches.');
            }

            $branch   = Branch::findOrFail($id);
            $branches = Branch::query()
                ->whereKeyNot($branch->id)
                ->orderBy('name')
                ->get(['id', 'name']);
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
                    $branch = Branch::findOrFail($id);
                    $this->approvalService->createRequest(
                        Branch::class,
                        ApprovalRequest::ACTION_UPDATE,
                        (string) $branch->id,
                        $validate,
                        $branch->only(array_keys($validate)),
                        'Pengajuan update branch'
                    );
                    return redirect()
                        ->route('basicdata.branch.index')
                        ->with('success', 'Pengajuan perubahan branch berhasil dikirim untuk approval.');
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
            $query = Branch::query()
                ->select(['id', 'code', 'name', 'parent_id', 'address'])
                ->with('parent:id,name');
            $baseCountQuery = Branch::query();
            $searchPayload = $request->get('search');
            $search = is_string($searchPayload)
                ? json_decode($searchPayload, false)
                : $searchPayload;

            // Apply search filter if provided
            if (!empty($search)) {
                if (isset($search->search) && !empty($search->search)) {
                    $search_ = strtolower($search->search);
                    $query->where(function ($q) use ($search_) {
                        $q->whereRaw('LOWER(code) LIKE ?', ['%' . strtolower($search_) . '%']);
                        $q->orWhereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search_) . '%']);
                        $q->orWhereRaw('LOWER(address) LIKE ?', ['%' . strtolower($search_) . '%']);
                        $q->orWhereHas('parent', function ($q) use ($search_) {
                            $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search_) . '%']);
                        });
                    });
                }

                // Apply parent filter if provided
                if (isset($search->parent_id) && !empty($search->parent_id)) {
                    $parentId = $search->parent_id;
                    $query->where('parent_id', $parentId);
                }
            }

            // Apply sorting if provided
            if ($request->has('sortOrder') && !empty($request->get('sortOrder'))) {
                $order  = strtolower((string) $request->get('sortOrder'));
                $column = (string) $request->get('sortField');
                $allowedSort = ['code', 'name', 'parent_id', 'address'];

                if (!in_array($order, ['asc', 'desc'], true)) {
                    $order = 'asc';
                }

                if (!in_array($column, $allowedSort, true)) {
                    $column = 'name';
                }

                $query->orderBy($column, $order);
            } else {
                $query->orderBy('name');
            }

            $isFiltered = !empty($search?->search) || !empty($search?->parent_id);
            $totalRecords = $baseCountQuery->count();
            $filteredRecords = $isFiltered ? (clone $query)->count() : $totalRecords;

            $page = max((int) $request->get('page', 1), 1);
            $size = max((int) $request->get('size', 10), 1);

            // Apply pagination if provided
            // Get the data for the current page
            $data = $query
                ->forPage($page, $size)
                ->get();

            $data = $data->map(function ($item) {
                return [
                    'id'        => $item->id,
                    'code'      => $item->code,
                    'name'      => $item->name,
                    'parent_id' => $item->parent?->name ?? null,
                    'address'   => str_replace(']', "", $item->address),
                ];
            });

            // Calculate the page count
            $pageCount = (int) ceil($filteredRecords / max($size, 1));


            // Return the response data as a JSON object
            return response()->json([
                'draw'            => $request->get('draw'),
                'recordsTotal'    => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'pageCount'       => $pageCount,
                'page'            => $page,
                'totalCount'      => $totalRecords,
                'data'            => $data,
            ]);
        }

        public function export(Request $request)
        {
            // Check if the authenticated user has the required permission to export branches
            if (is_null($this->user) || !$this->user->can('basic-data.export')) {
                abort(403, 'Sorry! You are not allowed to export branches.');
            }

            // Get search parameter from request
            $search = $request->get('search');
            $parentId = $request->get('parent_id');

            return Excel::download(new BranchExport($search,$parentId), 'branch.xlsx');
        }
    }
