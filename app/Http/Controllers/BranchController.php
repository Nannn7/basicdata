<?php

    namespace Modules\Basicdata\Http\Controllers;

    use App\Http\Controllers\Controller;
    use Exception;
    use Illuminate\Http\Request;
    use Maatwebsite\Excel\Facades\Excel;
    use Modules\Lpj\Exports\BranchExport;
    use Modules\Lpj\Http\Requests\BranchRequest;
    use Modules\Lpj\Models\Branch;

    class BranchController extends Controller
    {
        public $user;

        public function index()
        {
            return view('basicdata::branch.index');
        }

        public function store(BranchRequest $request)
        {
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
            return view('basicdata::branch.create');
        }

        public function edit($id)
        {
            $branch = Branch::find($id);
            return view('basicdata::branch.create', compact('branch'));
        }

        public function update(BranchRequest $request, $id)
        {
            $validate = $request->validated();

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
            try {
                // Delete from database
                $branch = Branch::find($id);
                $branch->delete();

                echo json_encode(['success' => true, 'message' => 'Branch deleted successfully']);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Failed to delete branch']);
            }
        }

        public function dataForDatatables(Request $request)
        {
            if (is_null($this->user) || !$this->user->can('branch.view')) {
                //abort(403, 'Sorry! You are not allowed to view users.');
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
            return Excel::download(new BranchExport, 'branch.xlsx');
        }
    }
