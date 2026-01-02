<div class="p-4 bg-white border rounded-lg shadow-sm">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="border-b bg-gray-50">
                <th class="p-2 font-bold text-gray-700">Field</th>
                <th class="p-2 font-bold text-gray-700">Value</th>
            </tr>
        </thead>
        <tbody>
            @foreach($getRecord()->data as $label => $value)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-2 font-medium text-gray-600 uppercase text-xs tracking-wider">{{ str_replace('_', ' ', $label) }}</td>
                    <td class="p-2 text-gray-800">
                        @if(is_array($value))
                            <ul class="list-disc ml-4">
                                @foreach($value as $v)
                                    <li>{{ $v }}</li>
                                @endforeach
                            </ul>
                        @elseif(Str::startsWith($value, 'dynamic-form-uploads/') || filter_var($value, FILTER_VALIDATE_URL))
                            <a href="{{ Storage::url($value) }}" target="_blank" class="text-blue-600 hover:underline flex items-center gap-2">
                                <span>Lihat Dokumen</span>
                            </a>
                        @else
                            {{ $value }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
