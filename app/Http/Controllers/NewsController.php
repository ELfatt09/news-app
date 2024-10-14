<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;

class NewsController extends Controller
{
    // Menampilkan semua news yang ada
    public function index()
    {
        // Mengambil semua data news dari database
        $Newss = News::latest()->get();
        $page = 'Semua Berita';
        // Mengirim data ke view news.index
        return view('news.index', compact(['Newss', 'page']));
    }

    // Menampilkan news berdasarkan kategori
    public function category($category)
    {
        // Mengambil data news berdasarkan kategori
        $Newss = News::where('category', $category)->latest()->get();
        $page = "Berita Kategori $category";
        // Mengirim data ke view news.index
        return view('news.index', compact(['Newss', 'page']));
    }

    // Menampilkan news berdasarkan author
    public function author($id)
    {
        // Mengambil data user berdasarkan id
        $author = User::findOrFail($id);
        // Mengambil data news berdasarkan author
        $Newss = News::where('author_id', $id)->latest()->get();
        $page = "Berita dari $author->name";
        // Mengirim data ke view news.index
        return view('news.index', compact(['Newss', 'page']));
    }

    // Menampilkan detail news
    public function show($slug)
    {
        // Mengambil data news berdasarkan slug
        $News= News::where('slug', $slug)->first();
        // Meningkatkan views news
        $News->increment('views');
        // Mengirim data ke view news.show
        return view('news.show', compact('News'));
    }

    // Menampilkan form create news
    public function create()
    {
        // Mengirim data ke view news.create
        return view('news.create');
    }

    // Menyimpan data news
    public function store(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'category' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:8048',
        ]);

        // Jika ada file yang diupload
        if ($request->hasFile('image')) {
            // Ambil file dari request
            $image = $request->file('image');
            
            // Buat nama file yang unik (misalnya dengan timestamp)
            $imageName = time() . '_' . $image->getClientOriginalName();
            
            // Tentukan path tujuan di folder public/images
            $destinationPath = public_path('images');
            
            // Pindahkan file ke folder public/images
            $image->move($destinationPath, $imageName);
            
            // Tentukan path untuk disimpan ke database
            $imagePath = 'images/' . $imageName; 
        } else {
            $imagePath = null;
        }
        

        // Buat news baru
        $News= News::create([
            'title' => $request->title,
            'body' => $request->body,
            'category' => $request->category,
            'image_path' => env('APP_URL') . '/' . $imagePath,
            'slug' => Str::slug($request->title) . '-' . (News::count() + 1),
            'author_id' => Auth::id()
        ]);

        return redirect()->route('news.index')->with('success', 'News created successfully');
    }

    // Menampilkan form edit news
    public function edit($slug)
    {
        $News= News::where('slug', $slug)->first();

        // Jika bukan author yang sebenarnya maka abort
        if ($News->author_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('news.edit', compact('News'));
    }
    // Mengupdate data news
    public function update(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'category' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:8048',
            'id' => 'integer',
        ]);
        $News= News::findOrFail($request->id);

        // Jika bukan author yang sebenarnya maka abort
        if ($News->author_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Jika ada file yang diupload
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($News->image_path) {
                $oldImage = substr($News->image_path, strrpos($News->image_path, '/') + 1);
                // Hapus gambar lama, @ di depannya untuk mengabaikan error jika file tidak ditemukan
                @unlink(public_path('images/' . $oldImage));
            }

            // Ambil file dari request
            $image = $request->file('image');

            // Buat nama file yang unik (misalnya dengan timestamp)
            $imageName = time() . '_' . $image->getClientOriginalName();

            // Tentukan path tujuan di folder public/images
            $destinationPath = public_path('images');

            // Pindahkan file ke folder public/images
            $image->move($destinationPath, $imageName);

            // Tentukan path untuk disimpan ke database
            $imagePath = env('APP_URL') . '/images/' . $imageName;
        } else {
            $imagePath = $News->image_path;
        }

        // Update data news
        $News->update([
            'title' => $request->title,
            'body' => $request->body,
            'slug' => Str::slug($request->title) . '-' . $News->id,
            'category' => $request->category,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('news.index')->with('success', 'News updated successfully');
    }

    // Menghapus data news
    public function destroy(Request $request)
    {
        $News= News::findOrFail($request->id);

        // Jika bukan author yang sebenarnya maka abort
        if ($News->author_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $News->delete();

        return redirect()->route('news.index')->with('success', 'News deleted successfully');
    }
}