@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white fw-bold">✏️ Edit Novel</div>
        <div class="card-body">
            <form action="{{ route('admin.update', $novel->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Judul Novel</label>
                    <input type="text" name="judul" class="form-control" value="{{ $novel->judul }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" value="{{ $novel->harga }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" value="{{ $novel->stok }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Rating</label>
                        <input type="number" step="0.1" name="rating" class="form-control" value="{{ $novel->rating }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Sinopsis</label>
                    <textarea name="sinopsis" class="form-control" rows="4">{{ $novel->sinopsis }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ganti Cover (Kosongkan jika tidak ingin ganti)</label>
                    <input type="file" name="gambar" class="form-control">
                </div>

                <hr>
                <button type="submit" class="btn btn-primary px-4">Update Novel</button>
                <a href="{{ route('admin.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection