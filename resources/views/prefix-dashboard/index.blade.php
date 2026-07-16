<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prefix Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            min-height:100vh;
            background: linear-gradient(135deg,#0f172a,#111827,#020617);
            font-family:'Poppins',sans-serif;
            color:white;
        }
        .bg-blur-1 { position:fixed; width:350px; height:350px; background:#8b5cf6; border-radius:50%; filter:blur(120px); top:-100px; left:-100px; opacity:0.35; z-index:-1; }
        .bg-blur-2 { position:fixed; width:350px; height:350px; background:#f59e0b; border-radius:50%; filter:blur(120px); bottom:-100px; right:-100px; opacity:0.30; z-index:-1; }

        .glass-card {
            background:rgba(255,255,255,0.05);
            border:1px solid rgba(255,255,255,0.08);
            backdrop-filter:blur(14px);
            border-radius:24px;
            box-shadow:0 12px 40px rgba(0,0,0,0.30);
        }
        .page-title {
            font-size:38px; font-weight:700;
            background:linear-gradient(135deg,#f59e0b,#06b6d4);
            -webkit-background-clip:text; -webkit-text-fill-color:transparent;
        }
        .form-control, .form-select {
            background:rgba(255,255,255,0.06) !important;
            border:1px solid rgba(255,255,255,0.10) !important;
            color:white !important; border-radius:12px;
        }
        .form-control::placeholder { color:#94a3b8; }
        .form-control:focus, .form-select:focus {
            background:rgba(255,255,255,0.10) !important;
            border-color:#f59e0b !important; box-shadow:none !important;
        }
        .form-select option { background:#1e293b; color:white; }
        .form-label { color:#cbd5e1; font-size:13px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; }

        .btn-add {
            height:50px; border:none; border-radius:14px;
            background:linear-gradient(135deg,#f59e0b,#fbbf24);
            color:white; font-weight:700; font-size:15px; transition:0.3s;
        }
        .btn-add:hover { transform:translateY(-2px); color:white; }

        .table { color:white !important; background:transparent !important; margin-bottom:0; }
        .table th { border:none; padding:18px 16px; color:#cbd5e1 !important; font-size:13px; font-weight:600; background:transparent !important; text-transform:uppercase; letter-spacing:0.5px; }
        .table td { padding:18px 16px; border-color:rgba(255,255,255,0.06) !important; background:transparent !important; vertical-align:middle; color:white !important; }
        .table tbody tr:hover { background:rgba(255,255,255,0.03) !important; }

        .prefix-badge {
            padding:8px 14px; border-radius:10px;
            background:linear-gradient(135deg,#f59e0b,#fbbf24);
            color:white; font-size:13px; font-weight:700;
            font-family:monospace;
        }
        .model-badge {
            padding:6px 12px; border-radius:8px;
            background:rgba(255,255,255,0.08);
            color:#94a3b8; font-size:12px; font-family:monospace;
        }
        .active-badge   { background:linear-gradient(135deg,#10b981,#14b8a6); padding:6px 12px; border-radius:8px; font-size:12px; font-weight:700; color:white; }
        .inactive-badge { background:rgba(255,255,255,0.08); padding:6px 12px; border-radius:8px; font-size:12px; font-weight:700; color:#64748b; }

        .btn-sm-edit   { background:linear-gradient(135deg,#3b82f6,#06b6d4); border:none; border-radius:10px; padding:7px 14px; font-size:12px; font-weight:600; color:white; }
        .btn-sm-delete { background:linear-gradient(135deg,#ef4444,#f97316); border:none; border-radius:10px; padding:7px 14px; font-size:12px; font-weight:600; color:white; }
        .btn-sm-edit:hover, .btn-sm-delete:hover { transform:translateY(-1px); }

        .alert { border:none; border-radius:14px; font-size:14px; }

        /* Edit modal */
        .modal-content { background:#1e293b; border:1px solid rgba(255,255,255,0.08); border-radius:20px; color:white; }
        .modal-header { border-bottom:1px solid rgba(255,255,255,0.08); }
        .modal-footer { border-top:1px solid rgba(255,255,255,0.08); }
        .btn-close { filter:invert(1); }

        .back-btn {
            height:50px; border:none; border-radius:14px;
            background:rgba(255,255,255,0.06);
            border:1px solid rgba(255,255,255,0.08);
            color:white; font-weight:600; font-size:14px;
            text-decoration:none; display:inline-flex;
            align-items:center; gap:8px; padding:0 20px;
            transition:0.3s;
        }
        .back-btn:hover { background:rgba(255,255,255,0.10); color:white; }
    </style>
</head>
<body>
    <div class="bg-blur-1"></div>
    <div class="bg-blur-2"></div>

    <div class="container py-5">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h1 class="page-title">⚙️ Prefix Dashboard</h1>
                <p class="text-secondary" style="font-size:14px">Manage model ID prefixes without touching code</p>
            </div>
            <a href="{{ route('orders.index') }}" class="back-btn">← Back to Orders</a>
        </div>

        {{-- ALERT --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        {{-- ADD NEW PREFIX FORM --}}
        <div class="glass-card p-4 mb-4">
            <h5 class="mb-4" style="color:#f59e0b;font-weight:700">➕ Add New Prefix</h5>
            <form action="{{ route('prefix.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Label</label>
                        <input type="text" name="label" class="form-control" style="height:48px"
                               placeholder="e.g. Order" value="{{ old('label') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Prefix</label>
                        <input type="text" name="prefix" class="form-control" style="height:48px"
                               placeholder="e.g. ord_" value="{{ old('prefix') }}" required>
                        <small class="text-secondary">Underscore auto-added</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Model Class</label>
                        <select name="model_class" class="form-select" style="height:48px" required>
                            <option value="">-- Select Model --</option>
                            @foreach(config('prefixed_ids.models') as $prefix => $class)
                                <option value="{{ $class }}" {{ old('model_class') === $class ? 'selected' : '' }}>
                                    {{ class_basename($class) }} ({{ $class }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-add w-100">Add Prefix</button>
                    </div>
                </div>
            </form>
        </div>

        {{-- PREFIX TABLE --}}
        <div class="glass-card p-4">
            <h5 class="mb-4" style="color:#06b6d4;font-weight:700">📋 Configured Prefixes</h5>

            @if($configs->isEmpty())
                <div class="text-center py-5">
                    <div style="font-size:50px">⚙️</div>
                    <p class="text-secondary mt-3">No prefixes configured yet. Add one above!</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Label</th>
                                <th>Prefix</th>
                                <th>Model Class</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($configs as $config)
                            <tr>
                                <td style="color:#64748b">{{ $loop->iteration }}</td>
                                <td style="font-weight:600">{{ $config->label }}</td>
                                <td><span class="prefix-badge">{{ $config->prefix }}</span></td>
                                <td><span class="model-badge">{{ class_basename($config->model_class) }}</span></td>
                                <td>
                                    @if($config->is_active)
                                        <span class="active-badge">✅ Active</span>
                                    @else
                                        <span class="inactive-badge">⏸ Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn-sm-edit"
                                            onclick="openEdit({{ $config->id }}, '{{ $config->label }}', '{{ $config->prefix }}', {{ $config->is_active ? 'true' : 'false' }})">
                                            ✏️ Edit
                                        </button>
                                        <form action="{{ route('prefix.destroy', $config->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="btn-sm-delete"
                                                onclick="return confirm('Delete this prefix config?')">
                                                🗑 Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>

    {{-- EDIT MODAL --}}
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="color:#f59e0b">✏️ Edit Prefix</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Label</label>
                            <input type="text" name="label" id="editLabel" class="form-control" style="height:48px" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prefix</label>
                            <input type="text" name="prefix" id="editPrefix" class="form-control" style="height:48px" required>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="editActive" style="width:40px;height:22px">
                                <label class="form-check-label ms-2" for="editActive" style="color:#cbd5e1">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning fw-bold">💾 Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openEdit(id, label, prefix, isActive) {
            document.getElementById('editForm').action = '/prefix-dashboard/' + id;
            document.getElementById('editLabel').value  = label;
            document.getElementById('editPrefix').value = prefix;
            document.getElementById('editActive').checked = isActive;
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }
    </script>
</body>
</html>
