<?php

    namespace Modules\Basicdata\Http\Controllers;

    use App\Http\Controllers\Controller;
    use Exception;
    use Illuminate\Http\Request;
    use Maatwebsite\Excel\Facades\Excel;
    use Modules\Basicdata\Exports\CurrencyExport;
    use Modules\Basicdata\Http\Requests\CurrencyRequest;
    use Modules\Basicdata\Models\Currency;
    use Illuminate\Support\Facades\Auth;
    use Modules\Corsec\Models\ApprovalRequest;
    use Modules\Corsec\Services\ApprovalRequestService;

    class CurrencyController extends Controller
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
            // Check if the authenticated user has the required permission to view currencies
            if (is_null($this->user) || !$this->user->can('basic-data.read')) {
                abort(403, 'Sorry! You are not allowed to view currencies.');
            }

            return view('basicdata::currency.index');
        }

        public function store(CurrencyRequest $request)
        {
            // Check if the authenticated user has the required permission to create currencies
            if (is_null($this->user) || !$this->user->can('basic-data.create')) {
                abort(403, 'Sorry! You are not allowed to create currencies.');
            }

            $validate = $request->validated();

            if ($validate) {
                try {
                    $this->approvalService->createRequest(
                        Currency::class,
                        ApprovalRequest::ACTION_CREATE,
                        null,
                        $validate,
                        null,
                        'Pengajuan create currency'
                    );
                    return redirect()
                        ->route('basicdata.currency.index')
                        ->with('success', 'Pengajuan currency berhasil dikirim untuk approval.');
                } catch (Exception $e) {
                    return redirect()
                        ->route('basicdata.currency.create')
                        ->with('error', 'Failed to create currency');
                }
            }
        }

        public function create()
        {
            // Check if the authenticated user has the required permission to create currencies
            if (is_null($this->user) || !$this->user->can('basic-data.create')) {
                abort(403, 'Sorry! You are not allowed to create currencies.');
            }

            return view('basicdata::currency.create');
        }

        public function edit($id)
        {
            // Check if the authenticated user has the required permission to update currencies
            if (is_null($this->user) || !$this->user->can('basic-data.update')) {
                abort(403, 'Sorry! You are not allowed to update currencies.');
            }

            $currency = Currency::find($id);
            return view('basicdata::currency.create', compact('currency'));
        }

        public function update(CurrencyRequest $request, $id)
        {
            // Check if the authenticated user has the required permission to update currencies
            if (is_null($this->user) || !$this->user->can('basic-data.update')) {
                abort(403, 'Sorry! You are not allowed to update currencies.');
            }

            $validate = $request->validated();

            if ($validate) {
                try {
                    $currency = Currency::findOrFail($id);
                    $this->approvalService->createRequest(
                        Currency::class,
                        ApprovalRequest::ACTION_UPDATE,
                        (string) $currency->id,
                        $validate,
                        $currency->only(array_keys($validate)),
                        'Pengajuan update currency'
                    );
                    return redirect()
                        ->route('basicdata.currency.index')
                        ->with('success', 'Pengajuan perubahan currency berhasil dikirim untuk approval.');
                } catch (Exception $e) {
                    return redirect()
                        ->route('basicdata.currency.edit', $id)
                        ->with('error', 'Failed to update currency');
                }
            }
        }

        public function destroy($id)
        {
            // Check if the authenticated user has the required permission to delete currencies
            if (is_null($this->user) || !$this->user->can('basic-data.delete')) {
                return response()->json(['success' => false, 'message' => 'Sorry! You are not allowed to delete currencies.'], 403);
            }

            $currency = Currency::findOrFail($id);
            
            try {
                // Delete from database
                $oldPayload = $currency->only(['code', 'symbol', 'name', 'decimal_places']);

                $this->approvalService->createRequest(
                    Currency::class,
                    ApprovalRequest::ACTION_DELETE,
                    (string) $currency->id,
                    [],
                    $oldPayload,
                    'Pengajuan delete currency: ' . $currency->code
                );

                return response()->json(['success' => true, 'message' => 'Pengajuan hapus currency berhasil dikirim untuk approval.']);
            } catch (Exception $e) {
                return response()->json(['success' => false, 'message' => 'Failed to submit delete request.']);
            }
        }

        public function deleteMultiple(Request $request)
        {
            // Check if the authenticated user has the required permission to delete currencies
            if (is_null($this->user) || !$this->user->can('basic-data.delete')) {
                return response()->json(['success' => false, 'message' => 'Sorry! You are not allowed to delete currencies.'], 403);
            }

            $ids = $request->input('ids');
            $currencies = Currency::whereIn('id', $ids)->get();

            try {
                foreach ($currencies as $currency) {
                    $this->approvalService->createRequest(
                        Currency::class,
                        ApprovalRequest::ACTION_DELETE,
                        (string) $currency->id,
                        [],
                        $currency->only(['code', 'symbol', 'name', 'decimal_places']),
                        'Pengajuan delete currency: ' . $currency->code
                    );
                }

                return response()->json(['success' => true, 'message' => 'Pengajuan hapus currency berhasil dikirim untuk approval.']);
            } catch (Exception $e) {
                return response()->json(['success' => false, 'message' => 'Failed to submit delete request.']);
            }
        }

        public function dataForDatatables(Request $request)
        {
            // Check if the authenticated user has the required permission to view currencies
            if (is_null($this->user) || !$this->user->can('basic-data.read')) {
                return response()->json(['success' => false, 'message' => 'Sorry! You are not allowed to view currencies.'], 403);
            }

            // Retrieve data from the database
            $query = Currency::query()
                ->select(['id', 'code', 'symbol', 'name', 'decimal_places']);
            $baseCountQuery = Currency::query();

            // Apply search filter if provided
            $search = trim((string) $request->get('search', ''));
            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'LIKE', "%$search%");
                    $q->orWhere('symbol', 'LIKE', "%$search%");
                    $q->orWhere('name', 'LIKE', "%$search%");
                });
            }

            // Apply sorting if provided
            if ($request->has('sortOrder') && !empty($request->get('sortOrder'))) {
                $order  = strtolower((string) $request->get('sortOrder'));
                $column = (string) $request->get('sortField');
                $allowedSort = ['code', 'symbol', 'name', 'decimal_places'];

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

            $totalRecords = $baseCountQuery->count();
            $filteredRecords = $search !== '' ? (clone $query)->count() : $totalRecords;
            $page = max((int) $request->get('page', 1), 1);
            $size = max((int) $request->get('size', 10), 1);

            // Apply pagination if provided
            $data = $query->forPage($page, $size)->get();

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
            // Check if the authenticated user has the required permission to export currencies
            if (is_null($this->user) || !$this->user->can('basic-data.export')) {
                abort(403, 'Sorry! You are not allowed to export currencies.');
            }

            // Get search parameter from request
            $search = $request->get('search');

            return Excel::download(new CurrencyExport($search), 'currency.xlsx');
        }
    }
