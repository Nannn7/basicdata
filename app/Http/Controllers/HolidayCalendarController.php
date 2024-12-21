<?php

    namespace Modules\Basicdata\Http\Controllers;

    use App\Http\Controllers\Controller;
    use Exception;
    use Illuminate\Http\Request;
    use Maatwebsite\Excel\Facades\Excel;
    use Modules\Basicdata\Exports\HolidayCalendarExport;
    use Modules\Basicdata\Http\Requests\HolidayCalendarRequest;
    use Modules\Basicdata\Models\HolidayCalendar;

    class HolidayCalendarController extends Controller
    {
        public $user;

        public function index()
        {
            return view('basicdata::holidaycalendar.index');
        }

        public function store(HolidayCalendarRequest $request)
        {
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
            return view('basicdata::holidaycalendar.create');
        }

        public function edit($id)
        {
            $holiday = HolidayCalendar::find($id);
            return view('basicdata::holidaycalendar.create', compact('holiday'));
        }

        public function update(HolidayCalendarRequest $request, $id)
        {
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
            try {
                $holiday = HolidayCalendar::find($id);
                $holiday->delete();
                return redirect()
                    ->route('basicdata.holidaycalendar.index')->with(
                        'success',
                        'Holiday Calendar deleted successfully',
                    );
            } catch (Exception $e) {
                return redirect()
                    ->route('basicdata.holidaycalendar.index')->with('error', 'Failed to delete Holiday Calendar');
            }
        }

        public function deleteMultiple(Request $request)
        {
            $ids = $request->input('ids');
            HolidayCalendar::whereIn('id', $ids)->delete();
            return response()->json(['message' => 'Holidays deleted successfully']);
        }

        public function dataForDatatables(Request $request)
        {
            if (is_null($this->user) || !$this->user->can('currency.view')) {
                //abort(403, 'Sorry! You are not allowed to view users.');
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
            return Excel::download(new HolidayCalendarExport, 'holiday_calendar.xlsx');
        }
    }
