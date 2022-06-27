<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Exports\EmployeeExport;
use App\Imports\EmployeeImport;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;



class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('search')){
            $data = Employee::where('nama','LIKE', '%' .$request->search.'%')->paginate(5);
        }else {
            $data = Employee::paginate(5);
        }
        

        return view('datapegawai',compact('data'));
    }

    public function tambahpegawai()
    {
        // crud untuk tampildata
        $data = Employee::all();
        return view('tambahpegawai');
    }

    public function insertdata(Request $request)
    {
        //dd($request->all());
        $data = Employee::create($request->all());

        // untuk inputkan file foto 
        if ($request->hasFile('foto')) {
            // meletakkan foto di dalam folder
            $request->file('foto')->move('fotopegawai/', $request->file('foto')->getClientOriginalName());
            // ambil nama foto
            $data->foto = $request->file('foto')->getClientOriginalName();
            // data foto di simpan
            $data->save();
        }

        return redirect()->route('pegawai')->with('success', 'Data Berhasil Di Tambahkan');
    }

    public function tampildata($id)
    {
        $data = Employee::find($id);
        // dd($data);

        return view('tampilpegawai',compact('data'));
    }

    public function updatedata(Request $request, $id)
    {
        // mencari data 
        $data = Employee::find($id);
        // lalu data diupdate
        $data->update($request->all());
        return redirect()->route('pegawai')->with('success', 'Data Berhasil Di Update');
    }

    public function delete($id)
    {
         $data = Employee::find($id);
         // lalu data dihapus
         $data->delete();
         // menampilkan halaman pegawai validasi data berhasil dihapus
         return redirect()->route('pegawai')->with('success', 'Data Berhasil Di Hapus');
    }

    public function exportpdf()
    {
        $data = Employee::all();

        view()->share('data', $data);
        $pdf = PDF::loadview('datapegawai-pdf');
        return $pdf->download('data.pdf');
    }

    public function exportexcel()
    {
        return Excel::download(new EmployeeExport, 'datapegawai.xlsx');
    }

    public function importexcel(Request $request)
    {
        $data = $request->file('file');

        $namafile = $data->getClientOriginalName();
        $data->move('EmployeeData', $namafile);

        Excel::import(new Employeeimport, \public_path('/EmployeeData/'.$namafile)); 
        return \redirect()->back();

    }

}
