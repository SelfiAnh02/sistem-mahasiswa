<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col">
                <h1 class="h3 text-dark mb-0">
                    <i class="fas fa-users text-primary"></i>
                    Data Mahasiswa
                </h1>
                <p class="text-muted">Kelola data mahasiswa dengan mudah</p>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Search & Action Bar -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('mahasiswa.index') }}" class="d-flex">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" 
                                       name="search" 
                                       class="form-control border-start-0" 
                                       placeholder="Cari nama atau NIM..."
                                       value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('mahasiswa.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Tambah Mahasiswa
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0">
                            <i class="fas fa-list text-primary"></i>
                            Daftar Mahasiswa
                        </h6>
                    </div>
                    <div class="col-auto">
                        <small class="text-muted">
                            Total: {{ $mahasiswa->total() }} data
                        </small>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                @if($mahasiswa->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="5%" class="text-center">#</th>
                                <th width="15%">NIM</th>
                                <th width="25%">Nama</th>
                                <th width="35%">Alamat</th>
                                <th width="20%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mahasiswa as $index => $mhs)
                            <tr>
                                <td class="text-center text-muted">
                                    {{ $mahasiswa->firstItem() + $index }}
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $mhs->nim }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-2">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                        <div>
                                            <span class="fw-medium">{{ $mhs->nama }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ Str::limit($mhs->alamat, 50) }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('mahasiswa.show', $mhs) }}" 
                                           class="btn btn-outline-info" 
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('mahasiswa.edit', $mhs) }}" 
                                           class="btn btn-outline-warning" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" 
                                              action="{{ route('mahasiswa.destroy', $mhs) }}" 
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus data {{ $mhs->nama }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-outline-danger" 
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-users fa-3x text-muted"></i>
                    </div>
                    <h5 class="text-muted">Belum Ada Data Mahasiswa</h5>
                    <p class="text-muted mb-4">
                        @if(request('search'))
                            Tidak ada data yang cocok dengan pencarian "{{ request('search') }}"
                        @else
                            Mulai tambahkan data mahasiswa untuk melihat daftar di sini
                        @endif
                    </p>
                    @if(request('search'))
                        <a href="{{ route('mahasiswa.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    @endif
                    <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Mahasiswa
                    </a>
                </div>
                @endif
            </div>

            

            <!-- Pagination -->
            @if($mahasiswa->count() > 0)
            <div class="card-footer bg-white">
                <div class="row align-items-center">
                    <div class="col">
                        <small class="text-muted">
                            Menampilkan {{ $mahasiswa->firstItem() }} - {{ $mahasiswa->lastItem() }} 
                            dari {{ $mahasiswa->total() }} data
                        </small>
                    </div>
                    <div class="col-auto">
                        {{ $mahasiswa->withQueryString()->links() }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        .avatar-sm {
            width: 35px;
            height: 35px;
        }
        
        .table th {
            font-weight: 600;
            color: #495057;
            border-top: none;
        }
        
        .btn-group-sm .btn {
            padding: 0.375rem 0.5rem;
        }
        
        .card {
            border: none;
            border-radius: 10px;
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(0,123,255,0.05);
        }
        
        .alert {
            border-radius: 10px;
        }
        
        .badge {
            font-size: 0.75em;
            padding: 0.375rem 0.75rem;
        }
    </style>
</body>
</html>