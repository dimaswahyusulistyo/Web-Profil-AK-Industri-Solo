<div class="w-full pb-4">
    @php
        $state = $getState();
        if (!$state) {
            $extension = null;
        } else {
            $extension = pathinfo($state, PATHINFO_EXTENSION);
        }
        $url = asset('storage/' . $state);
        
        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        $isPdf = strtolower($extension) === 'pdf';
        $isWord = in_array(strtolower($extension), ['doc', 'docx']);
    @endphp

    @if(!$state)
        <div class="p-8 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200 text-center">
            <p class="text-gray-500 font-medium text-lg uppercase tracking-widest text-sm">Tidak ada lampiran data dukung</p>
        </div>
    @else
        <div class="flex flex-col">
            {{-- Content --}}
            <div class="w-full bg-white border shadow-2xl overflow-hidden rounded-xl">
                @if($isImage)
                    <div class="bg-gray-200">
                        <img src="{{ $url }}" alt="Preview" class="w-full h-auto shadow-2xl block mx-auto" style="max-height: 2500px;">
                    </div>
                @elseif($isPdf)
                    <div class="w-full h-[1000px]">
                        <iframe src="{{ $url }}#view=FitW" class="w-full h-full border-0" style="width: 100%; min-height: 1000px;"></iframe>
                    </div>
                @elseif($isWord)
                    <div class="flex flex-col items-center justify-center p-20 bg-white text-center">
                        <p class="text-xl text-gray-500 max-w-2xl mx-auto leading-tight mb-12 italic font-medium">Browser tidak dapat menampilkan pratinjau langsung untuk file Word secara native.</p>
                        <a href="{{ $url }}" download class="px-12 py-6 bg-black hover:bg-gray-900 text-white text-xl font-black rounded-full shadow-2xl transition-all active:scale-95 uppercase tracking-widest">
                             CLICK TO DOWNLOAD WORD FILE
                        </a>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center p-20 bg-white text-center">
                         <h3 class="text-2xl font-black text-gray-900 mb-10 uppercase tracking-tighter leading-none text-sm">ARSIP LAMPIRAN ({{ $extension }})</h3>
                        <a href="{{ $url }}" download class="px-12 py-6 bg-black hover:bg-gray-800 text-white text-xl font-black rounded-full shadow-2xl transition-all uppercase tracking-widest">
                             DOWNLOAD FILE
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
