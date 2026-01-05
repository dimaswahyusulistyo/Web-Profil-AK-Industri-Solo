@php
    $data = $getRecord()->data;
@endphp

<div class="space-y-8">
    @foreach($data as $label => $value)
        @if($value !== null && $value !== '')
            <div class="flex flex-col">
                {{-- Field Header/Label --}}
                <div class="flex items-center px-5 py-4 bg-gray-100 border-x border-t rounded-t-xl">
                    <div>
                        <h3 class="text-sm font-bold text-gray-700 uppercase tracking-widest leading-none">
                            {{ str_replace('_', ' ', $label) }}
                        </h3>
                    </div>
                </div>

                {{-- Field Content --}}
                <div class="w-full bg-white border border-gray-200 shadow-sm overflow-hidden rounded-b-xl">
                    @if(is_string($value) && Str::startsWith($value, 'dynamic-form-uploads/'))
                        @php
                            $state = $value;
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

                        @if($isImage)
                            <div class="bg-gray-50 flex items-center justify-center p-4">
                                <img src="{{ $url }}" alt="Preview" class="max-w-full h-auto shadow-lg rounded-lg" style="max-height: 2500px;">
                            </div>
                        @elseif($isPdf)
                            <div class="w-full h-[800px]">
                                <iframe src="{{ $url }}#view=FitW" class="w-full h-full border-0" style="width: 100%; min-height: 1500px;"></iframe>
                            </div>
                        @elseif($isWord)
                            <div class="flex flex-col items-center justify-center p-12 bg-white text-center">
                                <p class="text-lg text-gray-500 max-w-2xl mx-auto leading-tight mb-8 italic font-medium">Browser tidak dapat menampilkan pratinjau langsung untuk file Word secara native.</p>
                                <a href="{{ $url }}" download class="px-8 py-4 bg-black hover:bg-gray-900 text-white text-lg font-black rounded-full shadow-lg transition-all active:scale-95 uppercase tracking-widest">
                                     CLICK TO DOWNLOAD WORD FILE
                                </a>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center p-12 bg-white text-center">
                                 <h3 class="text-2xl font-black text-gray-900 mb-8 uppercase tracking-tighter leading-none">ARSIP LAMPIRAN ({{ $extension }})</h3>
                                <a href="{{ $url }}" download class="px-8 py-4 bg-black hover:bg-gray-800 text-white text-lg font-black rounded-full shadow-lg transition-all uppercase tracking-widest">
                                     DOWNLOAD FILE
                                </a>
                            </div>
                        @endif
                    @else
                        {{-- Regular Text/Array field display --}}
                        <div class="p-6">
                            @if(is_array($value))
                                <ul class="list-disc list-inside space-y-2 text-gray-700">
                                    @foreach($value as $v)
                                        <li class="text-sm font-medium">{{ $v }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-base text-gray-800 font-medium leading-relaxed">
                                    {!! nl2br(e($value)) !!}
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        @endif
    @endforeach
</div>

