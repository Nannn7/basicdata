<?php

    namespace Modules\Basicdata\Http\Controllers;

    use App\Http\Controllers\Controller;
    use Exception;
    use Illuminate\Http\Request;
    use Maatwebsite\Excel\Facades\Excel;
    use Modules\Basicdata\Exports\HolidayCalendarExport;
    use Modules\Basicdata\Http\Requests\HolidayCalendarRequest;
    use Modules\Basicdata\Models\HolidayCalendar;
    use Illuminate\Support\Facades\Auth;

    class HolidayCalendarController extends Controller
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
            // Check if the authenticated user has the required permission to view holiday calendars
            if (is_null($this->user) || !$this->user->can('basic-data.read')) {
                abort(403, 'Sorry! You are not allowed to view holiday calendars.');
            }

            return view('basicdata::holidaycalendar.index');
        }


        public function store(HolidayCalendarRequest $request)
        {
            // Check if the authenticated user has the required permission to create holiday calendars
            if (is_null($this->user) || !$this->user->can('basic-data.create')) {
                abort(403, 'Sorry! You are not allowed to create holiday calendars.');
            }

            $validate = $request->validated();

            if ($validate) {
                try {
                    HolidayCalendar::create($validate);
                    return redirect()
                        ->route('basicdata.holidaycalendar.index')->with(
                            'success',
                            'Holiday Calendar created successfully',
                        );
                } catch (Exception $e) {
                    return redirect()
                        ->route('basicdata.holidaycalendar.create')->with('error', 'Failed to create Holiday Calendar');
                }
            }
        }

        public function create()
        {
            // Check if the authenticated user has the required permission to create holiday calendars
            if (is_null($this->user) || !$this->user->can('basic-data.create')) {
                abort(403, 'Sorry! You are not allowed to create holiday calendars.');
            }

            return view('basicdata::holidaycalendar.create');
        }

        public function edit($id)
        {
            // Check if the authenticated user has the required permission to update holiday calendars
            if (is_null($this->user) || !$this->user->can('basic-data.update')) {
                abort(403, 'Sorry! You are not allowed to update holiday calendars.');
            }

            $holiday = HolidayCalendar::find($id);
            return view('basicdata::holidaycalendar.create', compact('holiday'));
        }

        public function update(HolidayCalendarRequest $request, $id)
        {
            // Check if the authenticated user has the required permission to update holiday calendars
            if (is_null($this->user) || !$this->user->can('basic-data.update')) {
                abort(403, 'Sorry! You are not allowed to update holiday calendars.');
            }

            $validate = $request->validated();

            if ($validate) {
                try {
                    $holiday = HolidayCalendar::find($id);
                    $holiday->update($validate);
                    return redirect()
                        ->route('basicdata.holidaycalendar.index')->with(
                            'success',
                            'Holiday Calendar updated successfully',
                        );
                } catch (Exception $e) {
                    return redirect()
                        ->route('basicdata.holidaycalendar.edit', $id)->with(
                            'error',
                            'Failed to update Holiday Calendar',
                        );
                }
            }
        }

        public function destroy($id)
        {
            // Check if the authenticated user has the required permission to delete holiday calendars
            if (is_null($this->user) || !$this->user->can('basic-data.delete')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry! You are not allowed to delete holiday calendars.'
                ], 403);
            }

            try {
                $holiday = HolidayCalendar::find($id);
                $holiday->delete();

                return response()->json(['success' => true, 'message' => 'Holiday Calendar deleted successfully']);
            } catch (Exception $e) {
                return response()->json(['success' => false, 'message' => 'Failed to delete Holiday Calendar']);
            }
        }

        public function deleteMultiple(Request $request)
        {
            // Check if the authenticated user has the required permission to delete holiday calendars
            if (is_null($this->user) || !$this->user->can('basic-data.delete')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry! You are not allowed to delete holiday calendars.'
                ], 403);
            }

            $ids = $request->input('ids');
            HolidayCalendar::whereIn('id', $ids)->delete();
            return response()->json(['success' => true, 'message' => 'Holidays deleted successfully']);
        }

        public function dataForDatatables(Request $request)
        {
            // Check if the authenticated user has the required permission to view holiday calendars
            if (is_null($this->user) || !$this->user->can('basic-data.read')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry! You are not allowed to view holiday calendars.'
                ], 403);
            }

            // Retrieve data from the database
            $query = HolidayCalendar::query();

            // Apply search filter if provided
            if ($request->has('search') && !empty($request->get('search'))) {
                $search = $request->get('search');
                $query->where(function ($q) use ($search) {
                    $q->where('date', 'LIKE', "%$search%");
                    $q->orWhere('description', 'LIKE', "%$search%");
                    $q->orWhere('type', 'LIKE', "%$search%");
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
            // Check if the authenticated user has the required permission to export holiday calendars
            if (is_null($this->user) || !$this->user->can('basic-data.export')) {
                abort(403, 'Sorry! You are not allowed to export holiday calendars.');
            }

            // Get search parameter from request
            $search = $request->get('search');

            return Excel::download(new HolidayCalendarExport($search), 'holiday_calendar.xlsx');
        }
    }
