<!DOCTYPE html>
<html>
<head>
    <title>Import Pegawai</title>
</head>
<body>
    <h2>Import Data Pegawai dari Excel</h2>

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    <form action="{{ route('import.users') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit">Import</button>
    </form>
</body>
</html>
