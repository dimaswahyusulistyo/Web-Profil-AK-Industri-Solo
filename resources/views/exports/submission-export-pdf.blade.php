<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Hasil Submission</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18pt; text-transform: uppercase; }
        .header p { margin: 5px 0 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; table-layout: fixed; }
        th { background-color: #f2f2f2; color: #333; font-weight: bold; border: 1px solid #ccc; padding: 8px; text-align: left; }
        td { border: 1px solid #ccc; padding: 8px; vertical-align: top; word-wrap: break-word; }
        .meta { margin-bottom: 10px; }
        .meta b { color: #555; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 8pt; color: #999; border-top: 1px solid #eee; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Hasil Submission</h1>
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    @if($formName)
    <div class="meta">
        <b>Nama Form:</b> {{ $formName }}
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th style="width: 120px;">Waktu</th>
                @foreach($headers as $header)
                    <th>{{ ucwords(str_replace('_', ' ', $header)) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($records as $index => $record)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $record->created_at->format('d/m/Y H:i') }}</td>
                @foreach($headers as $header)
                    <td>
                        @php
                            $val = $record->data[$header] ?? '-';
                            if (is_array($val)) $val = implode(', ', $val);
                            if (str_starts_with($val, 'dynamic-form-uploads/')) $val = '[FILE]';
                        @endphp
                        {{ $val }}
                    </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Halaman <span class="pagenum"></span>
    </div>
</body>
</html>
