<x-app-layout>
    <div class="w-full flex justify-center min-h-screen bg-white" x-data="print">
        <div class="w-4/6 h-screen flex flex-col gap-2 p-5" x-ref="main">
            <div class="flex items-center justify-between bg-gray-200 rounded-lg p-5" x-ref="header">
                <div class="flex items-center gap-5">
                    <a href="{{ route('events.show', ['event' => $event->id]) }}" class="btn-generic"><i
                            class="fi fi-rr-arrow-left"></i></a>
                    <h1 class="panel-title capitalize">Evaluation Form</h1>
                </div>
                <button class="btn btn-accent" @click="printComponent">
                    Print
                    <i class="fi fi-rr-print text-xl"></i>
                </button>
            </div>


            <div class="h-auto w-full p-5 flex flex-col gap-5 ">
                <div class="w-full flex justify-center items-center">
                    <div class="flex items-center gap-5">
                        <img src="{{ asset('logo.png') }}" alt="" srcset=""
                            class="h-12 w-12 object object-center">
                        <div>
                            <p class="text-gray-600 text-center text-sm">
                                Republic of the Philippines
                            </p>
                            <h1 class="text-2xl font-bold flex flex-col items-center">
                                <span class="text-3xl">
                                    Cavite State University
                                </span>

                                 <span class="text-sm">Bacoor City Campus</span> </h1>
                            <p class="text-gray-600 text-center text-xs font-bold">
                                Soldiers Hills IV, Molino VI, Bacoor City, Cavite
                            </p>
                            <p class="text-gray-600 text-center text-xs">
                               DEPARTMENT OF COMPUTER STUDIES
                            </p>
                        </div>
                    </div>
                </div>
                <div class="w-full items-center justify-between hidden" x-ref="reportHeader">
                    <h1 class="text-lg font-bold">Event Report</h1>
                    <h1 class="text-lg font-semibold">Generated: {{ now()->format('F d, Y') }}</h1>
                </div>
                <div class="flex items-center justify-between">
                    <label for="" class="input-generic-label">
                        <span>*</span>
                        This the evaluation form preview
                    </label>
                    <div class="flex items-center gap-2">

                    </div>
                </div>
                <div class="flex flex-col gap-2 min-h-64 relative">
                    <div class="w-full h-auto p-2 rouned-lg bg-base-100 flex justify-center">
                        <h1 class="text-4xl font-bold tracking-widest">{{ $form->title }}</h1>
                    </div>
                    <div class="flex flex-col gap-2">
                        @foreach ($form->fields as $field)
                            <label for="" class="input-generic-label">{{ $field->question }}</label>
                            @if ($field->input_type !== 'radio')
                                <input type="{{ $field->input_type }}" class="input-generic">
                            @else
                                <div class="flex items-center gap-5">
                                    @for ($i = 1; $i <= $field->radio_max; $i++)
                                        <div class="flex flex-col items-center">
                                            <input type="radio" name="radio-4" class="radio radio-accent"
                                                value="{{ $i }}" />
                                            <span>{{ $i }}</span>
                                        </div>
                                    @endfor
                                </div>
                            @endif
                        @endforeach


                        <h1 class="panel-label text-lg font-bold">
                            Hosts
                        </h1>
                        @foreach ($form->speakers as $speaker)
                            <h1 class="font-bold capitalize">
                                Host: {{ $speaker->name }}
                            </h1>
                            @foreach ($speaker->fields as $s_field)
                                <label for="" class="input-generic-label">{{ $s_field->question }}</label>
                                @if ($field->input_type !== 'radio')
                                    <input type="{{ $s_field->input_type }}" class="input-generic">
                                @else
                                    <div class="flex items-center gap-5">
                                        @for ($i = 1; $i <= $s_field->radio_max; $i++)
                                            <div class="flex flex-col items-center">
                                                <input type="radio" name="radio-4" class="radio radio-accent"
                                                    value="{{ $i }}" />
                                                <span>{{ $i }}</span>
                                            </div>
                                        @endfor
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                    <div class=" absolute z-10 top-0 h-full w-full ">
                        <div class="w-full h-full hidden hover:flex justify-center items-center">
                            <h1 class="btn btn-accent">Evaluation Will Start at the end of the Event</h1>
                        </div>
                    </div>
                </div>
                <div class="mt-24 w-full flex justify-end">
                    <div class="flex flex-col gap-2 w-auto h-auto">
                        <span class="border-b-2 border-black"></span>
                        <h1 class="text-center font-bold">Prepared By: {{ Auth::user()->name }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
