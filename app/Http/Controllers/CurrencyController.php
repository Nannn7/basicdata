<?php

    namespace Modules\Basicdata\Http\Controllers;

    use App\Http\Controllers\Controller;
    use Exception;
    use Illuminate\Http\Request;
    use Maatwebsite\Excel\Facades\Excel;
    use Modules\Basicdata\Exports\CurrencyExport;
    use Modules\Basicdata\Http\Requests\CurrencyRequest;
    use Modules\Basicdata\Models\Currency;

    class CurrencyController extends Controller
    {
        protected $user;

        public function __construct()
        {
             $this->user = Auth::guard('web')->user();
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
                    // Save to database
                    Currency::create($validate);
                    return redirect()
                        ->route('basicdata.currency.index')
                        ->with('success', 'Currency created successfully');
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
                    // Update in database
                    $currency = Currency::find($id);
                    $currency->update($validate);
                    return redirect()
                        ->route('basicdata.currency.index')
                        ->with('success', 'Currency updated successfully');
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

            try {
                // Delete from database
                $currency = Currency::find($id);
                $currency->delete();

                return response()->json(['success' => true, 'message' => 'Currency deleted successfully']);
            } catch (Exception $e) {
                return response()->json(['success' => false, 'message' => 'Failed to delete currency']);
            }
        }

        public function deleteMultiple(Request $request)
        {
            // Check if the authenticated user has the required permission to delete currencies
            if (is_null($this->user) || !$this->user->can('basic-data.delete')) {
                return response()->json(['success' => false, 'message' => 'Sorry! You are not allowed to delete currencies.'], 403);
            }

            $ids = $request->input('ids');
            Currency::whereIn('id', $ids)->delete();
            return response()->json(['success' => true, 'message' => 'Currencies deleted successfully']);
        }

        public function dataForDatatables(Request $request)
        {
            // Check if the authenticated user has the required permission to view currencies
            if (is_null($this->user) || !$this->user->can('basic-data.read')) {
                return response()->json(['success' => false, 'message' => 'Sorry! You are not allowed to view currencies.'], 403);
            }

            // Retrieve data from the database
            $query = Currency::query();

            // Apply search filter if provided
            if ($request->has('search') && !empty($request->get('search'))) {
                $search = $request->get('search');
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'LIKE', "%$search%");
                    $q->orWhere('symbol', 'LIKE', "%$search%");
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

            // Calculate the page count
            $pageCount = ceil($filteredRecords / ($request->get('size') ?: 1));

            // Calculate the current page number
            $currentPage = $request->get('page') ?: 1;

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
