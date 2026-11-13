<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class KategoriController extends Controller
{
    public function index()
    {
        return view('kategori.index.index');
    }

     public function search(Request $request)
    {
       $data_search = Kategori::query()
        ->select('id', 'kode', 'name')
        ->orderBy('id')
        ->get();

        return response()->json([
            'status' => 200,
            'data' => $data_search
        ]);
    }

    public function singleView($id)
    {
        $data['data'] = Kategori::with('items.kategori')
                ->where('id', $id)
                ->firstOrFail();
        return view('kategori.single.index', $data);
    }

    public function printPDF($id)
    {
        $data = Kategori::with('items.kategori')
            ->where('id', $id)
            ->firstOrFail();


        $pdf = Pdf::loadView('kategori.pdf.index', compact('data'));

        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('kategori-' . $data->kode . '.pdf');
    }

    public function formView($method, $id = 0)
    {

        if ($method == 'new') {
            $item = [];
        } else {
            $item = Kategori::find($id);
        }
        $data['item'] = $item;
        $data['method'] = $method;
        return view('kategori.form.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method == 'new') {
            $data_item = new Kategori;
            $kode = $request->kode_kategori;
            sleep(3);
        } else {
            $data_item = Kategori::find($id);
            $kode = $data_item->kode;
        }
    
        $data_item->kode = $kode;
        $data_item->name = $request->nama;

        $data_item->save();


        return redirect('kategori');
    }


    public function delete($id)
    {
        Kategori::find($id)->delete();
        return redirect('kategori');
    }
}
