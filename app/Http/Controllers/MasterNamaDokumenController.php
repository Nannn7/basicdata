<?php

    namespace Modules\Basicdata\Http\Controllers;

    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\Controller;
    use Exception;
    use Illuminate\Http\Request;
    use Maatwebsite\Excel\Facades\Excel;
    use Modules\Basicdata\Exports\MasterNamaDokumenExport;
    use Modules\Basicdata\Http\Requests\MasterNamaDokumenRequest;
    use Modules\Basicdata\Models\MasterNamaDokumen;

    class MasterNamaDokumenController extends Controller
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
                abort(403, 'Sorry! You are not allowed to view master nama dokumen.');
            }

            return view('basicdata::master-nama-dokumen.index');
        }

        public function create()
        {
            if (is_null($this->user) || !$this->user->can('basic-data.create')) {
                abort(403, 'Sorry! You are not allowed to create master nama dokumen.');
            }

            return view('basicdata::master-nama-dokumen.create');
        }

        public function store(MasterNamaDokumenRequest $request)
        {
            if (is_null($this->user) || !$this->user->can('basic-data.create')) {
                abort(403, 'Sorry! You are not allowed to create master nama dokumen.');
            }

            $validate = $request->validated();

            // Simpan jenis_pengikatan dalam huruf besar
            $validate['jenis_pengikatan'] = strtoupper($validate['jenis_pengikatan']);

            try {
                MasterNamaDokumen::create($validate);
                return redirect()
                    ->route('basicdata.master-nama-dokumen.index')
                    ->with('success', 'Master Nama Dokumen created successfully');
            } catch (Exception $e) {
                return redirect()
                    ->route('basicdata.master-nama-dokumen.create')
                    ->with('error', 'Failed to create Master Nama Dokumen');
            }
        }

        public function edit($id)
        {
            if (is_null($this->user) || !$this->user->can('basic-data.update')) {
                abort(403, 'Sorry! You are not allowed to update master nama dokumen.');
            }

            $masterNamaDokumen = MasterNamaDokumen::findOrFail($id);
            return view('basicdata::master-nama-dokumen.create', compact('masterNamaDokumen'));
        }

        public function update(MasterNamaDokumenRequest $request, $id)
        {
            if (is_null($this->user) || !$this->user->can('basic-data.update')) {
                abort(403, 'Sorry! You are not allowed to update master nama dokumen.');
            }

            $validate = $request->validated();

            // Simpan jenis_pengikatan dalam huruf besar
            $validate['jenis_pengikatan'] = strtoupper($validate['jenis_pengikatan']);

            try {
                $masterNamaDokumen = MasterNamaDokumen::findOrFail($id);
                $masterNamaDokumen->update($validate);
                return redirect()
                    ->route('basicdata.master-nama-dokumen.index')
                    ->with('success', 'Master Nama Dokumen updated successfully');
            } catch (Exception $e) {
                return redirect()
                    ->route('basicdata.master-nama-dokumen.edit', $id)
                    ->with('error', 'Failed to update Master Nama Dokumen');
            }
        }

        public function destroy($id)
        {
            if (is_null($this->user) || !$this->user->can('basic-data.delete')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry! You are not allowed to delete master nama dokumen.'
                ], 403);
            }

            try {
                $masterNamaDokumen = MasterNamaDokumen::findOrFail($id);
                $masterNamaDokumen->delete();
                return response()->json(['success' => true, 'message' => 'Master Nama Dokumen deleted successfully']);
            } catch (Exception $e) {
                return response()->json(['success' => false, 'message' => 'Failed to delete Master Nama Dokumen']);
            }
        }

        public function deleteMultiple(Request $request)
        {
            if (is_null($this->user) || !$this->user->can('basic-data.delete')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry! You are not allowed to delete master nama dokumen.'
                ], 403);
            }

            $ids = $request->input('ids');
            MasterNamaDokumen::whereIn('id', $ids)->delete();
            return response()->json(['success' => true, 'message' => 'Master Nama Dokumen deleted successfully']);
        }

        public function dataForDatatables(Request $request)
        {
            if (is_null($this->user) || !$this->user->can('basic-data.read')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry! You are not allowed to view master nama dokumen.'
                ], 403);
            }

            $query = MasterNamaDokumen::query();

            if ($request->has('search') && !empty($request->get('search'))) {
                $search = json_decode($request->get('search'));

                if (isset($search->search)) {
                    $search_ = strtolower($search->search);
                    $query->where(function ($q) use ($search_) {
                        $q->whereRaw('LOWER(kode_produk) LIKE ?', ['%' . $search_ . '%']);
                        $q->orWhereRaw('LOWER(jenis_pengikatan) LIKE ?', ['%' . $search_ . '%']);
                        $q->orWhereRaw('LOWER(dokumen_pengikatan) LIKE ?', ['%' . $search_ . '%']);
                    });
                }

                if (isset($search->jenis_pengikatan) && !empty($search->jenis_pengikatan)) {
                    $query->where('jenis_pengikatan', $search->jenis_pengikatan);
                }
            }

            if ($request->has('sortOrder') && !empty($request->get('sortOrder'))) {
                $order  = $request->get('sortOrder');
                $column = $request->get('sortField');
                $query->orderBy($column, $order);
            }

            $totalRecords = $query->count();

            if ($request->has('page') && $request->has('size')) {
                $page   = $request->get('page');
                $size   = $request->get('size');
                $offset = ($page - 1) * $size;
                $query->skip($offset)->take($size);
            }

            $filteredRecords = $query->count();
            $data = $query->get();

            $data = $data->map(function ($item) {
                return [
                    'id'                  => $item->id,
                    'kode_produk'         => $item->kode_produk,
                    'jenis_pengikatan'    => $item->jenis_pengikatan,
                    'dokumen_pengikatan'  => $item->dokumen_pengikatan,
                    'nomor'               => $item->nomor,
                    'tgl_mulai'           => $item->tgl_mulai,
                    'tgl_jtempo'          => $item->tgl_jtempo,
                    'atas_nama'           => $item->atas_nama,
                    'peringkat'           => $item->peringkat,
                    'nominal'             => $item->nominal,
                    'keterangan'          => $item->keterangan,
                    'atas_dep'            => $item->atas_dep,
                    'notaris'             => $item->notaris,
                    'atas_sertifikat'     => $item->atas_sertifikat,
                    'objek'               => $item->objek,
                    'bukti_hak'           => $item->bukti_hak,
                    'nomor_spk'           => $item->nomor_spk,
                    'tgl_spk'             => $item->tgl_spk,
                    'nama_lo'             => $item->nama_lo,
                    'nama_ao'             => $item->nama_ao,
                    'jenis_pinjaman'      => $item->jenis_pinjaman,
                    'no_fasilitas'        => $item->no_fasilitas,
                    'alamat'              => $item->alamat,
                    'developer'           => $item->developer,
                    'tgljtcover'          => $item->tgljtcover,
                    'tglawcover'          => $item->tglawcover,
                    'nocovernote'         => $item->nocovernote,
                    'agunan'              => $item->agunan,
                    'tgldoc_lengkap'      => $item->tgldoc_lengkap,
                    'tgldoc_terima'       => $item->tgldoc_terima,
                ];
            });

            $pageCount   = ceil($totalRecords / max(1, $request->get('size')));
            $currentPage = $request->get('page') ?: 1;

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
            if (is_null($this->user) || !$this->user->can('basic-data.export')) {
                abort(403, 'Sorry! You are not allowed to export master nama dokumen.');
            }

            $search          = $request->get('search');
            $jenisPengikatan = $request->get('jenis_pengikatan');

            return Excel::download(new MasterNamaDokumenExport($search, $jenisPengikatan), 'master_nama_dokumen.xlsx');
        }
    }
