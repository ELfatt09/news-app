@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Edit a News Article</h2>
    <!-- form untuk mengedit berita -->
    <form method="post" action="{{ route('news.update') }}" enctype="multipart/form-data">
        <!-- method PATCH untuk mengupdate data -->
        @method('PATCH')
        <!-- token untuk melindungi dari serangan CSRF -->
        @csrf
        <!-- input hidden untuk menyimpan id berita -->
        <input type="hidden" name="id" value="{{ $News->id }}">
        <div class="form-group mb-3">
            <!-- input untuk mengedit judul berita -->
            <input type="text" style="font-size: calc(1.2rem + 2.3vw);
    font-weight: 300;
    line-height: 1.2; text-align: center;" class="form-control @error('title') is-invalid @enderror" id="headline" placeholder="Enter news headline" required name="title" value="{{ old('title', $News->title) }}">
            <!-- jika ada error pada input title, maka tampilkan error message -->
            @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <!-- select untuk mengedit kategori berita -->
            <select style="text-align: center;"class="form-control @error('category') is-invalid @enderror" id="category" required name="category">
                <!-- option pertama harus disabled dan selected, agar tidak ada pilihan yang dipilih -->
                <option value="{{ $News->category }}" selected>{{ $News->category }}</option>
                <!-- option lainnya untuk memilih kategori berita -->
                <option value="Education">Education</option>
                <option value="Politics">Politics</option>
                <option value="Economy">Economy</option>
                <option value="Technology">Technology</option>
                <option value="Health">Health</option>
                <option value="Sports">Sports</option>
                <option value="Environment">Environment</option>
                <option value="Crime-&-Law">Crime & Law</option>
                <option value="International">International</option>
                <option value="Entertainment">Entertainment</option>
                <option value="Science">Science</option>
                <option value="Security">Security</option>
                <option value="Transportation">Transportation</option>
                <option value="Religion">Religion</option>
                <option value="Social-Issues">Social Issues</option>
            </select>
            <!-- jika ada error pada input category, maka tampilkan error message -->
            @error('category')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="input-group mb-4" align="center">
            <!-- input file untuk mengupload gambar -->
            <div class="custom-file">
                <label class="custom-file-label" for="image">Change Header Image:</label>
                <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" onchange="previewImage(this)">
            </div>
            <!-- jika ada error pada input image, maka tampilkan error message -->
            <div class="invalid-feedback">
                @error('image')
                    <strong>{{ $message }}</strong>
                @enderror
            </div>
        </div>
        <div class="bg-gray mb-4" align="center">
            <!-- preview gambar yang diupload -->
            <img id="preview"src="{{ $News->image_path ? url($News->image_path) : '' }}" class="rounded-start my-auto"  style="max-height: 500px; height: 100%;">
         </div>        
         <script>
            function previewImage(input) {
                const preview = document.getElementById('preview');
                preview.src = URL.createObjectURL(input.files[0]);
            }
        </script>

        <div class="form-group mn-3">
            <!-- textarea untuk mengedit isi berita -->
            <textarea style="font-size: 1.5rem; font-weight:300;" class="form-control @error('body') is-invalid @enderror" id="content" rows="15" placeholder="Write your news content here..." required name="body">{{ old('body', $News->body) }}</textarea>
            <!-- jika ada error pada input body, maka tampilkan error message -->
            @error('body')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- tombol submit untuk mengedit berita -->
        <button type="submit" class="btn btn-lg btn-dark">Edit News</button>
    </form>
</div>
@endsection


